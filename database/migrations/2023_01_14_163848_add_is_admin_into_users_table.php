<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tableName = 'users';
    protected $columnName = 'is_admin';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn($this->tableName, $this->columnName)) {
            Schema::table($this->tableName, function(Blueprint $table)
            {
                $table->boolean($this->columnName)->after('remember_token')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, $this->columnName)) {
            Schema::table($this->tableName, function(Blueprint $table)
            {
                $table->dropColumn($this->columnName);
            });
        }
    }
};
