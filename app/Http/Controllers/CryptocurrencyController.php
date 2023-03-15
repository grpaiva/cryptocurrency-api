<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptocurrencyController extends Controller
{
    public function getSinglePrice($coin)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://api.coingecko.com/api/v3/simple/price?ids=$coin&vs_currencies=usd");

        $price = json_decode($response->getBody(), true)[$coin]['usd'];

        return response()->json(['price' => $price]);
    }

    public function getAllPrices()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,litecoin&vs_currencies=usd");

        $prices = json_decode($response->getBody(), true);

        return response()->json(['prices' => $prices]);
    }
}
