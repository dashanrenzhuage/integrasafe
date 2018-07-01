<?php
declare(strict_types=1);

namespace App\Classes;

use Illuminate\Support\Facades\Validator;
use Session;

/**
 * Class Validator
 * @package App\Classes
 */
class Validation
{
    private $type;
    // String Constants
    public $validation_empty_value = 'validation.custom.form.empty_value';
    public $max_string = 'max:150|string';

    /**
     * Validation constructor.
     * @param null|string $type
     */
    public function __construct(string $type = 'error')
    {
        $this->type = $type;
    }

    /**
     * Validates the the PCB Ordering Process
     *
     * Checks to make sure Length and Width are present when the calculate button is pressed
     * and if they are integers within the required extremes (25 and 1000)
     *
     * @param $input
     * @param string $keyword
     * @param bool $strict
     * @return string
     */
    public function input($input, string $keyword, $strict = false)
    {
        if ($strict && !$input) {
            return $this->emptyValue($keyword);
        }

        if ($input) {
            if (is_numeric($input)) {
                if ($input > 1000) {
                    return $this->maxRange(1000, $keyword);
                }
                if ($input < 50) {
                    return $this->minRange(50, $keyword);
                }
            } else {
                return $this->error(__('validation.custom.form.not_integer', ['name' => $keyword]));
            }
        }

        return true;
    }

    /**
     * Sets the empty value language string as the new key in the session error array.
     *
     * @param string $keyword
     * @return string
     */
    private function emptyValue(string $keyword)
    {
        return $this->error(__($this->validation_empty_value, ['name' => $keyword]));
    }

    /**
     * Private method
     *
     * This method will flash the message into the error session key.
     * If the error session key already exists, the method will add the error to an array and
     * set the session key as an array.
     *
     * @param string $message
     * @return string
     */
    private function error(string $message)
    {
        $session_error = Session::get($this->type);

        if (empty($session_error)) {
            $error = [];
            $error[] = $message;
            $session_error = $error;
        } else {
            array_push($session_error, $message);
        }

        Session::flash($this->type, $session_error);

        return false;
    }

    /**
     * Sets the max range language string as the new key in the session error array.
     *
     * @param float $max_range
     * @param string $keyword
     * @return string
     */
    private function maxRange(float $max_range, string $keyword)
    {
        return $this->error(__('validation.custom.form.max_range', [
            'name' => $keyword,
            'point' => $max_range
        ]));
    }

    /**
     * Sets the min range language string as the new key in the session error array.
     *
     * @param float $min_range
     * @param string $keyword
     * @return string
     */
    private function minRange(float $min_range, string $keyword)
    {
        return $this->error(__('validation.custom.form.min_range', [
            'name' => $keyword,
            'point' => $min_range
        ]));
    }

    /**
     * Validates max, min, test that the number is numeric or equal to a keyword.
     * If strict is true, then the request input cannot be null
     *
     * @param $input
     * @param array $array
     * @param string $keyword
     * @param bool $strict
     * @return string
     */
    public function select($input, array $array, string $keyword, $strict = false)
    {
        if ($strict && !$input) {
            return $this->emptyValue($keyword);
        }

        if ($input && !in_array($input, $array)) {
            return $this->error($input . ' does not match ' . $keyword . ' options.');
        }

        return true;
    }

    /**
     * Validate Decimal Inputs
     *
     * Method used to validate the decimal input of the Order Online form. It takes the decimal input
     * as well as the max and min range of what to compare to. It times everything, except Minrange, by 100 to remove
     * decimal places for easier comparisons
     *
     * @param $input
     * @param float $max_range
     * @param float $min_range
     * @param string $keyword
     * @param bool $strict
     * @return string
     */
    public function decimal($input, float $max_range, float $min_range, string $keyword, $strict = false)
    {
        if ($strict) {
            if ($input === null) {
                return $this->emptyValue($keyword);
            } elseif ($input === 0) {
                return $this->error($keyword . ' cannot be 0!');
            }
        }

        if ($input) {
            if ($input > $max_range) {
                return $this->maxRange($max_range, $keyword);
            }

            if ($input < $min_range) {
                return $this->minRange($min_range, $keyword);
            }
        }

        // If nothing catches above, the input is valid
        return true;
    }

