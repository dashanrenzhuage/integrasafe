<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Class DisplayGroups
 * @package App\Classes
 */
class DisplayGroups
{
    /**
     * @var int Default lead integer
     */
    public $leadDefault = 23;

    /**
     * @var string Selected
     */
    public $selected = 'selected';

    /**
     * @var string False
     */
    public $setFalse = 'false';

    /**
     * Display the select list of options for the form Quantity with the selected value.
     *
     * @param array|null $quantity Quantity initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formQuantity($quantity = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $quantity = self::cookieChecker($quantity, 'quantity');

        // initialize html and counter
        $quantities = [];
        $counter = 0;

        while ($counter < 200) {
            // Create a new option Object to hold the HTML selector's attributes
            $option = new \stdClass();

            // If the acc counter is inbetween 50 and 99, add 10 to the counter
            if ($counter >= 50 && $counter < 100) {
                $counter += 10;
                // If the counter is only below 50, add 5 to the counter
            } elseif ($counter < 50) {
                $counter += 5;
                // If the counter is above 100, add 25 to the counter
            } else {
                $counter += 25;
            }

            // If the counter is the same as the quantity, updated selected variable.
            if ($counter === (int)$quantity) {
                $option->selected = $this->selected;
                // Otherwise leave selected variable empty
            } else {
                $option->selected = null;
            }

            // Set the option's Value property to be the current quantity's number
            $option->value = $counter;
            // Add the option to the array of other Options
            $quantities[] = $option;

        }

        return $quantities;
    }

    /**
     * Display the select list of options for the form layers field with the selected value.
     *
     * @param array|null $layer_selected Layers initialized as Null
     * @return array
     */
    public function formLayers($layer_selected = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $layer_selected = self::cookieChecker($layer_selected, 'layers');

        $counter = 0;
        $layers = [];

        while ($counter < 14) {
            $layer = new \stdClass();
            $layer->pural = null;
            $layer->selected = null;

            if ($counter < 2) {
                $counter += 1;
            } else {
                $counter += 2;
            }

            if ($counter != 1) {
                $layer->pural = 's';
            }

            // If the counter is equal to the parameter $layers,
            // then updated the selected variable to active. Otherwise, set the selected variable to Null.
            if ($counter == $layer_selected || ($counter === 2 && empty($layer_selected))) {
                $layer->selected = $this->selected;
            }

            $layer->counter = $counter;
            $layer->label = $counter . ' layer' . $layer->pural;
            $layers[] = $layer;
        }

        return $layers;
    }

