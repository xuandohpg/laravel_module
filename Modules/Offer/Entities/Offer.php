<?php

namespace Modules\Offer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers1';
    protected $fillable = [
        'name',
        'tags',
        'country',
        'approved_rate',
        'age',
        'price',
        'conversion_rate',
        'traffic_network',
        'link_landing',
        'exp',
        'payout',
        'priority',
        'image',
        'link_dinos',
        'scale'
    ];

    protected static function newFactory()
    {
        return \Modules\Offer\Database\factories\OfferFactory::new();
    }
}
