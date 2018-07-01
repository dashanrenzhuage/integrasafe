<?php

namespace App\Classes;

use DateTime;
use DateTimeZone;

// Set local date and time base on timezone
class LocalDateTime
{
    private $date_string;

    /**
     * LocalDateTime constructor.
     * @param $timestamp
     * @param $timezone
     */
    public function __construct($timestamp, $timezone = 'UTC')
    {
        $date = new DateTime($timestamp);
        // Set timezone
        $date->setTimezone(new DateTimeZone($timezone));
        $this->date_string = $date->format('M. d, y (h:i A)');
    }

    /**
     * Getter Function
     */
    public function string()
    {
        return $this->date_string;
    }
}
