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
    Schema::create('activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bug_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained(); // Siapa yang melakukan perubahan
        $table->string('action'); // Contoh: "Changed Status", "Changed Assignee"
        $table->text('description'); // Contoh: "Status changed from open to in_progress"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