    /**
     * Validates email input
     *
     * @param string|null $input
     * @param int $max_length
     * @param string $keyword
     * @param bool $strict
     * @return bool|string
     */
    public function email(int $max_length, string $keyword, string $input = null, $strict = false)
    {
        // input and strict cannot be empty
        if ($strict && !$input) {
            return $this->error(__($this->validation_empty_value, ['name' => $keyword]));
        }

        // Validate email
        // This should run if strict is true or false
        // If input exists, test it
        if ($input) {
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                return $this->error($keyword . ' input is not a valid email.');
            }

            if (strlen($input) > $max_length) {
                return $this->error($keyword . ' input is longer than ' . $max_length . '.');
            }
        }

        return true;
    }

    /**
     * Validate the telephone number against 4 formats.
     *
     * @param string $input
     * @return bool|string
     */
    public function telephoneNumber(string $input)
    {
        if ($input) {
            if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $input)) {
                return true;
            }

            if (!preg_match("/^[0-9]{10}$/", $input)) {
                return true;
            }

            if (!preg_match("/^[0-9]{11}$/", $input)) {
                return true;
            }

            if (!preg_match("/^[0-9]{3}.[0-9]{3}.[0-9]{4}$/", $input)) {
                return true;
            }

            return $this->error('Number is not in a valid format, 
                accepted formats; 000-000-0000, 000000000, 000.000.0000 and 1000000000.');
        }

        return true;
    }

    /**
     * @param string|null $input
     * @param int $max_length
     * @param $keyword
     * @param bool $strict
     * @return bool|string
     */
    public function long(int $max_length, $keyword, string $input = null, $strict = false)
    {
        if ($strict && !$input) {
            return $this->error(__($this->validation_empty_value, ['name' => $keyword]));
        }

        if ($input && (strlen($input) > $max_length)) {
            return $this->error(__('validation.custom.form.max_length', [
                'name' => $keyword,
                'max_length' => $max_length
            ]));
        }

        return true;
    }

    /**
     * @param $input
     * @param bool $strict
     * @param string $keyword
     * @return string
     */
    public function zipCode($input, $strict = false, string $keyword = 'zip code')
    {
        if ($strict && !$input) {
            return $this->error(__($this->validation_empty_value, ['name' => $keyword]));
        }

        if ($input) {
            $format = str_replace($input, '-', '');

            if ($format <= 11 && (int)$format) {
                return true;
            }
        }

        return true;
    }

    /**
     * @param array $form
     * @return \Illuminate\Validation\Validator
     */
    public function user(array $form)
    {
        return Validator::make($form,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|min:5|max:255|unique:multi.users',
                'password' => 'required|min:6|max:20',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'email.unique' => 'Email is already registered',
                'email.max' => 'Email maximum length is 255 characters',
                'email.min' => 'Email needs to have at least 5 characters',
                'password.required' => 'Password is required',
                'password.min' => 'Password needs to have at least 6 characters',
                'password.max' => 'Password maximum length is 20 characters',
            ]
        );
    }

    /**
     * @param array $form
     * @return \Illuminate\Validation\Validator
     */
    public function subscribe(array $form)
    {
        return Validator::make($form,
            [
                'email' => 'required|email|min:5|max:255',
                'city-town' => $this->max_string,
                'state-province-region' => $this->max_string,
                'country' => 'min:3|max:3|alpha',
                'company-name' => $this->max_string,
                'industry' => $this->max_string,
                'website' => $this->max_string,
            ]
        );
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $form
     * @return \Illuminate\Validation\Validator
     */
    public function company(array $form)
    {
        return Validator::make($form,
            [
                'company_name' => 'required|max:255',
                'country' => 'string',
                'address' => 'max:255'
            ],
            [
                'comany_name.required' => 'Company name is required',
                'address.required' => 'Address is required',
            ]
        );
    }
}
