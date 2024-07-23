<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use MStaack\LaravelPostgis\Schema\Blueprint as SchemaBlueprint;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis;');

        Schema::create('companies', static function (SchemaBlueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('kind', ['tree_service', 'water_mitigation', 'tarping_roofing_and_board_up'])
                ->default('tree_service')->nullable();
            // $table->string('state')->nullable();
            // $table->string('city')->nullable();
            $table->foreignUuid('city_id')->nullable()->index()->constrained('cities');
            $table->string('address')->nullable();
            $table->point('address_coordinates')->nullable();
            $table->string('phone')->nullable();
            $table->string('parking_address')->nullable();
            $table->point('parking_coordinates')->nullable();
            $table->integer('miles')->nullable();
            $table->jsonb('social')->nullable();
            $table->jsonb('meta')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->foreignUuid('user_id')
                ->constrained('users')
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
        Schema::dropIfExists('companies');
    }
};
