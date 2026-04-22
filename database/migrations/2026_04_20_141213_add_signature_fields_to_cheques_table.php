<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('cheques', function (Blueprint $table) {
        if (!Schema::hasColumn('cheques', 'signature_data')) {
            $table->text('signature_data')->nullable()->after('status');
        }
        if (!Schema::hasColumn('cheques', 'is_signed')) {
            $table->boolean('is_signed')->default(false);
        }
        if (!Schema::hasColumn('cheques', 'signed_by')) {
            $table->string('signed_by')->nullable();
        }
        if (!Schema::hasColumn('cheques', 'signed_at')) {
            $table->timestamp('signed_at')->nullable();
        }
        if (!Schema::hasColumn('cheques', 'signature_reason')) {
            $table->string('signature_reason')->nullable();
        }
    });
}

    public function down()
    {
        Schema::table('cheques', function (Blueprint $table) {
            $table->dropColumn(['signature_data', 'signed_by', 'signed_at', 'is_signed']);
        });
    }
};