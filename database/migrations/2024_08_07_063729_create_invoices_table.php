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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('amount_letter');
            $table->text('description');
            $table->date('release_date');
            $table->date('payment_deadline')->nullable();
            $table->enum('status', ['in attesa', 'pagata', 'scaduta' , 'annullata','inviata'])->default('in attesa');
            $table->integer('customer_invoice_number');
            $table->integer('customer_invoice_annual_number');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // add index
            $table->index('release_date');
            $table->index('customer_invoice_number');
            $table->index('customer_invoice_annual_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
