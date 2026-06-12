<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeLeadsColumnTypeInDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            DB::statement("ALTER TABLE data MODIFY COLUMN leads VARCHAR(255) DEFAULT 'Iklan'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            DB::statement("ALTER TABLE data MODIFY COLUMN leads ENUM('Iklan', 'Alumni', 'Marketing', 'Mandiri') DEFAULT 'Iklan'");
        });
    }
}
