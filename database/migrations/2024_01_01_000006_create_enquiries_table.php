<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_name')->nullable(); // free text fallback
            $table->integer('quantity')->nullable();
            $table->string('budget_range')->nullable();
            $table->string('location')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->string('source')->default('website'); // website, contact, product
            $table->enum('status', ['new', 'contacted', 'follow_up', 'quotation_sent', 'converted', 'closed'])->default('new');
            $table->text('internal_notes')->nullable();
            $table->string('assigned_to')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
