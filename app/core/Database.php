<?php
namespace Core;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

/**
 * Classe núcleo do banco de dados
 * segue o padrão illuminate\database
 */
class Database extends Capsule
{
    public static function run(Capsule $capsule)
    {
        /**
         * Configured on app/config.php
         */
        $capsule->addConnection([
            'driver'    => DATABASE["DRIVER"],
            'host'      => DATABASE["HOST"],
            'database'  => DATABASE["NAME"],
            'username'  => DATABASE["USER"],
            'password'  => DATABASE["PASS"],
            'charset'   => DATABASE["CHARSET"],
            'collation' => DATABASE["COLLATION"],
            'prefix'    => DATABASE["PREFIX"],
        ]);
        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();
        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }
}
