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
        Schema::table('users', function (Blueprint $table) {
            
            $table->softDeletes();  // Ajoute la colonne 'deleted_at' pour SoftDeletes

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
           
            $table->dropSoftDeletes();  // Supprime la colonne 'deleted_at' si la migration est annulée
            
        });
    }
};
