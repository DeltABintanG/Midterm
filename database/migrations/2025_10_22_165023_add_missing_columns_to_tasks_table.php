<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        if (!Schema::hasColumn('tasks', 'description')) {
            $table->text('description')->nullable();
        }
        if (!Schema::hasColumn('tasks', 'user_id')) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }
        if (!Schema::hasColumn('tasks', 'category_id')) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        }
        if (!Schema::hasColumn('tasks', 'is_completed')) {
            $table->boolean('is_completed')->default(false);
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};
