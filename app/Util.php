<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 8/1/2018
 * Time: 5:15 PM
 */

namespace App;


class Util {
    public static function toCurrency($value) {
        return "Rp. ".number_format($value, 0, ',', '.');
    }
} 