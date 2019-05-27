<?php
namespace Model;

use Helper\InputFilter;

/**
 * Acesso ao capsule Illuminate
 * atraves do Database
 */
use Core\Database;
use Helper\UILogger;

class Product
{
    public static function get(int $id = null)
    {
        if (!is_null($id)) {
            //return
            $product = Database::table('product')
                ->find($id);
            $product_categories = self::getCategories($product->id);
            foreach ($product_categories as $product_category) {
                $product->categories[] = (array) $product_category;
            }
            return $product;
        } else {
            $products = Database::select(
                'SELECT * FROM product ORDER BY NAME ASC'
            );
            foreach ($products as &$product) {
                $product_categories = self::getCategories($product->id);
                foreach ($product_categories as $product_category) {
                    $product->categories[] = (array) $product_category;
                }
            }
            return $products;
        }
    }

    public static function getCategories(int $id)
    {
        return Database::table('product_category as pc')
            ->select('c.*')
            ->join('category as c', 'pc.category_id', '=', 'c.id')
            ->where('pc.product_id', $id)
            ->get();
    }

    public static function hasSku(string $sku, int $id = null)
    {
        if (is_null($id)) {
            return Database::table('product')
                ->select('*')
                ->where('sku', $sku)
                ->get()
                ->count();
        }
        return Database::table('product')
            ->select('*')
            ->where('sku', $sku)
            ->where('id', '<>', $id)
            ->get()
            ->count();
    }

    public static function insert(array $input)//:int
    {
        if (!self::validate($input)) {
            return false;
        }
        Database::beginTransaction();
        $insert = true;
        try {
            if (
                $product_id = Database::table('product')->insertGetId([
                    'sku' => $input['sku'],
                    'name' => $input['name'],
                    'description' => $input['description'],
                    'quantity' => $input['quantity'],
                    'price' => $input['price'],
                    'created_at' => date("Y-m-d H:i:s")
                ])
            ) {
                foreach ($input['categories'] as $category) {
                    if (
                        !Database::table('product_category')->insertGetId([
                            'product_id' => $product_id,
                            'category_id' => $category
                        ])
                    ) {
                        $insert = false;
                    }
                }
            }
            if ($insert) {
                UILogger::in('Produto cadastrado', 1);
                Database::commit();
                return true;
            }
        } catch (\Exception $e) {
            Database::rollback();
            UILogger::in('Erro na operação', 2);
            return false;
        }
        UILogger::in('Erro na operação', 2);
        return false;
    }

    public static function update(array $input):bool
    {
        if (!self::validate(($input))) {
            return false;
        }
        Database::beginTransaction();
        $update = true;
        try {
            if (
                !Database::table('product_category')
                    ->where('product_id', $input['id'])
                    ->delete()
            ) {
                $update = false;
            }
            if (
                $product_id = Database::table('product')
                    ->where('id', $input['id'])
                    ->update([
                        'sku' => $input['sku'],
                        'name' => $input['name'],
                        'description' => $input['description'],
                        'quantity' => $input['quantity'],
                        'price' => $input['price'],
                        'updated_at' => date("Y-m-d H:i:s")
                ])
            ) {
                foreach ($input['categories'] as $category) {
                    if (
                        !Database::table('product_category')->insertGetId([
                            'product_id' => $input['id'],
                            'category_id' => $category
                        ])
                    ) {
                        $update = false;
                    }
                }
            }
            if ($update) {
                UILogger::in('Produto atualizado', 1);
                Database::commit();
                return true;
            }
        } catch (\Exception $e) {
            UILogger::in('Erro na operação', 2);
            Database::rollback();
            return false;
        }
        UILogger::in('Erro na operação', 2);
        return false;
    }

    public static function delete(int $id):bool
    {
        if (self::hasId($id) > 0) {
            if (
                Database::table('product')
                    ->where('id', $id)
                    ->delete()
            ) {
                UILogger::in('Produto excluído', 2);
                return true;
            }
        }
        UILogger::in('Erro na operação', 2);
        return false;
    }

    public static function hasId(int $id)
    {
        return Database::table('product')
            ->select('*')
            ->where('id', $id)
            ->get()
            ->count();
    }

    public static function validate(array $input):bool
    {
        $return = true;
        if (
            self::hasSku(
                $input['sku'],
                (isset($input['id']))?$input['id']:null
            ) > 0
        ) {
            UILogger::in('O SKU já existe!', 2);
            $return = false;
        }
        if (
            empty(
                InputFilter::string($input['sku'])
            )
            ||
            empty(
                InputFilter::string($input['name'])
            )
            ||
            empty(
                InputFilter::int($input['quantity'])
            )
            ||
            empty(
                InputFilter::string($input['description'])
            )
            ||
            empty(
                InputFilter::money($input['price'])
            )
        ) {
            UILogger::in('Todas as informações são obrigatórias', 2);
            $return = false;
        }
        return $return;
    }
}
