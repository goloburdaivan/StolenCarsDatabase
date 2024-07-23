<?php

namespace App\Console\Commands;

use App\Jobs\ParseMarksWithModelsJob;
use Illuminate\Console\Command;

class ParseMarksWithModelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-marks-with-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database with marks and models';

    public function handle(): void
    {
        ParseMarksWithModelsJob::dispatch();
    }
}
