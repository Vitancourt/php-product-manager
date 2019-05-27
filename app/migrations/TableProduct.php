<?php
namespace Migration;

use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;

class TableProduct extends Migration
{

    /**
     * Verify existance
     *
     * @return void
     */
    public static function verify()
    {
        if (Capsule::schema()->hasTable('product')) {
            return false;
        }
        return true;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        if (!self::verify()) {
            return false;
        }
        Capsule::schema()->create('product', function ($table) {
            $table->increments('id')
                ->unsigned();
            ;
            $table->string('sku')
                ->unique();
            $table->string('name');
            $table->string('description');
            $table->integer('quantity');
            $table->unsignedDecimal('price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        self::verify();
        Schema::drop('product');
    }
}
