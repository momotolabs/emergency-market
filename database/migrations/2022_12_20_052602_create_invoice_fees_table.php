<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('invoice_fees', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->index()->constrained('invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->enum('type', ['tax', 'discount']);
            $table->enum('fee_type', ['percentage', 'discount']);
            $table->integer('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_fees');
    }
};
