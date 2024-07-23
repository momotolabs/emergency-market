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
        Schema::create('contracts', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index();
            $table->longText('content');
            $table->boolean('default')->default(false);
            $table->foreignUuid('company_id')
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
        Schema::dropIfExists('contracts');
    }
};
