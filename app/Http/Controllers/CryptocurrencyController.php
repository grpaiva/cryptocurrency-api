<?php

namespace App\Http\Controllers;

use App\Models\CryptocurrencyPrice;
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
        $user = auth()->user();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,litecoin&vs_currencies=usd");

        $prices = json_decode($response->getBody(), true);

        foreach ($prices as $coin => $data) {
            $price = new CryptocurrencyPrice([
                'coin' => $coin,
                'price' => $data['usd'],
            ]);
            $price->save();
        }

        return response()->json(['message' => 'Cryptocurrency prices stored successfully']);
    }
}
