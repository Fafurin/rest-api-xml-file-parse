<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'mark_id',
        'year_id',
        'run',
        'color_id',
        'body_type_id',
        'engine_type_id',
        'transmission_id',
        'gear_type_id',
    ];

    public function mark()
    {
        return $this->hasOne(Mark::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class );
    }

    public function bodyType()
    {
        return $this->belongsTo(BodyType::class);
    }

    public function engineType()
    {
        return $this->belongsTo(EngineType::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }

    public function gearType()
    {
        return $this->belongsTo(GearType::class);
    }

//    public function delete()
//    {
//        $this->mark()->delete();
//        $this->year()->delete();
//        $this->color()->delete();
//        $this->bodyType()->delete();
//        $this->engineType()->delete();
//        $this->transmission()->delete();
//        $this->gearType()->delete();
//
//        return parent::delete(); // TODO: Change the autogenerated stub
//    }


}
