<?php

namespace App\Listeners\VinCode;

use App\Events\AutoUpdatedEvent;
use App\Exceptions\AutoUpdateException;
use App\Integrations\VinDecoderClient;
use App\Repository\AutosRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutoDataSyncer implements ShouldQueue
{
    public function __construct(
        private readonly AutosRepository $autosRepository,
        private readonly VinDecoderClient $decoderClient,
    ) {
    }

    /**
     * @throws GuzzleException
     * @throws AutoUpdateException
     */
    public function handle(AutoUpdatedEvent $event): void
    {
        if (empty($event->changedValues['vin_code'])) {
            return;
        }

        $auto = $event->auto;

        $data = $this->decoderClient->getAutoInfoByVIN($auto->vin_code);
        $this->autosRepository->update($auto, [
            'brand' => $data->brand,
            'model' => $data->model,
            'year' => $data->year,
        ]);
    }
}
