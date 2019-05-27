<?php
namespace Interfaces;

interface InterfaceLogger
{
    public static function in(string $message, int $type);
    public static function out();
}
