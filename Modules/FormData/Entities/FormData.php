<?php

namespace Modules\FormData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormData extends Model
{
    use HasFactory;
    protected $table = 'form_data';
    protected $fillable = [
        'email',
        'tags',
        'country',
        'age',
        'traffic_network',
        'exp',
        'scale',
        'price'

    ];

    protected static function newFactory()
    {
        return \Modules\FormData\Database\factories\FormDataFactory::new();
    }
}

// "tags" : "health",
// "country" : "thailand",
// "age" : "28",
// "traffic_network" : "facebook",
// "exp" : "2",
// "scale" : "all",
// "price" : "28"