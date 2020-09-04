<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_photo')->default('default.jpg');
            $table->string('book_name');
            $table->string('book_description');
            $table->string('book_author');
            $table->string('book_publisher');
            $table->integer('book_pages');
            $table->integer('book_year');
            $table->string('catalogue_no');
            $table->string('accession_no')->unique();
            $table->string('book_status')->default('Available');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_type_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('books');
    }
}
