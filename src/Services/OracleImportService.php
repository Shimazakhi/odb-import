<?php

namespace App\Services;

use App\Models\Oracle\Claim;
use App\Models\Oracle\Contract;
use App\Transformers\OracleClaimTransformer;
use App\Transformers\OracleContractTransformer;
use GuzzleHttp\Client;
use League\Fractal\Manager;
use Spatie\Fractal\Fractal;

class OracleImportService
{
    /**
     * Batch import
     *
     * @param $data
     */
    public function processClaimsImport()
    {
        try {

            $claims = Claim::all();

            $prepared = (new Fractal(new Manager()))->collection($claims)->transformWith(new OracleClaimTransformer());

            print_r("Total Claims Records to Import: " . count($prepared->toArray()['data']) . "\n");

            $data = $prepared->toArray()['data'];

            $this->sendPayload($data, 'claim');

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function processContractsImport()
    {
        try {

            $contracts = Contract::all();

            $prepared = (new Fractal(new Manager()))->collection($contracts)->transformWith(new OracleContractTransformer());

            print_r("Total Contract Records to Import: " . count($prepared->toArray()['data']) . "\n");

            $data = $prepared->toArray()['data'];

            $this->sendPayload($data ,'contract');

        } catch (\Exception $exception) {
            dd($exception->getTrace());
        }
    }


    private function sendPayload($data, $type)
    {
        $client = new Client();
        $client->post(env('WEBHOOK_API_URL').'/api/import/'.$type,[
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => ['data' => json_encode($data)]
        ]);
    }
}
