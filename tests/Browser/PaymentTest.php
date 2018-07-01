<?php
declare(strict_types=1);

namespace Tests\Browser;

use Tests\DuskTestCase;

/**
 * Payment Test
 *
 * Class Payment
 * @package Tests\Browser
 */
class PaymentTest extends DuskTestCase
{
    /**
     * Test the addition of Items into the Cart and resulting actions caused by that addition
     * @group PaymentSystem
     */
    public function testCart()
    {
        $base_url = 'https://dev.integrasafe.net';

        // Create some products to be used
//        $skus = factory(ProductInventory::class, 1)->create();

        try {
            $this->browse(function ($browser) use ($base_url) {
                $browser->visit($base_url)
                    ->maximize()
                    ->assertPathIs('/')
                    ->assertRouteIs('integrasafe:index')
                    ->waitFor('#main-content', 3)
                    ->assertVisible('#slogan')
                    ->assertSeeIn('#slogan', 'INTEGRASAFE, Inc.')
                    ->visit($base_url . "/purchase")
                    ->waitFor('#main-content', 3)
                    ->assertRouteIs('integrasafe:purchase[get]')
                    ->assertVisible('#payment_process');
            });
        } catch (\Exception $exception) {
            $this->handleExceptions($exception);
        } catch (\Throwable $exception) {
            $this->handleExceptions($exception);
        }

        // Test adding an item to the Cart and continue shopping
        $this->testDialogContinue();
        $this->testDialogCheckout();
    }

    /**
     * (Helper Function)
     * Captures the resulting Dusk exception into Sentry.io
     * @param $exception
     */
    private function handleExceptions($exception)
    {
        app('sentry')->captureMessage($exception);
    }

    /**
     * (Helper Function)
     * Tests adding an Item to the Cart and then continue shopping products
     */
    private function testDialogContinue()
    {
        try {
            $this->browse(function ($browser) {
                $browser->assertRouteIs('integrasafe:purchase[get]')
                    ->assertVisible('#payment_process')
                    ->assertVisible('#products')
                    ->with('#products', function ($products) {
                        $products->click('.button-product')
                            ->waitFor('#payment_process', 3)
                            ->with('#payment_process', function ($dialog) {
                                $dialog->waitUntilMissing('#progressbar')
                                    ->assertSeeIn('#progress-dialog-header', 'Item successfully added to Cart!')
                                    ->assertVisible('#dialog-buttons')
                                    ->assertVisible('#continue-shopping')
                                    ->assertVisible('#checkout')
                                    ->click('#continue-shopping');
                            });
                    })
                    ->assertRouteIs('integrasafe:purchase[get]')
                    ->assertVisible('#payment_process')
                    ->assertVisible('#products');
            });
        } catch (\Exception $exception) {
            $this->handleExceptions($exception);
        } catch (\Throwable $exception) {
            $this->handleExceptions($exception);
        }
    }

    /**
     * (Helper Function)
     * Tests adding an Item to the Cart and then going to the Checkout page
     */
    private function testDialogCheckout()
    {
        try {
            $this->browse(function ($browser) {
                $browser->assertRouteIs('integrasafe:purchase[get]')
                    ->assertVisible('#payment_process')
                    ->assertVisible('#products')
                    ->with('#products', function ($products) {
                        $products->click('.button-product')
                            ->waitFor('#payment_process', 3)
                            ->with('#payment_process', function ($dialog) {
                                $dialog->waitUntilMissing('#progressbar')
                                    ->assertSeeIn('#progress-dialog-header', 'Item successfully added to Cart!')
                                    ->assertVisible('#dialog-buttons')
                                    ->assertVisible('#continue-shopping')
                                    ->assertVisible('#checkout')
                                    ->click('#checkout');
                            });
                    })
                    ->assertRouteIs('integrasafe:payment[get]')
                    ->assertVisible('#payment_process')
                    ->assertVisible('#payment-form');
            });
        } catch (\Exception $exception) {
            $this->handleExceptions($exception);
        } catch (\Throwable $exception) {
            $this->handleExceptions($exception);
        }
    }

    /**
     * Tests the Payment form where User's turn into Customers by inputting their card information,
     * shipping and billing addresses, and select how fast they want their selected Products to arrive.
     * @group PaymentSystem
     */
    public function testCheckout()
    {
        $base_url = 'https://dev.integrasafe.net';
        $faker = \Faker\Factory::create();

        // Build a Fake Customer
        $customer = [
            'name' => $faker->name, 'email' => $faker->safeEmail, 'address' => $faker->streetAddress,
            'city' => $faker->city, 'state' => $faker->safeColorName, 'country' => $faker->country, 'zip' => $faker->postcode
        ];

        try {
            $this->browse(function ($browser) use ($base_url, $faker, $customer) {
                $browser->assertRouteIs('integrasafe:payment[get]')
                    ->assertVisible('#payment_process')
                    ->assertVisible('#payment-form')
                    ->with('#payment-form', function ($form) use ($customer) {
                        $form->assertVisible('#cart-products')
                            ->assertSeeIn('#cart-products', 'Selected Products')
                            ->assertVisible('#select-shipping')
                            ->assertSeeIn('#select-shipping', 'Shipping Speed')
                            ->assertVisible('#pricing-total')
                            ->assertSeeIn('#pricing-total', 'Order Total')
                            ->assertVisible('#submit-form')
                            ->assertVisible('#payment-information')
                            ->assertSeeIn('#payment-information', 'Personal Information')
                            // empty the contents of the form
                            ->clear('cardholderName')
                            ->clear('cardholderEmail')
                            ->clear('billingAddress')
                            ->clear('billingCity')
                            ->clear('billingState')
                            ->clear('billingCountry')
                            ->clear('billingZipCode')
                            // Fill out the Payment Information section
                            ->type('cardholderName', $customer['name'])
                            ->assertInputValue('cardholderName', $customer['name'])
                            ->type('cardholderEmail', $customer['email'])
                            ->assertInputValue('cardholderName', $customer['name'])
//                            ->type('#card-element', $faker->safeEmail)
                            ->type('billingAddress', $customer['address'])
                            ->assertInputValue('billingAddress', $customer['address'])
                            ->type('billingCity', $customer['city'])
                            ->assertInputValue('billingCity', $customer['city'])
                            ->type('billingState', $customer['state'])
                            ->assertInputValue('billingState', $customer['state'])
                            ->type('billingCountry', $customer['country'])
                            ->assertInputValue('billingCountry', $customer['country'])
                            ->type('billingZipCode', $customer['zip'])
                            ->assertInputValue('billingZipCode', $customer['zip'])
                            // Hide Shipping Section
                            ->assertVisible('#shipping-information')
                            ->check('hide-shipping')
                            ->waitUntilMissing('#shipping-information')
                            ->assertMissing('#shipping-information');
                    });
            });
        } catch (\Exception $exception) {
            $this->handleExceptions($exception);
        } catch (\Throwable $exception) {
            $this->handleExceptions($exception);
        }
    }
}
