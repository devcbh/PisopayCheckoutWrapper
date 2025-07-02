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

// Generate a token
$details = [
    array("name" => "itemSample", "price" => "1.00", "quantity" => "1"),
    array("name" => "itemSample1", "price" => "1.00", "quantity" => "2")
];
$arrayData = [
    "branch_code" => "",
    "amount" => "3",
    "delivery_fees" => "0",
    "transaction_type" => "",
    "processor_name" => "",
    "customer_name" => "John Doe",
    "customer_email" => "developer@pisopay.com.ph",
    "customer_phone" => "09091231234",
    "customer_address" => "PH",
    "merchant_trace_no" => "sampleTraceNo12345", //unique trace no 
    "merchant_callback_url" => "https://pisopay.com.ph/received", //status update webhook
    "callback_url" => "https://pisopay.com.ph", //redirection after payment and other returns
    "ip_address" => "192.168.123.1",
    "expiry_date" => "2027-01-01 00:00:00" // any future date
];
$token = $checkout->generateToken($details, $arrayData);

// Generate a reference number
$referenceNumber = $checkout->generateReferenceNumber($arrayData, "PPC"); // 2nd param is the channel code

```

### Using the Facade

```php
//use Devcbh\CheckoutWrapper\Facades\Checkout;
// Or use the alias which is automatically registered
use Checkout;

// Generate a token
$details = [
    array("name" => "itemSample", "price" => "1.00", "quantity" => "1"),
    array("name" => "itemSample1", "price" => "1.00", "quantity" => "2")
];
$arrayData = [
    "branch_code" => "",
    "amount" => "3",
    "delivery_fees" => "0",
    "transaction_type" => "",
    "processor_name" => "",
    "customer_name" => "John Doe",
    "customer_email" => "developer@pisopay.com.ph",
    "customer_phone" => "09091231234",
    "customer_address" => "PH",
    "merchant_trace_no" => "sampleTraceNo12345", //unique trace no 
    "merchant_callback_url" => "https://pisopay.com.ph/received", //status update webhook
    "callback_url" => "https://pisopay.com.ph", //redirection after payment and other returns
    "ip_address" => "192.168.123.1",
    "expiry_date" => "2027-01-01 00:00:00" // any future date
];
$token = Checkout::generateToken($details, $arrayData);

// Generate a reference number
$referenceNumber = Checkout::generateReferenceNumber($arrayData, "PPC"); // 2nd param is the channel code

```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
