<?php

class f_num {

    public static function get($num) {

        $num = number_format($num, 2,'.',',');

        return  $num;
    }

    public static function get3($num) {

        $num = number_format($num, 3,'.',',');

        return  $num;
    }

    public static function get4($num) {

        $num = number_format($num, 4,'.',',');

        return  $num;
    }

    public static function get5($num) {

        $num = number_format($num, 5,'.',',');

        return  $num;
    }
}
