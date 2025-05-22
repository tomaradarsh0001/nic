<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminPublicGrievanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('admin_public_grievances', function (Blueprint $table) {
        //     // Drop the existing country_code column
        //     $table->dropColumn('country_code');
        // });

        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Recreate the country_code column after email
            $table->integer('country_code')->after('email');
        });

        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Rename dealing_section_code to section_id
            $table->renameColumn('dealing_section_code', 'section_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Drop the newly positioned country_code column
            $table->dropColumn('country_code');
        });

        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Recreate the country_code column after mobile
            $table->integer('country_code')->after('mobile');
        });

        Schema::table('admin_public_grievances', function (Blueprint $table) {
            // Rename section_id back to dealing_section_code
            $table->renameColumn('section_ids', 'dealing_section_code');
        });
    }
}
