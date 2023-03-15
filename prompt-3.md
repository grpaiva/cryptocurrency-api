## Prompt:

```
I would really like to store cryptocurrencies prices in our database so we don't have to make API requests to coingecko everytime. Can you think of a database structure to store these values? I want the migrations and models at this point.
```

## Response:

Sure, let's define a database structure that can store cryptocurrency prices. We'll create a `cryptocurrency_prices` table that will store the prices of different cryptocurrencies at different timestamps.

First, let's create a migration to define the `cryptocurrency_prices` table:

```
php artisan make:migration create_cryptocurrency_prices_table --create=cryptocurrency_prices
```

This will create a new migration file called `create_cryptocurrency_prices_table.php` in the `database/migrations` directory. Open this file and add the following code to define the table schema:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptocurrencyPricesTable extends Migration
{
    public function up()
    {
        Schema::create('cryptocurrency_prices', function (Blueprint $table) {
            $table->id();
            $table->string('coin');
            $table->float('price');
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cryptocurrency_prices');
    }
}
```

Here, we're defining the table with four columns: `id`, `coin`, `price`, and `timestamp`. The `coin` column will store the symbol of the cryptocurrency, the `price` column will store the price of the cryptocurrency, and the `timestamp` column will store the timestamp of when the price was retrieved.

Now let's create a model for the `cryptocurrency_prices` table:

```
php artisan make:model CryptocurrencyPrice
```

This will create a new model file called `CryptocurrencyPrice.php` in the `app/Models` directory. Open this file and add the following code to define the model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptocurrencyPrice extends Model
{
    use HasFactory;

    protected $fillable = ['coin', 'price', 'timestamp'];
}
```

Here, we're defining the `CryptocurrencyPrice` model with the `fillable` property to allow mass assignment of the `coin`, `price`, and `timestamp` attributes. We're also using the `HasFactory` trait to generate a factory for the model.

Now that we have the migration and model defined, we can modify the `getAllPrices()` method in our `CryptocurrencyController` to store the prices in the database:

```php
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
```

Here, we're looping through the prices returned by the CoinGecko API and creating a new `CryptocurrencyPrice` instance for each coin with the `coin` and `price` attributes. We're then saving each instance to the database using the `save` method.

Now every time the `getAllPrices()` method is called, the prices of cryptocurrencies will be stored in the database, allowing us to retrieve them without making API requests to CoinGecko.

I hope this helps! Let me know if you have any other questions.
