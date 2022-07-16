<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $table = 'generations';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'generation_id'
    ];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

}
