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
        Schema::create('insured_contract_resources', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('units');
            $table->unsignedInteger('price_cents');
            $table->string('price_currency');
            $table->foreignUuid('insured_contract_id')
              ->constrained('insured_contracts')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();
            $table->foreignUuid('pricing_resource_id')
              ->constrained('pricing_resources')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('insured_contract_resources');
    }
};
