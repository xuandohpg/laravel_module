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
        return response()->json(Offer::create($request->all()), 201);
    }

    function demo(Request $request)
    {
        return "ok";
    }

    function index(Request $request)
    {
        $traffic=$request->traffic;
        $exp=$request->exp;
        $age=$request->age;
        $tags=$request->tags;
        $country=$request->country;
        $quantity=$request->quantity;
        $payout=$request->payout;
        $type=$request->type;


        $ar=$request->ar;
        $cr=$request->cr;
        $epc=$request->epc;
        $classfy=$request->classfy;


        if(empty($classfy)){
            $classfy=0;
        }
        if(empty($cr)){
            $cr=0;
        }
        if(empty($epc)){
            $epc=0;
        }
        if(empty($ar)){
            $ar=0;
        }

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
                ['type',"=","{$type}"],
                ['payout','>=',"$payout"],
                ['approved_rate',">=","$ar"],
                ['conversion_rate',">=","$cr"],
                ['epc',">=","$epc"],
                ['classfy',"=","$classfy"],
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




        if (count($offer_check) <= 3) {
            $result = $offer_check;
        } else {
            $offer_priority = [];
            $offer_no_priority = [];
            foreach ($offer_check as $item) {
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

}
