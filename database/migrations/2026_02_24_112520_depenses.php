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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->decimal('montant', 10, 2);
            $table->date('date_depense');

            $table->foreignId('categorie_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->foreignId('payeur_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('colocation_id')
                  ->constrained('colocations')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
