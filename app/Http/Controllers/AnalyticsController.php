<?php
declare(strict_types=1);

/**
 * Analytics File
 *
 * Namespace App\Http\Controllers
 */

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Sales;

/* Database modals */

/**
 * Extends Controller
 * Uses Request, Auth, Carbon, Requests, App, and Sales
 *
 * Class Analytics
 * @package App\Http\Controllers
 */
class AnalyticsController extends Controller
{

    /**
     * @var $start_date
     * @var $end_date
     * @var_$date_range
     * @var int $number_of_months
     * @var $data_points
     */
    public $startDate;
    public $endDate;
    public $dateRange;
    public $numberOfMonths = 2;
    public $dataPoints;

    // String Constants
    public $created_at = 'created_at';

    /**
     * Construct Method
     *
     * Has Middleware that gets the Domain
     *
     * Analytics constructor.
     */
    public function __construct()
    {
        $this->middleware('domain');
    }

    /**
     * Main Method - Show
     *
     * @return \Illuminate\Contracts\View\Factory|
     * \Illuminate\View\View
     */
    public function show()
    {
        $create_sales = Sales::select($this->created_at)
            ->where($this->created_at, '<', Carbon::now())
            ->where($this->created_at, '>', Carbon::now()->subMonths($this->numberOfMonths))
            ->orderBy($this->created_at, 'DESC')
            ->get();

        $counter = 0;
        $purchased = [];
        $length = count($create_sales);

        foreach ($create_sales as $single_sale) {
            if ($length > 1) {
                if ($counter == 0) {
                    $this->startDate = $single_sale->created_at;

                } elseif ($counter == $length - 1) {
                    $this->endDate = $single_sale->created_at;
                } else {
                    $this->startDate = $single_sale->created_at;
                }

            } elseif ($length === 1) {
                $this->startDate = $single_sale->created_at->addWeeks(2);
                $this->endDate = $single_sale->created_at->subWeeks(2);
            }

            $purchased[] = $single_sale->created_at;
            $counter++;
        }

        $this->createDateRange();
        $this->createPointRange();

        /*
         * sort sales into the correct day range and +1 else it is 0, no sales that day
         */
        $data_points = [];
        foreach ($create_sales as $single_sale) {
            $pre_format = $single_sale->created_at;
            $post_format = $pre_format->format('m-d-y');

            if (isset($data_points[$post_format])) {
                //$data_points[$post_format] + 1;
            } else {
                $data_points[$post_format] = 1;
            }
        }

        $blade_data = '[' . implode(',', $data_points) . ']';
        $string = '["' . implode('","', $this->dateRange) . '"]';

        return view('analytics.index', [
            'date_range' => $string,
            'data_points' => $blade_data,
            'menu_type' => 'vmi'
        ]);
    }

    /**
     * Private Method - generateDateRange
     *
     * Uses the @properties start_date, end_date, and date_range to determine the range of days
     *
     * @return array
     */
    private function createDateRange()
    {
        $dates = [];

        for ($create_date = $this->endDate; $create_date->lte($this->startDate); $create_date->addDay()) {
            $dates[] = $create_date->format('m-d');
        }

        return $this->dateRange = $dates;
    }

    /**
     * Private Method = generateDataPointRange
     *
     * Uses the @properties start_date, end_date, and data_points to determine
     *
     * @return array
     */
    private function createPointRange()
    {
        $data_points = [];

        for ($create_data = $this->endDate; $create_data->lte($this->startDate); $create_data - addDay()) {
            var_dump($create_data->format('m-d-y'));

            $data_points[] = 0;
        }

        return $this->dataPoints = $data_points;
    }
}
