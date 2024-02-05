<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('webauthn_credentials', function (Blueprint $table) {
            if (Schema::hasColumn('webauthn_credentials', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('webauthn_credentials', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint if exists
            $table->dropColumn('user_id'); // Drop the new user_id column

            // Add the old user_id column as a string
            $table->string('user_id');

            // Add a foreign key constraint to the users table
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Adjust onDelete based on your requirements
        });
    }
};
