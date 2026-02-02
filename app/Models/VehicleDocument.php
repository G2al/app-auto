<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'category',
        'filename',
        'original_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'is_auto_generated',
        'description',
    ];

    protected $casts = [
        'is_auto_generated' => 'boolean',
        'file_size' => 'integer',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public const CATEGORIES = [
        'libretto' => 'Libretto di Circolazione',
        'riparazione' => 'Documenti di Riparazione',
        'atto_vendita' => 'Atto di Vendita',
        'contratto' => 'Contratto Stipulato'
    ];

    public const CATEGORY_LIMITS = [
        'libretto' => 4,
        'riparazione' => 10,
        'atto_vendita' => 3,
        'contratto' => 1
    ];
}