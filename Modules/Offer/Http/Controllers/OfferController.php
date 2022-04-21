<?php

namespace Modules\Offer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Offer\Entities\Offer;

use Modules\Offer\Entities\FormPub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferController extends Controller
{



    function add(Request $request)
    {
        return Offer::create([
            'name' => $request->input('name'),
            'tags' => $request->input('tags'),
            'country' => $request->input('country'),
            'approved_rate' => $request->input('approvedRate'),
            'age_of_use' => $request->input('age'),
            'price' => $request->input('price'),
            'conversion_rate' => $request->input('conversionRate'),
            'social_network' => $request->input('socialNetwork'),
            'link_landing' => $request->input('linkLanding'),
            'exp' => $request->input('exp'),
            'payout' => $request->input('payout'),
            'priority' => $request->input('priority'),
            'image'=>$request->input('linkImage'),
            'link_dinos'=>$request->input('linkDinos'),
        ]);
    }

    function demo(Request $request)
    {
        $traffic=$request->traffic;
        $exp=$request->exp;
        $age=$request->age;
        $tags=$request->tags;
        $country=$request->country;
        $quantity=$request->quantity;
        $payout=$request->payout;
        $type=$request->type;

        if($exp=='1'){
            $exp='newbie';
        }
        else if($exp=='2'){
            $exp='experience';
        }
        else if($exp=='3'){
            $exp='expert';
        }

        if($type==1){
            $type="cpa";
        }
        else if($type==2){
            $type="cpl";
        }else if($type==3){
            $type="cps";
        }
        $offer=Offer::whereIn("traffic_network",$traffic)
            ->whereIn("tags",$tags)
            ->whereIn("country",$country)
            ->where([
                ['exp',"=","{$exp}"],
                ['type',"=","{$type}"]
            ])
            ->orderBy('priority', 'asc')
            ->get();

        $offer_check=[];
        $result=[];
        $countAge=count($age);
        if($countAge==1){
            foreach ($offer as $item){
                if($item['age']>=20 && $item['age']<=35 && in_array(1,$age)){
                    $offer_check[]=$item;
                }
                else if($item['age']>=35 && $item['age']<=45 && in_array(2,$age)){
                    $offer_check[]=$item;
                }
                else if($item['age']>=45 && $item['age']<=100 && in_array(3,$age)){
                    $offer_check[]=$item;
                }
            }
        }
        else if($countAge==2){
            foreach ($offer as $item){
                if(in_array(1,$age) && in_array(2,$age) && $item['age']>=20 && $item['age']<=45){
                    $offer_check[]=$item;
                }
                else if(in_array(1,$age) && in_array(3,$age)){
                    if($item['age']>=20 && $item['age']<=35 || $item['age']>=45 && $item['age']<=100){
                        $offer_check[]=$item;
                    }
                }
                else if(in_array(2,$age) && in_array(3,$age) && $item['age']>=45 && $item['age']<=100){
                    $offer_check[]=$item;
                }
            }
        }
        else{
            $offer_check=$offer;
        }
        
        if(count($offer_check)>=1 && count($offer_check)<=3){
            $result=$offer_check;
        }
        else if(count($offer_check)>3){
            $offer_priority = [];
            $offer_no_priority = [];
            foreach ($offer as $item) {
                if ($item['priority'] != 10) {
                    $offer_priority[] = $item;
                } else {
                    $offer_no_priority[] = $item;
                }
            }
            if(count($offer_priority)>=1 && count($offer_priority)>=3){

            }

            print_r($offer_priority);
            echo "--------------------------------------------------------------------------------------------------";
            print_r($offer_no_priority);
        }
    

       



        // return $offer_check;

//        return  response()->json($result);

    }

    function index(Request $request)
    {
//        $request->exp = "0";
//        $request->tags = "";
//        $request = array(
//            "exp" => "0",
//            "tags" => "hea",
//            "country" => null,
//            "age" => null,
//            "social_network" => null
//        );
        $formPub = FormPub::all();
        foreach ($formPub as $item){
            if($item['type_data']=='select'){
                $value_data=$item['value_data'];
                $item['value_data']=explode(',',$value_data);
            }
        }
        $offer = [];
        $tags = $request->input('tags');
        $country = $request->input('country');
        $age = $request->input('age');
        $traffic_network = $request->input('traffic_network');
        $exp = $request->input('exp');
        $scale=$request->input('scale');
        $price=$request->input('price');
        if($price<=10){
            $price_start = 0;
            $price_end = 10;
        }
        else if($price<=20){
            $price_start = 10;
            $price_end = 20;
        }

        else if($price<=30){
            $price_start = 20;
            $price_end = 30;
        }
        else if($price<=40){
            $price_start = 30;
            $price_end = 40;
        }
        else if($price<=50){
            $price_start = 40;
            $price_end = 50;
        }
        else if($price<=60){
            $price_start = 50;
            $price_end = 60;
        }

        else if($price<=70){
            $price_start = 60;
            $price_end = 70;
        }
        else if($price<=80){
            $price_start = 70;
            $price_end = 80;
        }
        else if($price<=90){
            $price_start = 80;
            $price_end = 90;
        }
        else if($price<=100){
            $price_start = 90;
            $price_end = 100;
        }
        else if($price<=110){
            $price_start = 100;
            $price_end = 110;
        }
        else if($price<=120){
            $price_start = 110;
            $price_end = 120;
        }
        else if($price<=130){
            $price_start = 120;
            $price_end = 130;
        }
        else if($price<=140){
            $price_start = 130;
            $price_end = 140;
        }
//        if(!empty($tags) && !empty($country) && !empty($age) && !empty($budget) && !empty($social_network) && !empty($exp) &&!empty($payout)){
        if ($age <= 30) {
            $age_start = 20;
            $age_end = 30;

        } else if ($age <= 40) {
            $age_start = 30;
            $age_end = 40;

        } else if ($age <= 50) {
            $age_start = 40;
            $age_end = 50;
        } else if ($age <= 60) {
            $age_start = 50;
            $age_end = 60;
        } else if ($age <= 70) {
            $age_start = 60;
            $age_end = 70;
        } else {
            $age_start = 1;
            $age_end = 100;
        }

        if (empty($exp)) {
            $exp = '';
        }




            $offer = Offer::where([
                ["country", "LIKE", "%{$country}%"],
                ["traffic_network", "LIKE", "%{$traffic_network}%"],
                ["tags", "=", "{$tags}"],
                ["exp", "LIKE", "%{$exp}%"],
            ])->whereBetween('age', [$age_start, $age_end])->whereBetween('price',[$price_start,$price_end])->where('scale',"{$scale}")->orderBy('priority', 'asc')->get();


        if (count($offer) <= 3) {
            $result = $offer;
        } else {
            $offer_priority = [];
            $offer_no_priority = [];
            foreach ($offer as $item) {
                if ($item['priority'] != 10) {
                    $offer_priority[] = $item;
                } else {
                    $offer_no_priority[] = $item;
                }
            }
            if (count($offer_priority) > 0 && count($offer_priority) <= 3) {
                $result = $offer_priority;
                $lenght = 3 - count($offer_priority);
                $array = collect($offer_no_priority)->sortBy('payout')->reverse()->toArray();
                $array = array_slice($array, 0, $lenght);
                if (!empty($array)) {
                    foreach ($array as $item) {
                        $result[] = $item;
                    }
                }
            } else if (count($offer_priority) > 3) {
                $offer_priority_min = [];
                $offer_priority_max = [];
                $min = $offer_priority[0]['priority'];
                foreach ($offer_priority as $item) {
                    if ($item['priority'] == $min) {
                        $offer_priority_min[] = $item;
                    } else {
                        $offer_priority_max[] = $item;
                    }
                }

                $result = $offer_priority_min;
                $offer_priority_max1 = [];
                $offer_priority_max2 = [];
                $min = $offer_priority_max[0]['priority'];
                $count = 0;
                foreach ($offer_priority_max as $item) {
                    if ($item['priority'] == $min) {
                        $count++;
                        $offer_priority_max1[] = $item;
                    } else {
                        $offer_priority_max2[] = $item;
                    }
                }
                if (count($result) == 1) {
                    if (count($offer_priority_max1) == 1) {
                        $result = array_merge($result, $offer_priority_max1);
                        $provisional = [];
                        $min = $offer_priority_max2[0]['priority'];
                        foreach ($offer_priority_max2 as $item) {
                            if ($item['priority'] == $min) {
                                $provisional[] = $item;
                            }
                        }
                        $array = collect($provisional)->sortBy('payout')->reverse()->toArray();
                        $array = array_slice($array, 0, 1);
                        $result = array_merge($result, $array);
                    } else {
                        $array = collect($offer_priority_max1)->sortBy('payout')->reverse()->toArray();
                        $array = array_slice($array, 0, 2);
                        if (!empty($array)) {
                            foreach ($array as $item) {
                                $result[] = $item;
                            }
                        }
                    }
                } else if (count($result) == 2) {
                    $provisional = [];
                    $min = $offer_priority_max[0]['priority'];
                    foreach ($offer_priority_max as $item) {
                        if ($item['priority'] == $min) {
                            $provisional[] = $item;
                        }
                    }
                    $array = collect($provisional)->sortBy('payout')->reverse()->toArray();
                    $array = array_slice($array, 0, 1);
                    $result = array_merge($result, $array);
                } else if (count($result) >= 3) {
                    $array = collect($result)->sortBy('payout')->reverse()->toArray();
                    $result = array_slice($array, 0, 3);
                }
            } else {
                $array = collect($offer_no_priority)->sortBy('payout')->reverse()->toArray();
                $result = array_slice($array, 0, 3);
            }
        }

        return  response()->json($result);
    }
    public function create()
    {
        return view('offer::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('offer::show');
    }

    public function edit($id)
    {
        return view('offer::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
