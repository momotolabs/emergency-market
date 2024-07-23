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
        Schema::create('pricing_resources', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('minimum_units');
            $table->unsignedInteger('price_cents');
            $table->boolean('taxable')->default(true);
            $table->string('price_currency')->default('USD');
            $table->foreignUuid('resource_id')
                ->constrained('resources')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('company_id')
                ->index()
                ->constrained('companies')
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
        Schema::dropIfExists('pricing_resources');
    }
};
