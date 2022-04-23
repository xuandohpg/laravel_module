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

        if(count($offer_check)>=1 && count($offer_check)<=3){
            echo "nho hon 3";
            $result=$offer_check;
        }
        else if(count($offer_check)>3){
            echo "So luong=".count($offer_check);
            $offer_priority = [];
            $offer_no_priority = [];
            foreach ($offer_check as $item) {
                if ($item['priority'] != 10) {
                    $offer_priority[] = $item;
                } else {
                    $offer_no_priority[] = $item;
                }

            }

            if(count($offer_priority)>=1 && count($offer_priority)<=3){
                echo "lon hon 1 va nho hon 3";
                $result=$offer_priority;
            }

            else if(count($offer_priority)>3){
                echo "-lon hon 3-";
                $offer_priority_min_first=[];
                $offer_priority_max_first=[];
                $min=$offer_priority[0]['priority'];

                foreach ($offer_priority as $item) {
                    if ($item['priority'] == $min) {
                        $offer_priority_min_first[] = $item;
                    } else {
                        $offer_priority_max_first[] = $item;
                    }
                }
echo $min."lan mot xuat hien - ".count($offer_priority_min_first)."----";

                if(count($offer_priority_min_first)==1){
                    echo "offer_priority_min_first=1";
                    $result=$offer_priority_min_first;
                    $offer_priority_min_second=[];
                    $offer_priority_max_second=[];
                    $min=$offer_priority_max_first[0]['priority'];

                    foreach ($offer_priority_max_first as $item) {
                        if ($item['priority'] == $min) {
                            $offer_priority_min_second[] = $item;
                        } else {
                            $offer_priority_max_second[] = $item;
                        }
                    }
                    if(count($offer_priority_min_second)==1){
                        echo "chi co mot";
                        $result = array_merge($result, $offer_priority_min_second);
                        $offer_priority_min_third=[];


                        $min=$offer_priority_max_second[0]['priority'];
                        foreach ($offer_priority_max_second as $item) {
                            if ($item['priority'] == $min) {
                                $offer_priority_min_third[] = $item;
                            }
                        }

                        if(count($offer_priority_min_third)==1){
                            $result = array_merge($result, $offer_priority_min_third);
                        }
                        else{
                            for($i=0;$i<count($offer_priority_min_third)-1;$i++){
                                for($j=1;$j<count($offer_priority_min_third);$j++){
                                    if($offer_priority_min_third[$j]['payout']>$offer_priority_min_third[$i]['payout']){
                                        $tamp=$offer_priority_min_third[$i];
                                        $offer_priority_min_third[$i]=$offer_priority_min_third[$j];
                                        $offer_priority_min_third[$j]=$tamp;
                                    }
                                }
                            }

                            $array_payout_max=[];
                            $payout_max=$offer_priority_min_third[0]['payout'];
                            foreach ($offer_priority_min_third as $item){
                                if($item['payout']==$payout_max){
                                    $array_payout_max[]=$item;
                                }
                            }
                             if(count($array_payout_max)>=2){


                                    $array = collect($array_payout_max)->sortBy('conversion_rate')->reverse()->toArray();
                                    $array = array_slice($array, 0, 1);
                                    $result = array_merge($result, $array);
                            }
                             else{
                                 $result = array_merge($result, $array_payout_max);
                             }

//                            $offer_priority_min_third = collect($offer_priority_min_third)->sortBy('payout')->reverse()->toArray();
//                            $result=[];
//                            $result=$array_payout_max;
                        }

                    }
                    else if(count($offer_priority_min_second)==2){
                        echo "chi co hai";
                        $result = array_merge($result, $offer_priority_min_second);
                    }
                    else{
                        for($i=0;$i<count($offer_priority_min_second)-1;$i++){
                            for($j=1;$j<count($offer_priority_min_second);$j++){
                                if($offer_priority_min_second[$j]['payout']>$offer_priority_min_second[$i]['payout']){
                                    $tamp=$offer_priority_min_second[$i];
                                    $offer_priority_min_second[$i]=$offer_priority_min_second[$j];
                                    $offer_priority_min_second[$j]=$tamp;
                                }
                            }
                        }
                        $array_payout_max=[];
                        $payout_max=$offer_priority_min_second[0]['payout'];
                        foreach ($offer_priority_min_second as $item){
                            if($item['payout']==$payout_max){
                                $array_payout_max[]=$item;
                            }
                        }

                        if(count($array_payout_max)==1){
                            $result = array_merge($result, $array_payout_max);
                            $array_payout_max=[];
                            $payout_max=$offer_priority_min_second[1]['payout'];
                            foreach ($offer_priority_min_second as $item){
                                if($item['payout']==$payout_max){
                                    $array_payout_max[]=$item;
                                }
                            }
                            if(count($array_payout_max)==1){
                                $result = array_merge($result, $array_payout_max);
                            }
                            else{
                                $array = collect($array_payout_max)->sortBy('conversion_rate')->reverse()->toArray();
                                $array = array_slice($array, 0, 1);
                                $result = array_merge($result, $array);
                            }

                        }
                        else{
                            $array = collect($array_payout_max)->sortBy('conversion_rate')->reverse()->toArray();
                            $array = array_slice($array, 0, 2);
                            $result = array_merge($result, $array);
                        }







                    }
                }
                else if(count($offer_priority_min_first)==2){

                }
                else if(count($offer_priority_min_first)==3){
                    echo "offer_priority_min_first=3";
                    $result = array_merge($result, $offer_priority_min_first);
                }
                else{
                    echo "offer_priority_min_firs>>>>>>>>>>>>>>>>>>>>3";
                    for($i=0;$i<count($offer_priority_min_first)-1;$i++){
                        for($j=1;$j<count($offer_priority_min_first);$j++){
                            if($offer_priority_min_first[$j]['payout']>$offer_priority_min_first[$i]['payout']){
                                $tamp=$offer_priority_min_first[$i];
                                $offer_priority_min_first[$i]=$offer_priority_min_first[$j];
                                $offer_priority_min_first[$j]=$tamp;
                            }
                        }
                    }

                    $result=[];
                    $result=$offer_priority_min_first;
                    $array_payout_max=[];
                    $payout_max=$offer_priority_min_first[0]['payout'];
                    foreach ($offer_priority_min_first as $item){
                        if($item['payout']==$payout_max){
                            $array_payout_max[]=$item;
                        }
                    }

                    $result=[];
                    $result=$offer_priority_min_first;
                }


            }
//            return $offer_priority;

//            print_r($offer_priority);
//            echo "--------------------------------------------------------------------------------------------------";
//            print_r($offer_no_priority);
        }
//                return $result;

//        return $offer_check;
//        return $offer_check;
//        return  response()->json($result);
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

//        return $offer_check;
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
