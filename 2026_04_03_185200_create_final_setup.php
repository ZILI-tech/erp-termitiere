<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Pour votre croquis : Catégories & Couleurs
        Schema::create('categories', fn (Blueprint $table) => $table->id() && $table->string('name'));
        Schema::create('colors', fn (Blueprint $table) => $table->id() && $table->string('name'));

        // Pour votre croquis : Matériel (Stock)
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->integer('available_quantity')->default(0);
            $table->timestamps();
        });

        // Pour vos événements (Correction erreur 'emplacement' et 'client_name')
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('client_name'); 
            $table->date('event_date');
            $table->string('location'); // C'est cette colonne qui manquait
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
        Schema::dropIfExists('equipments');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('categories');
    }
};