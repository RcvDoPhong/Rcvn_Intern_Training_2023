<?php

namespace Modules\Admin\App\Http\Repositories\WardRepository;

use App\Repositories\RepositoryInterface;

interface WardRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getWards(?int $districtId);
}
