<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class formPub extends Model
{
    use HasFactory;

    protected $table = 'form_pub';
    protected $fillable = [
            'name','type_data','name_data','value_data'
    ];

    protected static function newFactory()
    {
        return \Modules\Offer\Database\factories\FormPubFactory::new();
    }
}
