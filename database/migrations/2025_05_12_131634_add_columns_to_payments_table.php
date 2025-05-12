<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Add the user_id column
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Add the parent_id column
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('parent_records')->onDelete('cascade');

            // Add the child_id column
            $table->unsignedBigInteger('child_id')->nullable();
            $table->foreign('child_id')->references('id')->on('parent_records')->onDelete('cascade');

            // Additional columns
            $table->date('paymentByParents_date')->nullable(); // Date of payment by parents
            $table->decimal('payment_amount', 10, 2)->nullable(); // Payment amount
            $table->date('payment_duedate')->nullable(); // Payment due date
            $table->enum('payment_status', ['Pending', 'Complete', 'Overdue'])->default('Pending'); // Payment status
            $table->date('bill_date')->nullable(); // Bill date

            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};