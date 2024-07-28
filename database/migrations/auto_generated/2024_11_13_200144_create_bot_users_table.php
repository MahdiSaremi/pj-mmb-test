<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bot_users', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement()->unsigned();
            $table->text('name');
            $table->text('step');
            $table->integer('coin')->unsigned()->default(0);
            $table->string('invite_code')->length(255)->nullable();
            $table->bigInteger('invited_by_id')->unsigned()->nullable();
            $table->timestamp('created_at')->precision(0)->nullable();
            $table->timestamp('updated_at')->precision(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('bot_users');
    }
};
