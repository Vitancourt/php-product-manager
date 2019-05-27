<?php
namespace Migration;

use Illuminate\Container\Container;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;

class TableCategory extends Migration
{

    /**
     * Verify existance
     *
     * @return void
     */
    public static function verify()
    {
        if (Capsule::schema()->hasTable('category')) {
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
        Capsule::schema()->create('category', function ($table) {
            $table->increments('id')
                ->unsigned();
            $table->string('name')
                ->unique();
            $table->string('code')
                ->unique();
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
        Schema::drop('category');
    }
}
