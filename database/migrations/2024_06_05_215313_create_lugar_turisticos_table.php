<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('lugar_turisticos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripción');
            $table->string('direccion');
            $table->string('longitud');
            $table->string('latitud');
            $table->string('contacto',9);
            $table->text('mapa');
            $table->string('logo');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tipo_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lugar_turisticos');
    }
};
