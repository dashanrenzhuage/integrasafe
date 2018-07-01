<?php
declare(strict_types=1);

namespace Tests\Browser;

use Faker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * IntegraSafe Homepage Test
 *
 * Class Index
 * @package Tests\Browser
 */
class ISHomepageTest extends DuskTestCase
{
    /**
     * @group integrasafeIndex
     */
    public function testIndex()
    {
        $base_url = 'https://dev.integrasafe.net';

        // Logout (cont.)
        $this->browse(function ($browser) use ($base_url) {
            // User should now be logged out
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->waitFor('#main-content', 3)
                // Slogan / Main Header Section
                ->assertVisible('#slogan')
                ->assertSeeIn('#slogan', 'INTEGRASAFE, Inc.')
                // Newsletter Form
                ->assertVisible('#newsletter')
                ->assertSeeIn('#newsletter', 'Sign up to our Newsletter!')
                // Company Timeline Section
                ->assertVisible('#timeline')
                ->assertSeeIn('#timeline', 'Company Timeline')
                // inSight Product Section
                ->assertVisible('#insight-product')
                ->assertSeeIn('#insight-product', 'inSight Product')
                ->assertSeeIn('#insight-product', 'Baby Detection')
                ->assertSeeIn('#insight-product', 'Monitor Conditions')
                ->assertSeeIn('#insight-product', 'Receive Alerts')
                ->assertSeeIn('#insight-product', 'Update Relatives');
        });
    }

    /**
     * @group integrasafeNewsletter
     */
    public function testNewsletter()
    {
        $base_url = 'https://dev.integrasafe.net';

        $faker = Faker\Factory::create();
        $dup_email = $faker->safeEmail;

        // Error - Homepage
        $this->browse(function ($browser) use ($base_url) {
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->waitFor('#main-content', 3)
                ->waitFor('#newsletter', 3)
                ->assertVisible('#newsletter')
                ->assertSeeIn('#newsletter', 'Sign up to our Newsletter!')
                ->with('#newsletter', function ($newsletter) {
                    $newsletter->click('#newsletter-submit')
                        ->assertVisible('#newsletter-error')
                        ->assertSeeIn('#newsletter-error', 'Email Address is required!');
                });
        });

        // Error - Temp Page
        $this->browse(function ($browser) use ($base_url) {
            $browser->visit($base_url . "/purchase")
                ->maximize()
                ->assertRouteIs('integrasafe:purchase[get]')
                ->waitFor('#main-content', 3)
                ->waitFor('#temp', 3)
                ->assertVisible('#temp')
                ->assertSeeIn('#temp', 'This Page is currently being built')
                ->with('#temp', function ($newsletter) {
                    $newsletter->click('#newsletter-submit')
                        ->assertVisible('#newsletter-error')
                        ->assertSeeIn('#newsletter-error', 'Email Address is required!');
                });
        });

        // Success - Homepage
        $this->browse(function ($browser) use ($base_url, $dup_email) {
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->waitFor('#main-content', 3)
                ->waitFor('#newsletter', 3)
                ->assertVisible('#newsletter')
                ->assertSeeIn('#newsletter', 'Sign up to our Newsletter!')
                ->with('#newsletter', function ($newsletter) use ($dup_email) {
                    $newsletter->type('email', $dup_email)
                        ->click('#newsletter-submit')
                        ->waitFor('#newsletter-success', 5)
                        ->assertVisible('#newsletter-success')
                        ->assertSeeIn('#newsletter-success', 'Thank you for signing up to our newsletter, we will be in touch soon!');
                });
        });

        // Success - Temp Page
        $this->browse(function ($browser) use ($base_url, $faker) {
            $browser->visit($base_url . "/signin")
                ->maximize()
                ->assertRouteIs('integrasafe:signin[get]')
                ->waitFor('#main-content', 3)
                ->assertVisible('#temp')
                ->waitFor('#temp', 3)
                ->assertSeeIn('#temp', 'This Page is currently being built')
                ->with('#temp', function ($newsletter) use ($faker) {
                    $newsletter->type('email', $faker->safeEmail)
                        ->click('#newsletter-submit')
                        ->waitFor('#newsletter-success', 5)
                        ->assertVisible('#newsletter-success')
                        ->assertSeeIn('#newsletter-success', 'Thank you for signing up to our newsletter, we will be in touch soon!');
                });
        });

        // Duplicate - Homepage
        $this->browse(function ($browser) use ($base_url, $dup_email) {
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->waitFor('#main-content', 3)
                ->waitFor('#newsletter', 3)
                ->assertVisible('#newsletter')
                ->assertSeeIn('#newsletter', 'Sign up to our Newsletter!')
                ->with('#newsletter', function ($newsletter) use ($dup_email) {
                    $newsletter->type('email', $dup_email)
                        ->click('#newsletter-submit')
                        ->waitFor('#newsletter-success', 5)
                        ->assertVisible('#newsletter-success')
                        ->assertSeeIn('#newsletter-success', 'Email address is already subscribed!');
                });
        });

        // Duplicate - Temp Page
        $this->browse(function ($browser) use ($base_url, $dup_email) {
            $browser->visit($base_url . "/faqs")
                ->maximize()
                ->assertRouteIs('integrasafe:faqs[get]')
                ->waitFor('#main-content', 3)
                ->waitFor('#temp', 3)
                ->assertVisible('#temp')
                ->assertSeeIn('#temp', 'This Page is currently being built')
                ->with('#temp', function ($newsletter) use ($dup_email) {
                    $newsletter->type('email', $dup_email)
                        ->click('#newsletter-submit')
                        ->waitFor('#newsletter-success', 5)
                        ->assertVisible('#newsletter-success')
                        ->assertSeeIn('#newsletter-success', 'Email address is already subscribed!');
                });
        });
    }

