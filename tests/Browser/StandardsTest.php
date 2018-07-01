<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class StandardsTest extends DuskTestCase
{
    /**
     * @group sitemaps
     */

    public function testXml()
    {
        echo "\n\nRunning Sitemap Standards Tests\n";

        $files = ['sitemap', 'rss'];
        $domains = [
            'https://dev.integrasafe.net/',
            'https://dev.custompcb.net/',
            'https://dev.eeminc.net/'
        ];

        foreach ($domains as $domain) {
            foreach ($files as $file) {
                $this->visitStandard($domain, $file);
            }
        }
    }

    /**
     * @param $domain
     * @param $file
     */
    protected function visitStandard($domain, $file)
    {
        $this->browse(function (Browser $browser) use ($domain, $file) {
            $browser->visit($domain . $file . '.xml')
                ->maximize()
                ->assertSee('The document tree is shown below.');
        });
    }
}
