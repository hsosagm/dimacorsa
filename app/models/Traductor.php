<?php

class Traductor
{
    public static function getMes($mes)
    {
        $meses = array(
            "january" => "Enero",
            "february" => "Febrero",
            "march" => "Marzo",
            "april" => "Abril",
            "may" => "Mayo",
            "june" => "Junio",
            "july" => "Julio",
            "august" => "Agosto",
            "september" => "Septiembre",
            "october" => "Octubre",
            "november" => "Noviembre",
            "december" => "Diciembre",
            );
        return $meses[strtolower($mes)];
    }
}
