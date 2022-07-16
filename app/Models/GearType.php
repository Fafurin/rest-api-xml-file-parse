<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GearType extends Model
{
    use HasFactory;

    protected $table = 'gear_types';

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    public function car()
    {
        return $this->hasOne(Car::class);
    }
}
