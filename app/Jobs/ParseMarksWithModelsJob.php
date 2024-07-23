<?php

namespace App\Jobs;

use App\Exceptions\AutoMakeUpdateException;
use App\Exceptions\AutoModelUpdateException;
use App\Integrations\AutosAPIClient;
use App\Repository\AutoMakesRepository;
use App\Repository\AutoModelsRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseMarksWithModelsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     * @throws GuzzleException
     * @throws AutoModelUpdateException
     * @throws AutoMakeUpdateException
     */
    public function handle(
        AutosAPIClient $client,
        AutoMakesRepository $autoMakesRepository,
        AutoModelsRepository $autoModelsRepository,
    ): void {
        $autoMakes = $client->getAllMakes();

        foreach ($autoMakes as $autoMake) {
            $make = $autoMakesRepository->findByMakeId($autoMake['Make_ID']);
            if (!$make) {
                $autoMakesRepository->create([
                    'make_id' => $autoMake['Make_ID'],
                    'name' => $autoMake['Make_Name'],
                ]);
            }

            $autoModels = $client->getModels($autoMake['Make_ID']);
            foreach ($autoModels as $autoModel) {
                $model = $autoModelsRepository->findByModelId($autoModel['Model_ID']);
                if (!$model) {
                    $autoModelsRepository->create([
                        'make_id' => $autoModel['Make_ID'],
                        'model_id' => $autoModel['Model_ID'],
                        'name' => $autoModel['Model_Name'],
                    ]);
                }
            }
        }
    }
}
