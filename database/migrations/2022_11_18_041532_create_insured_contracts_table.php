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
        Schema::create('insured_contracts', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content');
            $table->unsignedInteger('status')->default(0);
            $table->jsonb('meta');
            $table->foreignUuid('insured_id')
              ->constrained('insureds')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();
            $table->foreignUuid('contract_id')
              ->constrained('contracts')
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
        Schema::dropIfExists('insured_contracts');
    }
};
