<?php

namespace Modules\Admin\App\Enums;

class OrderPaymentEnum
{
    const COD = 0;

    const BANKING = 1;

    public static function getStatusEnum()
    {
        return [
            'Trả tiền mặt' => self::COD,
            'Chuyển khoản' => self::BANKING
        ];
    }

    public static function getStatusAttribute(int $id)
    {
        $arr = self::getStatusEnum();

        return array_search($id, $arr, true);
    }
}
