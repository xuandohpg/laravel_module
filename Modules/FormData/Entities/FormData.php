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
        'traffic',
        'age',
        'tags',
        'country',
        'type',
        'quantity',
        'payout',
        'ar',
        'cr',
        'epc',
        'classfy',
        "exp",
    ];

    protected static function newFactory()
    {
        return \Modules\FormData\Database\factories\FormDataFactory::new();
    }
}

