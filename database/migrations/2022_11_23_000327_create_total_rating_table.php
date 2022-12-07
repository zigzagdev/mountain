<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_rating', function (Blueprint $table) {
            $table->string('mountain_name', 100);
            $table->integer('mountain_rate');
            $table->tinyInteger('prefecture')->comment('都道府県_コード番号');
            $table->unsignedBigInteger('admin_id')->comment('adminId');
            $table->timestamps();
            $table->foreign('admin_id')->references('adminId')->on('articles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('total_rating');
    }
}
