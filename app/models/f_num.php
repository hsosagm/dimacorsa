<?php


class f_num {

    public static function get($num) {

        $num = number_format($num,2,'.',',');

        return  $num;
    }
}
