<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Laravel Classes
 */
use App\PCBOrders;
use App\Subscriptions;
use Auth;

/**
 * Modal classes
 */

/**
 * Class QueryBuilder
 * @package App\Classes
 */
class QueryBuilder
{
    // String Constants
    public $length = 'length';
    public $width = 'width';
    public $quantity = 'quantity';
    public $layers = 'layers';
    public $thickness = 'thickness';
    public $string_user_id = 'user_id';
    public $completed = 'completed';
    public $email = 'email';
    public $country = 'country';
    public $pcb_emails = 'pcb_emails';

    /**
     * Query steps as the user moves through the purchase.
     *
     * @param string $set
     * @param \stdClass $create_data
     */
    public function inject(string $set, \stdClass $create_data)
    {

        try {
            $create_data->form[$this->length];
        } catch (\Exception $exception) {
            $create_data->form[$this->length] = null;
            $create_data->form[$this->width] = null;
            $create_data->form[$this->quantity] = null;
            $create_data->form[$this->layers] = null;
            $create_data->form[$this->thickness] = null;
        }

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }

//        No longer need Device-type data or Timestamps
        switch ($set) {
            case 'insert':
                PCBOrders::insert([
                    'ip' => $create_data->ip,
                    $this->string_user_id => $user_id,
                    $this->length => $create_data->form[$this->length],
                    $this->width => $create_data->form[$this->width],
                    $this->quantity => $create_data->form[$this->quantity],
                    $this->layers => $create_data->form[$this->layers],
                    $this->thickness => $create_data->form[$this->thickness],
                    'instant_quote' => $this->completed,
                ]);
                break;
            case 'update':
                PCBOrders::where('ip', $create_data->ip)
                    ->orderBy('id', 'desc')
                    ->take(1)
                    ->update([
                        $this->length => $create_data->form[$this->length],
                        $this->width => $create_data->form[$this->width],
                        $this->quantity => $create_data->form[$this->quantity],
                        $this->layers => $create_data->form[$this->layers],
                        $this->thickness => $create_data->form[$this->thickness],
                        'different_designs' => $create_data->form['different-designs'],
                        'silkscreen' => $create_data->form['silkscreen'],
                        'material' => $create_data->form['material'],
                        'fr4_tg' => $create_data->form['fr4-tg'],
                        'soldermask' => $create_data->form['soldermask'],
                        'min_track_space' => $create_data->form['min-track'],
                        'min_hole_size' => $create_data->form['min-hole-size'],
                        'gold_fingers' => $create_data->form['gold-fingers'],
                        'surface_finish' => $create_data->form['surface-finish'],
                        'via_process' => $create_data->form['via-process'],
                        'base_copper_oz' => $create_data->form['base-copper-oz'],
                        'finished_copper' => $create_data->form['finished-copper'],
                        'full_quote' => $this->completed
                    ]);
                break;
            case 'update_simple':
                // For when a user RETURNS to the form, double check/update all setup info
                PCBOrders::where('ip', $create_data->ip)
                    ->orderBy('id', 'desc')
                    ->take(1)
                    ->update([
                        $this->string_user_id => $user_id,
                        $this->length => $create_data->form[$this->length],
                        $this->width => $create_data->form[$this->width],
                        $this->quantity => $create_data->form[$this->quantity],
                        $this->layers => $create_data->form[$this->layers],
                        $this->thickness => $create_data->form[$this->thickness],
                    ]);
                break;
            case 'quote':
                PCBOrders::where('ip', $create_data->ip)
                    ->orderBy('id', 'desc')
                    ->take(1)
                    ->update([
                        'price' => $create_data->form['price'],
                        'lead' => $create_data->form['lead'],
                        'email_address' => $create_data->form[$this->email],
                        'notes' => $create_data->form['notes'],
                        'add_cart' => $this->completed
                    ]);
                break;
            case 'subscribe':
                PCBOrders::where('ip', $create_data->ip)
                    ->orderBy('id', 'desc')
                    ->take(1)
                    ->update([
                        'city_town' => $create_data->form['city-town'],
                        'state_province_region' => $create_data->form['state-province-region'],
                        'zip_postal_code' => $create_data->form['zip-postal-code'],
                        $this->country => $create_data->form[$this->country],
                        'subscription' => $this->completed
                    ]);
                break;
            case 'subscribe_simple':
                PCBOrders::insert([
                    'ip' => $create_data->ip,
                    $this->string_user_id => $user_id,
                    'email_address' => $create_data->form[$this->email],
                    'city_town' => $create_data->form['city-town'],
                    'state_province_region' => $create_data->form['state-province-region'],
                    'zip_postal_code' => $create_data->form['zip-postal-code'],
                    $this->country => $create_data->form[$this->country],
                    'subscription' => $this->completed
                ]);
                break;
            default:
                break;
        }
    }

    /**
     * Query to subscribe a User to begin receiving emails
     *
     * @param string $email
     */
    public function resubscribePCB(string $email)
    {
        Subscriptions::where($this->email, $email)
            ->first()
            ->update([$this->pcb_emails => 'Yes']);
    }

    /**
     * Query to subscribe a non-User to begin receiving emails
     *
     * @param string $email
     */
    public function subscribePCB(string $email)
    {
        Subscriptions::insert([
            $this->email => $email,
            $this->pcb_emails => 'Yes'
        ]);
    }

    /**
     * Query to unsubscribe a User from receiving emails
     *
     * @param string $email
     */
    public function unsubscribePCB(string $email)
    {
        Subscriptions::where($this->email, $email)
            ->first()
            ->update([$this->pcb_emails => 'No']);
    }
}
