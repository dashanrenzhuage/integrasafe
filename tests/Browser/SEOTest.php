<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * SEO stands for Search Engine Optimization.
 *
 * Class StandardsTest
 * @package Tests\Browser
 */
class SEOTest extends DuskTestCase
{
    /**
     * @group sitemaps
     */
    public function testSitemaps()
    {
        echo "\n\nRunning SEO Tests\n";

        $files = ['sitemap', 'rss', 'atom'];
        $domains = [
            'https://dev.integrasafe.net/',
            'https://dev.custompcb.net/',
            'https://dev.eeminc.net/'
        ];

        foreach ($domains as $domain) {
            foreach ($files as $file_name) {
                $this->checkXml($domain . $file_name);
            }
        }
    }

    /**
     * @param $complete_url
     */
    protected function checkXml($complete_url)
    {
        $this->browse(function (Browser $browser) use ($complete_url) {
            $browser->visit($complete_url . '.xml')
                ->maximize()
                ->assertSee('The document tree is shown below.');
        });
    }
}
