<?php
namespace Migration;

use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;

class TableProductCategory extends Migration
{

    /**
     * Verify existance
     *
     * @return void
     */
    public static function verify()
    {
        if (Capsule::schema()->hasTable('product_category')) {
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
        Capsule::schema()->create('product_category', function ($table) {
            $table->increments('id')
                ->unsigned();
            $table->integer('category_id')
                ->unsigned();
            $table->integer('product_id')
                ->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::drop('product_category');
    }
}
