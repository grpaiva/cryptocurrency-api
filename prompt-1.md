## Prompt:

```
Let's build an API using PHP and Laravel framework. This API will be RESTful and should follow all best programming practices. It should have a few endpoints where it displays cryptocurrencies prices.
```

## Response:

Sure, let's get started!

First, we need to create a new Laravel project. You can do this by running the following command in your terminal:

```
laravel new cryptocurrency-api
```

Once the project is created, let's create a new controller that will handle the endpoints for displaying cryptocurrency prices. Run the following command:

```
php artisan make:controller CryptocurrencyController
```

Now let's define the endpoints in the `CryptocurrencyController`. We'll create two endpoints: one to get the price of a single cryptocurrency and another to get the prices of all cryptocurrencies.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptocurrencyController extends Controller
{
    public function getSinglePrice($coin)
    {
        // code to get the price of a single cryptocurrency
    }

    public function getAllPrices()
    {
        // code to get the prices of all cryptocurrencies
    }
}
```

In the `getSinglePrice` method, we'll pass in the cryptocurrency symbol as a parameter. In the `getAllPrices` method, we'll return the prices of all cryptocurrencies.

Next, let's define the routes for these endpoints in `routes/api.php`:

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptocurrencyController;

Route::get('/cryptocurrency/{coin}', [CryptocurrencyController::class, 'getSinglePrice']);
Route::get('/cryptocurrency', [CryptocurrencyController::class, 'getAllPrices']);
```

Now we can define the logic for getting the cryptocurrency prices. We'll use an external API to get the prices. For this example, we'll use CoinGecko API. You can sign up for a free API key at https://www.coingecko.com/en/api.

First, let's install Guzzle, a PHP HTTP client, to make requests to the CoinGecko API:

```
composer require guzzlehttp/guzzle
```

Next, let's update the `getSinglePrice` method to make a request to the API and return the price of the specified cryptocurrency:

```php
public function getSinglePrice($coin)
{
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', "https://api.coingecko.com/api/v3/simple/price?ids=$coin&vs_currencies=usd");

    $price = json_decode($response->getBody(), true)[$coin]['usd'];

    return response()->json(['price' => $price]);
}
```

Here, we're making a GET request to the CoinGecko API with the specified cryptocurrency symbol and returning the price in USD.

Finally, let's update the `getAllPrices` method to make a request to the CoinGecko API and return the prices of all cryptocurrencies:

```php
public function getAllPrices()
{
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,litecoin&vs_currencies=usd");

    $prices = json_decode($response->getBody(), true);

    return response()->json(['prices' => $prices]);
}
```

Here, we're making a GET request to the CoinGecko API with three popular cryptocurrencies and returning their prices in USD.

And that's it! Now you have a RESTful API built with PHP and Laravel that displays cryptocurrency prices. Of course, you can update the endpoints and logic to fit your specific needs. Happy coding!
