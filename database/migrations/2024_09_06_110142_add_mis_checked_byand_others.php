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
        Schema::table('application_statuses', function (Blueprint $table) {
            $table->integer('mis_checked_by')->after('is_mis_checked')->nullable();
            $table->integer('scan_file_checked_by')->after('is_scan_file_checked')->nullable();
            $table->integer('uploaded_doc_checked_by')->after('is_uploaded_doc_checked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_statuses', function (Blueprint $table) {
            $table->dropColumn('mis_checked_by');
            $table->dropColumn('scan_file_checked_by');
            $table->dropColumn('uploaded_doc_checked_by');
        });
    }
};
