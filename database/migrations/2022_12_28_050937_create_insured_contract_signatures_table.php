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
        Schema::create('insured_contract_signatures', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('insured_contract_id')->index()->constrained('insured_contracts')->cascadeOnDelete()->cascadeOnUpdate();

            $table->longText('signature');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('insured_contract_signatures');
    }
};
