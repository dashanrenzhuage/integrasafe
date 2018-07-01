<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 7/19/2017
 * Time: 6:51 PM
 */

namespace App\Classes;


/**
 * Class TimeChecks
 * @package App\Classes
 */
class TimeChecks
{
    public $yesterday;
    public $dateNow;
    public $dateThen;
    public $dayNow;
    public $dayThen;

    /**
     * TimeChecks constructor.
     * @param $dataTime
     */
    public function __construct($dataTime)
    {
        $time_check = substr($dataTime, -14, 5);
        $yesterday = substr(date('Y-m-d', time() - 86400), -5);

        // Subtrings the timechecks to be the 2 digit Month (i.e. 06-21 would be 06)
        $this->dateNow = substr($time_check, 0, -3);
        $this->dateThen = substr($yesterday, 0, -3);

        // Substrings the timechecks to be the 2 digit Day (i.e. 06-21 would be 21)
        $this->dayNow = substr($time_check, 3);
        $this->dayThen = substr($yesterday, 3);
    }
}
