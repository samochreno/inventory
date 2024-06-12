<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'serialnumber',
        'car_id',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
