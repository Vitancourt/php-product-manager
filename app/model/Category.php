<?php
namespace Model;

/**
 * Category
 * Acesso ao capsule Illuminate
 * atraves do Database
 * As funções utilizadas tem o referente a operação que realiza
 */
use Core\Database;
use Helper\UILogger;

class Category
{
    public static function get(int $id = null, string $code = null)
    {
        if (!is_null($code)) {
            return Database::table('category')
                ->select('*')
                ->where('code', $code)
                ->get();
        }
        if (!is_null($id)) {
            return Database::table('category')
                ->find($id);
        } else {
            return Database::select(
                'SELECT * FROM category ORDER BY NAME ASC'
            );
        }
    }

    public static function hasId(int $id)
    {
        return Database::table('category')
            ->select('*')
            ->where('id', $id)
            ->get()
            ->count();
    }

    public static function hasName(string $name, int $id = null)
    {
        if (empty($id)) {
            return Database::table('category')
                ->select('*')
                ->where('name', $name)
                ->get()
                ->count();
        } else {
            return Database::table('category')
                ->select('*')
                ->where('name', $name)
                ->where('id', '<>', $id)
                ->get()
                ->count();
        }
    }

    public static function hasCode(string $code, int $id = null)
    {
        if (empty($id)) {
            return Database::table('category')
                ->select('*')
                ->where('code', $code)
                ->get()
                ->count();
        } else {
            return Database::table('category')
                ->select('*')
                ->where('code', $code)
                ->where('id', '<>', $id)
                ->get()
                ->count();
        }
    }

    public static function insert(array $input):int
    {
        if (
            self::hasName($input['name']) != 0
            ||
            self::hasCode($input['code']) != 0
            ) {
            return false;
        }
        if (!self::validate(($input))) {
            return false;
        }
        if (
            $id = Database::table('category')->insertGetId([
                'name' => $input['name'],
                'code' => $input['code'],
                'created_at' => date("Y-m-d H:i:s")
            ])
        ) {
            UILogger::in('Categoria cadastrada!', 1);
            return $id;
        }
        UILogger::in('Erro na operação!', 2);
        return false;
    }

    public static function update(array $input):bool
    {
        if (
            self::hasName($input['name'], $input['id']) != 0
            &&
            self::hasCode($input['code'], $input['id']) != 0
        ) {
            return false;
        }
        if (!self::validate(($input))) {
            return false;
        }
        if (
            Database::table('category')
                ->where('id', $input['id'])
                ->update([
                    'name' => $input['name'],
                    'code' => $input['code'],
                    'updated_at' => date("Y-m-d")
                ])
        ) {
            UILogger::in('Categoria atualizada!', 1);
            return true;
        }
        UILogger::in('Erro na operação!', 2);
        return false;
    }

    public static function delete(int $id):bool
    {
        if (self::hasId($id) > 0) {
            if (
                Database::table('category')
                    ->where('id', $id)
                    ->delete()
            ) {
                UILogger::in('Categoria excluída!', 2);
                return true;
            }
        }
        UILogger::in('Erro na operação!', 2);
        return false;
    }

    public static function validate(array $input):bool
    {
        $validation = true;
        if (isset($input['name']) && strlen($input['name']) < 1) {
            UILogger::in('Nome inválido!', 2);
            $validation = false;
        }
        if (isset($input['code']) && strlen($input['code']) < 1) {
            UILogger::in('Código inválido!', 2);
            $validation = false;
        }
        return $validation;
    }
}
