<?php

namespace App\Helpers;

class Helper
{
    public static function getPrice($price, $priceSale = '')
    {
        $price = number_format($price, 0);
        if ($priceSale) {
            $priceSale = number_format($priceSale, 0);

            return "$priceSale đ <sup style='text-decoration-line:line-through; opacity:0.6;font-size:15px'>
              $price đ</sup>";
        }

        return "$price đ";
    }
}
