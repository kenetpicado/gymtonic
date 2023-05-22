<?php

namespace App\Services;

use App\Models\Price;
use Illuminate\Validation\ValidationException;

class PriceService
{
    public function findPrice($service_id, $period)
    {
        $price = Price::where('service_id', $service_id)
            ->where('period', $period)
            ->value('value');

        if (!$price) {
            $this->notFound();
        }

        return $price;
    }

    public function notFound()
    {
        session()->flash('flash.banner', 'No hay precio para el periodo seleccionado');

        throw ValidationException::withMessages([
            'period' => 'No hay precio para el periodo seleccionado',
        ]);
    }
}
