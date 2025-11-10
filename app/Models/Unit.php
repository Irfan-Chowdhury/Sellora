<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory; // Add this line

    protected $fillable = [
        'name',
        'code',
        'base_unit',
        'operator',
        'operation_value',
        'is_active',
    ];

    protected $casts = [
        'operation_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function baseUnit()
    {
        return $this->belongsTo(self::class,'base_unit');
    }
}
