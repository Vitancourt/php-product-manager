<?php
namespace Helper;

use Interfaces\InterfaceParser;

class ObjectJsonParser implements InterfaceParser
{
    public static function parse($demand)
    {
        return json_encode($demand);
    }
}
