<?php

namespace Modules\Frontend\App\Repositories\Home;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Matchish\ScoutElasticSearch\MixedSearch;
use Modules\Admin\App\Constructs\Constants;
use Modules\Frontend\App\Models\Brand;
use Modules\Frontend\App\Models\Category;
use Modules\Frontend\App\Models\Product;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;
use ONGR\ElasticsearchDSL\Search;

class HomeRepository implements HomeRepositoryInterface
{
    const PER_PAGE_CLIENT = 25;

    const PRODUCT_SEARCH_RESULT = 10;

    public function searchList(?string $searchName)
    {
        $searchName = is_null($searchName) ? '*' : $searchName;
        $result = MixedSearch::search($searchName, function (Client $client, Search $body) {
            $body->setSize(self::PRODUCT_SEARCH_RESULT);
            return $client->search(
                [
                    'index' => implode(',', [
                        (new Product())->searchableAs(),
                        // (new Category())->searchableAs(),
                        // (new Brand())->searchableAs(),
                    ]),
                    'body' => $body->toArray()
                ]
            )->asArray();
        })->get();

        return Response([
            'products' => $this->formatProductResults($result),
            'url' => route('frontend.home.searchElastic', $searchName)
        ]);
    }

    public function formatProductResults(Collection $products)
    {
        $products->transform(function ($product) {
            $product->url = route('frontend.product.index', $product->product_id);
            return $product;
        });
        return $products;
    }

    public function search(?string $searchName, bool $sqlFlag = true)
    {
        $startTime = microtime(true);
        if ($sqlFlag) {
            $query = Product::query();
            $products = searchProductSQL($query, $searchName);
        } else {
            $searchName = is_null($searchName) ? '*' : $searchName;
            $products = (new Product)->searchProductElastic($searchName);
        }

        $products = $products->paginate(self::PER_PAGE_CLIENT);
        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 5);

        return [
            'executionTime' => $executionTime,
            'data' => (new Product())->_transformRatingProduct($products)
        ];
    }
}
