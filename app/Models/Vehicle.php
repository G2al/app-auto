<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_model',
        'license_plate',
        'chassis',
        'registration_year',
        'km',
        'color',
        'fuel_type',
        'second_key',
        'origin',
        'vat_exposed',
        'purchase_date',
        'registry_number',
        'archive_number',
        'purchase_price',
        'broker',
        'transport',
        'mechatronics',
        'bodywork',
        'tire_shop',
        'upholstery',
        'travel',
        'inspection',
        'miscellaneous',
        'spare_parts',
        'washing',
        'passaggio',        
        'accessori',
        'levabolle', // ✅ AGGIUNTO
        'total_cost',
        'customer_name',
        'customer_surname',
        'payment_method',
        'phone_number',
        'payment_details',
        'status',
        'sale_price',
        'archive_date',
    ];

    protected $casts = [
        'second_key' => 'boolean',
        'vat_exposed' => 'boolean',
        'purchase_date' => 'date',
        'archive_date' => 'date',
        'payment_details' => 'array',
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($vehicle) {
            $vehicle->total_cost = $vehicle->calculateTotalCost();

            // Autocompila la data di archiviazione quando lo stato è "archiviato" e manca il valore
            if ($vehicle->status === 'archiviato' && empty($vehicle->archive_date)) {
                $vehicle->archive_date = now();
            }
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function calculateTotalCost(): float
    {
        return collect([
            $this->purchase_price ?? 0, 
            $this->broker ?? 0, 
            $this->transport ?? 0,
            $this->mechatronics ?? 0, 
            $this->bodywork ?? 0, 
            $this->tire_shop ?? 0,
            $this->upholstery ?? 0, 
            $this->travel ?? 0, 
            $this->inspection ?? 0,
            $this->miscellaneous ?? 0, 
            $this->spare_parts ?? 0, 
            $this->washing ?? 0,
            $this->passaggio ?? 0,      
            $this->accessori ?? 0,
            $this->levabolle ?? 0, // ✅ AGGIUNTO
        ])->sum();
    }
}
