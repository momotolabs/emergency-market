<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Company;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlugGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emergency:slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::transaction(function () {
                $companies = Company::query()->whereNull('slug')->get();
                $count = 1;
                foreach ($companies as $key => $item) {
                    $this->info($item);
                    $slug = Str::slug($item->name);

                    $companyNameSlug = Company::query()->where('slug', '=', Str::slug($item->name))->count();

                    if ($companyNameSlug > 0) {
                        $count++;
                        $companyNameSlugNew = $item->name.'-'.Carbon::now()->timestamp + $count;
                        $slug = Str::slug($companyNameSlugNew);
                    }
                    $item->update([
                        'slug' => $slug,
                    ]);
                }
            });

            $this->info('Slugs generated');
        } catch (Exception $e) {
        }
    }
}
