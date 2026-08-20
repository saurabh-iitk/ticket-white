<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModulePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_module_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('role_id');
            $table->smallInteger('module_id');
            $table->smallInteger('permission_id');
            $table->string('module_permission_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_module_permissions');
    }
}
