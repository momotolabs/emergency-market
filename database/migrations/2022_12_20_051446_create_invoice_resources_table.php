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
        Schema::create('invoice_resources', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->index()->constrained('invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('insured_contract_resource_id')->index()->constrained('insured_contract_resources')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('price_cents');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_resources');
    }
};
