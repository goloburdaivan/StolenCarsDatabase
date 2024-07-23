<?php

namespace App\Integrations;

use App\DTO\AutoDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VinDecoderClient
{
    private const BASE_URI = "https://vpic.nhtsa.dot.gov/";
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URI,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function getAutoInfoByVIN(string $vin, array $params = ['format' => 'json']): AutoDTO
    {
        $result = json_decode($this->client->get("/api/vehicles/decodevin/{$vin}", [
            'query' => $params,
        ])->getBody(), true)['Results'];

        return new AutoDTO(
            $result[7]['Value'] ?? null,
            $result[9]['Value'] ?? null,
                $result[10]['Value'] ?? null
        );
    }
}
