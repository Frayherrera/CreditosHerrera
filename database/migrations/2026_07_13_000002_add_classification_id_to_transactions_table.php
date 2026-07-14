<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('transaction_classification_id')->nullable()->after('transaction_category_id')->constrained('transaction_classifications')->nullOnDelete();
            $table->dropColumn('classification');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('classification')->after('transaction_category_id');
            $table->dropForeign(['transaction_classification_id']);
            $table->dropColumn('transaction_classification_id');
        });
    }
};
