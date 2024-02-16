<?php

namespace Modules\Admin\App\Http\Repositories\BrandRepository;

use App\Repositories\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function createNewUpdate(array $arrBrandData, string $method = "POST", int $id = 0);

    public function destroy(int $id);

    public function handleReport(array $arrReportData);
}
