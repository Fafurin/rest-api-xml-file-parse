<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected $table = 'transmissions';

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    public function car()
    {
        return $this->hasOne(Car::class);
    }
}
