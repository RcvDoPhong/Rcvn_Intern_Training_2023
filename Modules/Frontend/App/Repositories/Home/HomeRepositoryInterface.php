<?php

namespace Modules\Frontend\App\Repositories\Home;

interface HomeRepositoryInterface
{
    public function searchList(?string $searchName);

    public function search(?string $searchName);
}
