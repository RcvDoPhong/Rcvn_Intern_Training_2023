<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;

/**
 * CartController using for cart product of specific user and  its functionality
 * 05/01/2024
 * version:1
 */
class CartController extends Controller
{

    private $cartRepo;
    private $shippingRepo;
    private $userRepo;

    private $productRepo;

    public function __construct(
        CartRepositoryInterface $cartRepo,
        ShippingRepositoryInterface $shippingRepo,
        UserRepositoryInterface $userRepo,
        ProductRepositoryInterface $productRepo
    ) {

        $this->cartRepo = $cartRepo;
        $this->shippingRepo = $shippingRepo;
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Display a cart list of the resource.
     * 05/01/2024
     * version:1
     */
    public function index(Request $request): View|Response
    {

        $data =  $this->_getCartPackage($request);
        if ($request->input("ajax", false)) {

            return new Response($data);
        }
        return view('frontend::pages.cart.index', $data);
    }

    public function getTableCart(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {

        $cart = $this->cartRepo->getCart();
        $newCart = $this->cartRepo->addCart($request, $cart);
        $sumPrice = $this->cartRepo->sumPriceCart($newCart);
        return new Response(['data' => $newCart, 'sumPrice' => $sumPrice]);
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return view('frontend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): Response
    {
        $cart = $this->cartRepo->changeQuantity($request, (int) $id);
        $sumPrice = $this->cartRepo->sumPriceCart($cart);
        $currentMethod = $this->shippingRepo->getCurrentMethod($request);


        return new Response([
            'data' => $cart,
            'sumPrice' => $sumPrice,
            'currentMethod' => $currentMethod
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $currentMethod = $this->shippingRepo->getCurrentMethod($request);

        $cart = $this->cartRepo->getCart();
        // Delete the product from the cart
        $newCart = $this->cartRepo->deleteCart($cart, (int) $id);
        // Check if $newCart is null and handle it
        if ($newCart === null) {
            $newCart = [];
        }

        // Calculate the sum price for the updated cart
        $sumPrice = $this->cartRepo->sumPriceCart($newCart);
        return new Response([
            'data' => array_values($newCart),
            'sumPrice' => $sumPrice,
            'currentMethod' => $currentMethod
        ]);
    }

    /**
     * Get the length of the cart.
     *
     * @return int
     */
    public function getCartLength(): int
    {
        return $this->cartRepo->getCartLength();
    }

    private function _getCartPackage(Request $request): array
    {
        $carts = $this->cartRepo->getCart();
        $sumPrice = $this->cartRepo->sumPriceCart($carts);
        $methods = $this->shippingRepo->getAllMethod();

        $currentMethod = $this->shippingRepo->getCurrentMethod($request);

        $recentlyViewProduct = $this->productRepo->getRecentViewedProduct();

        return  [
            'data' => $carts,
            'sumPrice' => $sumPrice,
            'methods' => $methods,
            'currentMethod' => $currentMethod,
            'user' =>  Auth::user() ?? [],
            "recentlyViewProduct" => $recentlyViewProduct
        ];
    }
}
