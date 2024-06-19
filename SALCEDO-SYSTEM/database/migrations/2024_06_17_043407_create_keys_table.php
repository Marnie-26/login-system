<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->string('unit_no')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('borrow_purpose')->nullable();
            $table->date('borrow_date')->nullable();
            $table->time('time_borrowed')->nullable();
            $table->time('time_returned')->nullable();
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
        Schema::dropIfExists('keys');
    }
};
