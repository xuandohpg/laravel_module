<?php

namespace Modules\FormData\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\FormData\Entities\FormData;

class FormDataController extends Controller
{
    function add(Request $request){

        // return FormData::create([
        //     'name' => $request->input('name'),
        //     'tags' => $request->input('tags'),
        //     'country' => $request->input('country'),
        //     'approved_rate' => $request->input('approvedRate'),
        //     'age_of_use' => $request->input('age'),
        //     'price' => $request->input('price'),
        //     'conversion_rate' => $request->input('conversionRate'),
        //     'social_network' => $request->input('socialNetwork'),
        //     'link_landing' => $request->input('linkLanding'),
        //     'exp' => $request->input('exp'),
        //     'payout' => $request->input('payout'),
        //     'priority' => $request->input('priority'),
        //     'image'=>$request->input('linkImage'),
        //     'link_dinos'=>$request->input('linkDinos'),
        // ]);

        // dd($request);
        return response()->json(FormData::create($request->all()), 201);

    }


    function update(Request $request,$id){
        $formdata = FormData::findOrFail($id);
        $formdata->update($request->all());
        return response()->json($formdata, 200);
    }
    // http://localhost:8000/api/formdata/update?email=dinhhoang@gmail.com&email_new=dinhhoang123@gmail.com&tags=health&country=vietnam&age=30&social_network=google&exp=1


    function index(){
        return response()->json(FormData::all());
    }

    function show($id){
        return  response()->json(FormData::find($id));
    }
}
