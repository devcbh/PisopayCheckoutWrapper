<?php

namespace Devcbh\tests;

use Devcbh\CheckoutWrapper\Checkout;
use PHPUnit\Framework\TestCase;
use Mockery;

class CheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Mock the config function
        if (!function_exists('config')) {
            function config($key, $default = null) {
                $configs = [
                    'checkout-wrapper.api_endpoint' => 'https://api.example.com',
                    'checkout-wrapper.api_version' => 'v1',
                    'checkout-wrapper.api_username' => 'test_user',
                    'checkout-wrapper.api_password' => 'test_password',
                ];

                return $configs[$key] ?? $default;
            }
        }
    }

    public function testCheckoutClassInitialization()
    {
        $checkout = new Checkout();
        $this->assertInstanceOf(Checkout::class, $checkout);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