    /**
     * Display the select list of options for the form Thickness field with the selected values.
     *
     * @param array|null $thick
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formThickness($thick = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $thick = self::cookieChecker($thick, "thickness");

        // Initialize empty HTML string and a counter.
        $thickness = [];
        $counter = 0.2;

        while ($counter < 2.4) {
            $option = new \stdClass();
            $counter += 0.2;

            if (ctype_digit((string)$counter)) {
                $counter = sprintf("%0.1f", $counter);
            }
            // If the string representation of the counter equal the string representation of the thickness,
            // Update the selected variable to active. Otherwise, set it to be unactive
            if ((string)$counter === (string)$thick || ($counter === 0.4 && empty($thick))) {
                $option->selected = $this->selected;
            } else {
                $option->selected = null;
            }

            $option->element_id = "thick_".$counter;
            $option->value = $counter;
            $thickness[] = $option;
        }

        return $thickness;
    }

    /**
     * Display the select list of options for the form designs field with the selected value
     *
     * @param array|null $design Different_Designs initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formDesigns($design = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $design = self::cookieChecker($design, 'designs');

        // Initialize empty HTML string, accumulating counter, and a label string defaulted to 'design'
        $designs = [];
        $counter = 0;

        $label = 'design';

        while ($counter < 10) {
            $option = new \stdClass();
            $counter += 1;

            // Update redundency to make sure label is set to 'designs'
            if ($counter !== 1) {
                $label = 'designs';
            }

            if ((string)$counter === (string)$design || ($counter === 1 && empty($design))) {
                $option->selected = $this->selected;
            } else {
                $option->selected = null;
            }

            $option->label = $label;
            $option->counter = $counter;

            $designs[] = $option;
        }

        return $designs;
    }

    /**
     * Display the select list of options for the form Silkscreen with the selected value.
     *
     * @param array|null $silkscreen Silkscreen initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formSilkscreen($silkscreen = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $silkscreen = self::cookieChecker($silkscreen, 'silkscreen');

        $options = [[$this->setFalse, 'None'], ['white', 'White'], ['black', 'Black']];

        $silkscreens = self::optionsBuilder($options, 3, $silkscreen);

        return $silkscreens;
    }

    /**
     * Display the select list of options for the form FR4_TG with the selected value.
     *
     * @param array|null $fr4_tg FR4_TG initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formFR4($fr4_tg = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $fr4_tg = self::cookieChecker($fr4_tg, 'fr4_tg');

        $options = [['34', 'FR4 130 - 140 TG'], ['56', 'FR4 150 - 160 TG'], ['78', 'FR4 170 - 180 TG']];

        return self::optionsBuilder($options, 3, $fr4_tg);
    }

    /**
     * Display the select list of options for the form Soldermask with the selected value.
     *
     * @param array|null $soldermask Soldermask initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formSoldermask($soldermask = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $soldermask = self::cookieChecker($soldermask, 'soldermask');

        $options = [
            ['green', 'Green', '#008000'],
            ['red', 'Red', '#FF0000'],
            ['yellow', 'Yellow', '#FFFF00'],
            ['blue', 'Blue', '#0000FF'],
            ['white', 'White', '#FFFFFF'],
            ['black', 'Black', '#000000'],
            ['purple', 'Purple', '#800080'],
            ['matt-black', 'Matt black', '#767676'],
            ['matt-green', 'Matt green', '#55B457'],
            [$this->setFalse, 'None', '']
        ];

        return self::optionsBuilder($options, 10, $soldermask, true);
    }

    /**
     * Display the select list of options for the form Min_Track_Spacing with the selected value.
     *
     * @param array|null $min_track Min_Track_Spacing initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formMinTrack($min_track = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $min_track = self::cookieChecker($min_track, 'min_track');

        $options = [['44', '4/4mil'], ['55', '5/5mil'], ['66', '6/6mil']];

        return self::optionsBuilder($options, 3, $min_track);
    }

    /**
     * Display the select list of options for the form Min_Hole_Size with the selected value.
     *
     * @param array|null $min_hole Min_Hole_Size initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formMinHole($min_hole = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $min_hole = self::cookieChecker($min_hole, 'min_hole');

        $holes = [];
        $counter = 0.2;

        while ($counter < 0.35) {
            $option = new \stdClass();

            if ((string)$counter === (string)$min_hole) {
                $option->selected = $this->selected;
            } else {
                $option->selected = null;
            }

            $option->value = $counter;

            $holes[] = $option;

            $counter += 0.05;
        }

        return $holes;
    }

    /**
     * Display the select list of options for the form Gold Fingers with the selected value.
     *
     * @param array|null $gold_finger Gold Fingers initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formGoldFingers($gold_finger = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $gold_finger = self::cookieChecker($gold_finger, 'gold_fingers');

        $options = [['Yes', 'Yes'], [$this->setFalse, 'No']];

        return self::optionsBuilder($options, 2, $gold_finger);
    }

    /**
     * Display the select list of options for the form Surface Finish with the selected value.
     *
     * @param array|null $finish Surface Finish initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formSurface($finish = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $finish = self::cookieChecker($finish, 'surface_finish');

        $options = [['hasl lead free', 'HASL lead free'], ['hasl', 'HASL'], ['immersion gold', 'Immersion gold'],
            ['immersion silver', 'Immersion silver'], ['immersion tin', 'Immersion tin'],
            ['hard gold', 'Hard gold'], ['osp', 'OSP'], ['entek', 'Entek']
        ];

        return self::optionsBuilder($options, 8, $finish);
    }

    /**
     * Display the select list of options for the form Via Process with the selected value.
     *
     * @param array|null $tenting Via Process initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formViaProcess($tenting = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $tenting = self::cookieChecker($tenting, 'via_process');

        $options = [['tenting', 'Tenting vias'], ['plugged', 'Plugged vias'], ['uncovered', 'Vias uncovered']];

        return self::optionsBuilder($options, 3, $tenting);
    }

    /**
     * Display the select list of options for the form Base Copper Oz with the selected value.
     *
     * @param array|null $copper Base Copper Oz initialized as Null
     * @return array Returns the array of Options to be passed to the correct html Blade
     */
    public function formCopper($copper = null)
    {
        // If a Cookie was passed, this means the User has selected an option and that should be the default selected
        $copper = self::cookieChecker($copper, 'base_copper');

        $options = [['0.375', '3/8 oz Cu'], ['0.5', '1/2 oz Cu'], ['1.000', '1 oz Cu'], ['2.000', '2 oz Cu'],
                    ['3.000', '3 oz Cu'], ['4.000', '4 oz Cu']];

        return self::optionsBuilder($options, 6, $copper);
    }

