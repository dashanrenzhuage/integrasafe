<?php
declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * Class WebStandardsController
 * @package App\Http\Controllers
 */
class SEOController extends Controller
{
    /**
     * @return $this
     */
    public function siteMapXML()
    {
        return response()
            ->view(
                'standards/' . $this->domain() . '/sitemap', [], 200, ['Content-Type' => 'text/xml']
            );
    }

    /**
     * @return string
     */
    private function domain()
    {
        switch (request()->root()) {
            case 'https://custompcb.net':
                $directory = 'pcb';
                break;
            case 'https://dev.custompcb.net':
                $directory = 'pcb';
                break;
            case 'https://eeminc.net':
                $directory = 'vmi';
                break;
            case 'https://dev.eeminc.net':
                $directory = 'vmi';
                break;
            case 'https://integrasafe.net':
                $directory = 'integrasafe';
                break;
            case 'https://dev.integrasafe.net':
                $directory = 'integrasafe';
                break;
            default:
                return ('The domain name was not specified.');
        }
        return $directory;
    }

    /**
     * Shows atom.xml
     *
     * @return $this
     */
    public function atomXML()
    {
        //todo
        //format standards on clean copy of pcb when available
        return response()
            ->view('standards/atom', ['entries' => []], 200, ['Content-Type' => 'text/xml']);
    }

    /**
     * @return $this
     */
    public function rssXML()
    {
        return response()
            ->view('standards/' . $this->domain() . '/rss', [], 200, ['Content-Type' => 'text/xml']);
    }
}
