<?php
declare(strict_types=1);

/**
 * This file is for recalculating the Price based on size, quantity, and lead variables.
 */

namespace App\Classes;

/**
 * Class CalculatePrice
 * @package App\Classes This class calculates the price of the order.
 */

/**
 * Class CalculatePrice
 * @package App\Classes
 */
class CalculatePrice
{
    private static $leadOne = 24.87;
    private static $leadTwo = 0.00;
    private static $leadThree = -2.50;
    private static $leadFour = -5.00;
    private static $leadFive = -7.50;
    private static $leadSix = -10.00;
    /**
     * @var int $basePrice defines the starting price.
     *
     * @var float $leadOne
     * @var float $leadTwo
     * @var float $leadThree
     * @var float $leadFour
     * @var float $leadFive
     * @var float $leadSix
     */
    public $basePrice = 5;

    /**
     * Price Stacking (main)
     *
     * This method uses @method size_price, @method quantityPrice, and @method lead_price to recalculate the price.
     *
     * @param int $width This is the width of the board.
     * @param int $length This is the length of the board.
     * @param int $quantity This is the quantity of boards.
     * @param int|null $lead This is the time to manufacture and ship.
     * @return float Returns the price after stacking
     */
    public function stack(int $width, int $length, int $quantity, int $lead = null)
    {
        $price = $this->sizePrice($width, $length);

        $price = $this->quantityPrice($price, $quantity);

        if ($lead) {
            $price = $this->leadPrice($price, $lead);
        }

        /*
         * Check how many digits are trailing the decimal place.
         * Add leading zeros or round up decimal if necessary.
         */
        $price = round($price, 2, PHP_ROUND_HALF_UP);

        $format_price = strrchr("$price", ".");

        if ($format_price) {
            $decimal_places = strlen(substr("$format_price", 1));
            if ($decimal_places === 1) {
                $price = sprintf('%0.2f', $price);
            }
        }

        return $price;
    }

    /**
     * @param int $variable
     * @param float $final
     * @return float|int
     */
    private function sizeXY(int $variable, float $final)
    {

        if ($variable <= 100) {
            $final = 1;
        } elseif ($variable > 100 && $variable < 199) {
            $final = 1.2;
        } elseif ($variable >= 200) {
            $final = 1.4;
        } else {
            $final = 1;
        }

        return $final;
    }

    /**
     * Update Price based on Size
     * Helper function for @method stack.
     *
     * This method takes the price (before update) and the size dimensions then totals a new price amount based on how
     * small/large the Width and Length are. Larger size equals larger price.
     *
     * @param int $width
     * @param int $length
     * @return float
     */
    public function sizePrice(int $width, int $length)
    {
        $x_size = $this->sizeXY($width, 1.225);
        $y_size = $this->sizeXY($length, 1.225);

        return $x_size * $y_size * $this->basePrice;
    }

    /**
     * Update Price based on Quantity.
     * Helper function for @method stack.
     *
     * This method takes the price (before update) and the number of items being asked and recalculates the price based
     * on the quantity and the savings growth.
     *
     * @param float $price
     * @param int $quantity
     * @return float Returns the new price based on Quantity
     */
    public function quantityPrice(float $price, int $quantity)
    {
        $savings_growth = $quantity * 0.001;

        return ($quantity * $price) - (($quantity * $price) * $savings_growth);
    }

    /**
     *
     * Update Price based on Lead
     * Helper function for @method stack.
     *
     * Uses Class LeadTimePercentage that handles the lead_time_prec table entry in the custompcb Database.
     * This method takes the price (before update) and the lead then totals a new price amount based on ...
     *
     * @param float $price
     * @param int $lead
     * @return float
     */
    public function leadPrice(float $price, int $lead)
    {
        $lead_type = null;

        switch ($lead) {
            case '12':
                $lead_type = self::$leadOne;
                break;
            case '23':
                $lead_type = self::$leadTwo;
                break;
            case '34':
                $lead_type = self::$leadThree;
                break;
            case '45':
                $lead_type = self::$leadFour;
                break;
            case '56':
                $lead_type = self::$leadFive;
                break;
            case '67':
                $lead_type = self::$leadSix;
                break;
            default:
                return $price;
        }

        return ($price * ($lead_type / 100)) + $price;
    }

}