    /**
     * Create the leads radio group
     *
     * @param int $lead Lead initialized as 0
     * @return array Return object containing the values for the HTML radio elements.
     */
    public function formLeads(int $lead = 0)
    {
        // If the passed parameter is NOT Null, then update the Class variable to be the passed parameter
        if ($lead !== 0) {
            $this->leadDefault = $lead;
        }

        $lead_times = [12, 23, 34, 45, 56, 67];
        $leads_label = [
            12 => '1 - 2',
            23 => '2 - 3',
            34 => '3 - 4',
            45 => '4 - 5',
            56 => '5 - 6',
            67 => '6 - 7'
        ];

        $lead_array = [];
        $counter = 1;

        // Loop through the elements in the Leads array
        foreach ($lead_times as $lead_time) {

            $lead_item = new \stdClass();

            if ($counter == 2 && $this->leadDefault === 0) {
                $lead_item->selected = 'checked';
            } else {
                // if the current leads array element matches the Class Variable,
                // set the selected variable to be active, otherwise set it to Null.
                if ((int)$lead_time === $this->leadDefault) {
                    $lead_item->selected = 'checked';
                } else {
                    $lead_item->selected = null;
                }
            }

            $lead_item->time = $lead_time;
            $lead_item->label = $leads_label[$lead_time];

            $lead_array[] = $lead_item;
            $counter++;
        }

        return $lead_array;
    }

    /**
     * Create the random shuffled hyperchannel html
     *
     * @return array
     */
    public function hyperChannel()
    {
        $titles = [
            '0' => 'Buyer Protection',
            '1' => 'Delivery Guarantee',
            '2' => 'Safe Payment',
            '3' => 'Not A Broker'
        ];

        $descriptions = [
            '0' => 'We will refund if the PCB quality is not as described or is with defects',
            '1' => 'You will get full refund if you do not receive your PCBs in the time as agreed.',
            '2' => 'Pay with popular and secure payment methods.',
            '3' => 'Competitive pricing from manufacturers of diverse capabilities.'
        ];

        $icons = [
            '0' => 'security',
            '1' => 'local_shipping',
            '2' => 'payment',
            '3' => 'card_membership'
        ];

        $counter = 1;

        shuffle($titles);

        $hyper_channel = [];

        foreach ($titles as $number => $value) {
            $channel = new \stdClass();

            $channel->icon = $icons[$number];
            $channel->title = $titles[$number];
            $channel->description = $descriptions[$number];
            $counter++;

            $hyper_channel[] = $channel;
        }

        return $hyper_channel;
    }

    /**
     * Create the flow html
     *
     * @param string $active
     * @return array
     */
    public function flow(string $active)
    {
        $stream = [
            'Instant quote', 'Info', 'Account', 'Upload file', 'Order review', 'Payment', 'Fabrication', 'Delivery',
            'Confirmed'
        ];

        $app_flow = [];

        foreach ($stream as $obstruction) {
            $marker = new \stdClass();

            if ($obstruction === $active) {
                $marker->active = 'active';
            } else {
                $marker->active = '';
            }

            $marker->name = $obstruction;
            $app_flow[] = $marker;
        }

        return $app_flow;
    }

    /**
     * Helper Function
     *
     * @param array $options
     * @param int $length
     * @param string $selector
     * @return array
     */
    public function optionsBuilder(array $options, int $length, $selector, $additional = null)
    {
        $final_array = [];
        $counter = 0;

        while ($counter < $length) {
            $option = new \stdClass();

            if ((string)$options[$counter][0] === (string)$selector) {
                $option->selected = $this->selected;
            } else {
                $option->selected = null;
            }

            $option->value = $options[$counter][0];
            $option->label = $options[$counter][1];

            if ($additional) {
                $option->hex = $options[$counter][2];
            }

            $final_array[] = $option;

            $counter += 1;
        }

        return $final_array;
    }

    /**
     * Helper Method
     *
     * @param $cookie
     * @param String $index
     * @return null
     */
    public function cookieChecker($cookie, $index)
    {
        if ($cookie !== null) {
            if (array_key_exists($index, $cookie)) {
                $cookie = $cookie[$index];
            } else {
                $cookie = null;
            }
        } else {
            $cookie = null;
        }

        return $cookie;
    }
}

























