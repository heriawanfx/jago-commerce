<?php

use App\Models\Category;
use App\Models\User;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', total: 10, places: 2, unsigned: true);
            $table->string('image_url');
            $table->timestamps();

            $table->foreignIdFor(Category::class); //this will add category_id column
            $table->foreignIdFor(User::class); //this will add user_id column

            //Don't forget to add foreign fillable columns to Product model
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
