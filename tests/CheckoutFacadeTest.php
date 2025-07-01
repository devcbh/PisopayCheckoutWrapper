<?php

namespace Devcbh\tests;

use Devcbh\CheckoutWrapper\Facades\Checkout;
use PHPUnit\Framework\TestCase;
use Mockery;

class CheckoutFacadeTest extends TestCase
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

    public function testFacadeSessionGenerate()
    {
        // This is a basic test to ensure the Facade class exists
        // In a real Laravel application, you would use Laravel's testing tools
        // to properly test the Facade functionality
        $this->assertTrue(class_exists(Checkout::class));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}