    /**
     * @group integrasafeIndex
     */
    public function testDrawer()
    {
        $base_url = 'https://dev.integrasafe.net';

        $this->browse(function (Browser $browser) use ($base_url) {
            // User should still be logged in from previous test
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->click('.mdl-layout__drawer-button')
                ->waitForText('Navigation')
                ->assertSeeIn('.mdl-layout__drawer', 'Navigation')
                ->with('.mdl-layout__drawer', function ($slider) {
                    // Homepage
                    $slider->assertSeeLink('Home')
                        ->clickLink('Home')
                        ->assertRouteIs('integrasafe:index')
                        ->waitFor('#main-content', 3)
                        ->assertVisible('#slogan')
                        ->assertVisible('#newsletter')
                        ->assertVisible('#timeline')
                        ->assertVisible('#insight-product');
                });
            // --- --- Temporary Pages --- --- //
            $this->drawerHelper($browser, 'Sign in', 'integrasafe:signin[get]');
            $this->drawerHelper($browser, 'Purchase', 'integrasafe:purchase[get]');
            $this->drawerHelper($browser, 'FAQs', 'integrasafe:faqs[get]');
        });
    }

    /**
     * @param $browser
     * @param $link
     * @param $route
     */
    private function drawerHelper($browser, $link, $route)
    {
        $browser->click('.mdl-layout__drawer-button')
            ->waitForText('Navigation')
            ->with('.mdl-layout__drawer', function ($slider) use ($link, $route) {
                // Homepage
                $slider->assertSeeLink($link)
                    ->clickLink($link)
                    ->assertRouteIs($route)
                    ->waitFor('#main-content', 3)
                    ->assertVisible('#slogan')
                    ->assertVisible('#temp');
            });
    }

    /**
     * @group integrasafeIndex
     */
    public function testTempLinks()
    {
        $base_url = 'https://dev.integrasafe.net';

        // Logout (cont.)
        $this->browse(function ($browser) use ($base_url) {
            // User should now be logged out
            $browser->visit($base_url)
                ->maximize()
                ->assertRouteIs('integrasafe:index')
                ->waitFor('#main-content', 3)
                ->assertVisible('#slogan')
                ->assertVisible('#newsletter')
                ->assertVisible('#timeline')
                ->assertVisible('#insight-product')
                ->with('.mdc-toolbar__row', function ($navbar) {
                    // Sign in
                    $navbar->assertSeeLink('Sign in')
                        ->clickLink('Sign in')
                        ->assertRouteIs('integrasafe:signin[get]')
                        ->waitFor('#main-content', 3)
                        ->assertVisible('#slogan')
                        ->assertVisible('#temp')
                        ->assertSeeIn('#temp', 'This Page is currently being built')
                        ->assertSeeLink('Home')
                        ->clickLink('Home')
                        ->assertRouteIs('integrasafe:index')
                        // Purchase
                        ->assertSeeLink('Purchase')
                        ->clickLink('Purchase')
                        ->assertRouteIs('integrasafe:purchase[get]')
                        ->waitFor('#main-content', 3)
                        ->assertVisible('#slogan')
                        ->assertVisible('#temp')
                        ->assertSeeIn('#temp', 'This Page is currently being built')
                        ->assertSeeLink('Home')
                        ->clickLink('Home')
                        ->assertRouteIs('integrasafe:index')
                        // FAQs
                        ->assertSeeLink('FAQs')
                        ->clickLink('FAQs')
                        ->assertRouteIs('integrasafe:faqs[get]')
                        ->waitFor('#main-content', 3)
                        ->assertVisible('#slogan')
                        ->assertVisible('#temp')
                        ->assertSeeIn('#temp', 'This Page is currently being built')
                        ->assertSeeLink('Home')
                        ->clickLink('Home')
                        ->assertRouteIs('integrasafe:index');
                });

        });
    }
}
