<?php

namespace Modules\FormData\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\FormData\Entities\FormData;

class FormDataController extends Controller
{
    function add(Request $request){
        // dd($request);
        return response()->json(FormData::create($request->all()), 201);

    }


    function update(Request $request,$id){
        $formdata = FormData::findOrFail($id);
        $formdata->update($request->all());
        return response()->json($formdata, 200);
    }



    function index(){
        return response()->json(FormData::all());
    }

    function show($id){
        return  response()->json(FormData::find($id));
    }
}
