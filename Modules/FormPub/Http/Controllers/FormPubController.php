<?php

namespace Modules\FormPub\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FormPub\Entities\FormPub;

class FormPubController extends Controller
{
    function index(){
        return FormPub::all();
    }
}
