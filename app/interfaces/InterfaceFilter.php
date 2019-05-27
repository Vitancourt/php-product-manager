<?php
namespace Interfaces;

interface InterfaceFilter
{
    public static function string($demand);
    public static function money($demand);
    public static function int($demand);
    public static function float($demand);
}
