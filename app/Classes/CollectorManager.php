<?php
declare(strict_types=1);

namespace App\Classes;

use App\Coils;
use App\Collectors;
use App\Events as Events;
use App\Sales;

class CollectorManager
{
    public function logEvent($data)
    {
        $collector = Collectors::where('pi_id', $data['ID'])->first();

        //create a new collector entry if one wasn't found
        if (!$collector) {
            $collector = new Collectors();
            $collector->pi_id = $data['ID'];
            $collector->save();
        }

        $event = new Events();

        $event->collector_id = $collector->id;
        $event->type_id = $data['E'];

        if (isset($data['T'])) {
            $event->timestamp = $data['T'];
        }
        if (isset($data['P'])) {
            $event->product_id = $data['P'];
        }

        $event->save();

        //dollar event
        if ($event->type() == 'dollar') {
            $collector->bills += 1;
            $collector->update();
        }
        if ($event->type() == 'product') {
            $this->logSale($event, $collector->machine);
        }

        return 'Good';

    }

    private function logSale($product_event, $machine)
    {
        $coil = Coils::where('machine_id', $machine->id)
            ->where('coil_number', $product_event->product_id)
            ->first();

        if ($coil) {
            $sale = new Sales();
            $sale->coil_id = $coil->id;
            $sale->save();
        }
    }
}
