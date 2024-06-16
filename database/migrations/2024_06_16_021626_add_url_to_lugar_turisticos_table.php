<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('lugar_turisticos', function (Blueprint $table) {
            $table->string('url')->unique()->after('nombre');
        });
    }

    public function down()
    {
        Schema::table('lugar_turisticos', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
