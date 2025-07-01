# Checkout Wrapper for Laravel

A Laravel-friendly wrapper for the Pisopay Checkout API.

## Installation

You can install the package via composer:

```bash
composer require devcbh/checkout-wrapper
```

The package will automatically register its service provider.

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Devcbh\CheckoutWrapper\CheckoutWrapperServiceProvider" --tag="config"
```

This will create a `config/checkout-wrapper.php` file in your app. You can set your API credentials in your `.env` file:

```
CHECKOUT_API_ENDPOINT=https://api.example.com
CHECKOUT_API_VERSION=v1
CHECKOUT_API_USERNAME=your-username
CHECKOUT_API_PASSWORD=your-password
```

## Usage

### Using the Instance

```php
use Devcbh\CheckoutWrapper\Checkout;

// Instantiate the class
$checkout = app(Checkout::class);

// Generate a session
$sessionId = $checkout->sessionGenerate();

// Generate a token
$details = [
    // Payment details
];
$arrayData = [
    // Required data
];
$token = $checkout->generateToken($details, $arrayData);

// Generate a reference number
$referenceNumber = $checkout->generateReferenceNumber($arrayData);

// Create hashes
$hash = $checkout->hashMaker($time, $merchant_trace_no, $payment_channel_code);
$hash1 = $checkout->hashMaker1($y, $merchant_trace_no, $time);
```

### Using the Facade

```php
use Devcbh\CheckoutWrapper\Facades\Checkout;
// Or use the alias which is automatically registered
// use Checkout;

// Generate a session
$sessionId = Checkout::sessionGenerate();

// Generate a token
$details = [
    // Payment details
];
$arrayData = [
    // Required data
];
$token = Checkout::generateToken($details, $arrayData);

// Generate a reference number
$referenceNumber = Checkout::generateReferenceNumber($arrayData);

// Create hashes
$hash = Checkout::hashMaker($time, $merchant_trace_no, $payment_channel_code);
$hash1 = Checkout::hashMaker1($y, $merchant_trace_no, $time);
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
