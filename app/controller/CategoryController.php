<?php
/**
 * CategoryController
 * As funções aqui definidas são utilizadas
 * no CRUD de category, cada função tem o nome
 * referente a uma aplicação
 * get, insert, update, delete
 */
namespace Controller;

use Model\Category;

use Helper\ObjectJsonParser;

class CategoryController
{
    public static function get(int $id = null)
    {
        return ObjectJsonParser::parse(
            Category::get($id)
        );
    }

    public static function insert(array $input)
    {
        return Category::insert($input);
    }

    public static function update(array $input)
    {
        return Category::update($input);
    }

    public static function delete(int $id)
    {
        return Category::delete($id);
    }
}
