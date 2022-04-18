<?php

namespace Modules\FormPub\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormPub extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'form_pub';
    protected static function newFactory()
    {
        return \Modules\FormPub\Database\factories\FormPubFactory::new();
    }
}
