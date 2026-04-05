<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');        // Titre de l'événement
        $table->string('client_name');  // Nom du client (ex: ALIFA)
        $table->date('event_date');     // Date de l'événement
        $table->string('location');  // Lieu (ex: Agoè adjougba)
        $table->timestamps();
    });
}

    public function down(): void {
        Schema::dropIfExists('events');
    }
};