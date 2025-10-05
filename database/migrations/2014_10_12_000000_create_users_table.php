<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->default('');
            $table->enum('role', ['Admin', 'User'])->default('User');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('phone')->nullable();
            $table->boolean('attention')->default(0);
            $table->enum('step_register', ['one', 'two', 'three', 'four', 'five', 'done'])->default('one');
            $table->boolean('house')->default(0);
            $table->boolean('apartments')->default(0);
            $table->boolean('homeowner')->default(0);
            $table->boolean('bedrooms1')->default(0);
            $table->boolean('bedrooms2')->default(0);
            $table->boolean('bedrooms3')->default(0);
            $table->boolean('bedrooms4')->default(0);
            $table->boolean('project')->default(0);
            $table->text('notes')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
