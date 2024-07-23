<?php

namespace App\Console\Commands;

use App\Exceptions\AutoUpdateException;
use App\Integrations\VinDecoderClient;
use App\Models\Auto;
use App\Repository\AutosRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class FetchAutoDataCommand extends Command
{
    protected $signature = 'app:fetch-auto-data';
    protected $description = 'Fetch auto data from API';

    /**
     * Execute the console command.
     * @throws GuzzleException
     * @throws AutoUpdateException
     */
    public function handle(
        AutosRepository $autosRepository,
        VinDecoderClient $decoderClient,
    ): void {
        $autos = Auto::query()->get();

        /**
         * @var Auto $auto
         */
        foreach ($autos as $auto) {
            $data = $decoderClient->getAutoInfoByVIN($auto->vin_code);
            $autosRepository->update($auto, [
                'brand' => $data->brand,
                'model' => $data->model,
                'year' => $data->year,
            ]);
        }
    }
}
