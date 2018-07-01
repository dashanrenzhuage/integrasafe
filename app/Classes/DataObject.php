<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Laravel classes
 */
use Illuminate\Http\Request;
use stdClass;
use UserAgentParser\Exception\NoResultFoundException;
use UserAgentParser\Exception\PackageNotLoadedException;
use UserAgentParser\Provider\PiwikDeviceDetector;

/**
 * Modal classes
 */

/**
 * This is a resusable function/class to create an object based on a user's action.
 *
 * Action types:
 * Arrival & Submit
 *
 * Class DataObject
 * @package App\Classes
 */
class DataObject
{
    /**
     * @var stdClass $object
     * @var array|string $userAgent
     * @var PiwikDeviceDetector $provider
     */
    private $object;
    private $userAgent;
    private $provider;

    /**
     * DataObject constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->object = new stdClass();

        $new_form = $request->all();
        $ip_address = $request->ip();

        if (!empty($new_form)) {
            $this->merge($new_form);
        }

        $this->storeIP($ip_address);
        try {
            $this->provider = new PiwikDeviceDetector();
        } catch (PackageNotLoadedException $e) {
            // do nothing
        }
        $this->userAgent = $request->header('User-Agent');

        self::buildObject();
    }

    /**
     * Private Method
     *
     * @param array $form
     */
    private function merge(array $form)
    {
        $this->object->form = $form;
    }

    /**
     * Private Method
     *
     * @param string $ip
     */
    private function storeIP(string $ip)
    {
        $this->object->ip = $ip;
    }

    /**
     * This builds an object based on the request provided and user agent.
     */
    private function buildObject()
    {
        try {
            /* @var $result \UserAgentParser\Model\UserAgent */
            $result = $this->provider->parse($this->userAgent);
        } catch (NoResultFoundException $exception) {
            // nothing found
        }

        if (isset($result)) {
            $this->object->browser = $result->getBrowser()->toArray();
            $this->object->rendering = $result->getRenderingEngine()->toArray();
            $this->object->os = $result->getOperatingSystem()->toArray();
            $this->object->device = $result->getDevice()->toArray();
            $this->object->bot = $result->getBot()->toArray();
        }
    }

    /**
     * Main Getter/Fetch method
     *
     * @return stdClass Returns the Class variable data object
     */
    public function fetch()
    {
        return $this->object;
    }
}
