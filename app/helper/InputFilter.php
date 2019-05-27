<?php
namespace Helper;

use Interfaces\InterfaceFilter;

class InputFilter implements InterfaceFilter
{
    public static function string($demand)
    {
        return filter_var($demand, FILTER_SANITIZE_STRING);
    }

    public static function money($demand)
    {
        return number_format(
            filter_var(
                $demand,
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            ),
            2,
            ".",
            ""
        );
    }

    public static function int($demand)
    {
        return filter_var($demand, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function float($demand)
    {
        return filter_var(
            $demand,
            FILTER_SANITIZE_NUMBER_FLOAT,
            FILTER_FLAG_ALLOW_FRACTION
        );
    }
}
