<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',255)->unique();
            
            $table->string('password',255);
            $table->string('firstname',255)->default('');
            $table->string('lastname',255)->default('');
            $table->string('phone',255)->default('');
            $table->string('company',255)->default('');
            $table->text('sticker_internals')->default('');
            $table->integer('sticker_calltime')->default(0);
            $table->integer('sticker_expiration')->default(0);
            
            $table->tinyInteger('gid')->default(1);
            
            $table->timestamp('last_login')->default('0');
            $table->string('last_ip',255)->default('');
            $table->tinyInteger('status')->default(1);
            $table->timestamp('date')->default('0');
             	
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
        Schema::drop('users');
    }
}
