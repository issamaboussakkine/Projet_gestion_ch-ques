<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('role');
            $table->string('entreprise')->nullable()->after('photo');
            $table->string('poste')->nullable()->after('entreprise');
            $table->string('telephone')->nullable()->after('poste');
            $table->text('adresse')->nullable()->after('telephone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'entreprise', 'poste', 'telephone', 'adresse']);
        });
    }
};