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
        Schema::table('mutation_applications', function (Blueprint $table) {
            $table->dropColumn('sought_on_basis_of');
            $table->string('sought_on_basis_of_documents')->after('reg_date_as_per_lease_conv_deed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutation_applications', function (Blueprint $table) {
            $table->integer('sought_on_basis_of')->after('reg_date_as_per_lease_conv_deed');
            $table->dropColumn('sought_on_basis_of_documents');
        });
    }
};
