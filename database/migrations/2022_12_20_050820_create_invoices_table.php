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
        Schema::create('invoices', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->foreignUuid('insured_contract_id')->index()->constrained('insured_contracts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
