<?php

namespace App\Integrations;

use App\DTO\AutoDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AutosAPIClient
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

    /**
     * @throws GuzzleException
     */
    public function getAllMakes(array $params = ['format' => 'json']): array
    {
        return json_decode($this->client->get('/api/vehicles/getallmakes', [
            'query' => $params
        ])->getBody(), true)['Results'];
    }

    /**
     * @throws GuzzleException
     */
    public function getModels(string $makeId, array $params = ['format' => 'json']): array
    {
        return json_decode($this->client->get("/api/vehicles/getmodelsformakeid/{$makeId}", [
            'query' => $params,
        ])->getBody(), true)['Results'];
    }
}
