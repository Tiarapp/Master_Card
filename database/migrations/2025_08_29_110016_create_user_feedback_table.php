<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('type')->default('suggestion'); // suggestion, bug_report, feature_request, complaint
            $table->string('category')->nullable(); // inventory, reports, system, ui_ux
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->string('subject');
            $table->text('message');
            $table->string('page_url')->nullable(); // halaman tempat feedback diberikan
            $table->json('browser_info')->nullable(); // informasi browser untuk bug report
            $table->string('status')->default('open'); // open, in_progress, resolved, closed
            $table->text('admin_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('responded_by')->nullable(); // admin yang merespon
            $table->timestamps();
            
            $table->index(['type', 'status']);
            $table->index(['category', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_feedback');
    }
}
