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
        Schema::table('payments', function (Blueprint $table) {
            // Add columns if they don't exist yet:
            if (!Schema::hasColumn('payments', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('payments', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('parent_records')->onDelete('cascade');
            }

            if (!Schema::hasColumn('payments', 'child_id')) {
                $table->unsignedBigInteger('child_id')->nullable();
                // Double-check if child_id should reference parent_records or children table
                $table->foreign('child_id')->references('id')->on('parent_records')->onDelete('cascade');
            }

            if (!Schema::hasColumn('payments', 'paymentByParents_date')) {
                $table->date('paymentByParents_date')->nullable();
            }

            if (!Schema::hasColumn('payments', 'payment_amount')) {
                $table->decimal('payment_amount', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('payments', 'payment_duedate')) {
                $table->date('payment_duedate')->nullable();
            }

            if (!Schema::hasColumn('payments', 'payment_status')) {
                $table->enum('payment_status', ['Pending', 'Complete', 'Overdue'])->default('Pending');
            }

            if (!Schema::hasColumn('payments', 'bill_date')) {
                $table->date('bill_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop columns if exist (be careful with foreign keys, you may need to drop constraints first)
            if (Schema::hasColumn('payments', 'bill_date')) {
                $table->dropColumn('bill_date');
            }
            if (Schema::hasColumn('payments', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('payments', 'payment_duedate')) {
                $table->dropColumn('payment_duedate');
            }
            if (Schema::hasColumn('payments', 'payment_amount')) {
                $table->dropColumn('payment_amount');
            }
            if (Schema::hasColumn('payments', 'paymentByParents_date')) {
                $table->dropColumn('paymentByParents_date');
            }
            if (Schema::hasColumn('payments', 'child_id')) {
                $table->dropForeign(['child_id']);
                $table->dropColumn('child_id');
            }
            if (Schema::hasColumn('payments', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            if (Schema::hasColumn('payments', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
