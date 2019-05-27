<?php
namespace Controller;

use Model\Product;

use Helper\ObjectJsonParser;

class ProductController
{
    public static function get(int $id = null)
    {
        return ObjectJsonParser::parse(
            Product::get($id)
        );
    }

    public static function insert(array $input)
    {
        return Product::insert($input);
    }

    public static function update(array $input)
    {
        return Product::update($input);
    }

    public static function delete(int $id)
    {
        return Product::delete($id);
    }
}
