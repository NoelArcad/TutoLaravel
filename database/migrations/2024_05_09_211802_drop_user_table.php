<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropUserTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users');
    }

    public function down()
    {
        // Si nécessaire, vous pouvez éventuellement rétablir la table ici
    }
}
