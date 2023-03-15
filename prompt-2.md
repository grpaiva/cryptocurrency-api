## Prompt:

```
Now I don't want our API to be open to anyone. Let's add some authentication using Sanctum or Passport?
```

## Response:

Great idea! Adding authentication will help secure your API and ensure that only authorized users can access it.

Laravel provides two packages for API authentication: Sanctum and Passport. Both packages have their own advantages and disadvantages, so you can choose the one that fits your requirements.

Here's an example of how to add authentication to your API using Sanctum:

First, let's install Sanctum using Composer:

```
composer require laravel/sanctum
```

Next, let's publish the Sanctum configuration file and migration file:

```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Then, let's run the migration to create the necessary database tables:

```
php artisan migrate
```

Now we need to add middleware to our API routes to ensure that the user is authenticated:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cryptocurrency/{coin}', [CryptocurrencyController::class, 'getSinglePrice'])->where('coin', '[a-zA-Z]+');
    Route::get('/cryptocurrency', [CryptocurrencyController::class, 'getAllPrices']);
});
```

Here, we're using the `auth:sanctum` middleware to ensure that the user is authenticated before accessing the `/cryptocurrency` endpoints.

Next, let's add authentication routes to our `routes/api.php` file:

```php
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
```

Here, we're defining routes for user login and registration using the `AuthController`.

Now we need to create the `AuthController` and define the logic for user login and registration. Run the following command to create the controller:

```
php artisan make:controller AuthController
```

Here's an example implementation of the `AuthController`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }
}
```

In the `register` method, we're validating the request data and creating a new user in the database. In the `login` method, we're validating the request data and attempting to authenticate the user using the `attempt` method. If the authentication is successful, we're generating an access token for the user using the `createToken` method and returning it in the response.

This implementation uses Laravel's built-in `User` model for user authentication. You can customize the authentication logic to fit your specific requirements.

And that's it! Now your API is secured with authentication using Sanctum. To access the API endpoints, users must first register and obtain an access token using the `/register` and `/login` endpoints. They can then use the access token to authenticate their requests to the API.
