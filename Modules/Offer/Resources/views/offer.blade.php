@extends('offer::layouts.master')

@section('content')
    <style>

        .image-product{
            width: 100px;
            height: auto;
        }
        select,input {
            width: 100%;
        }
        select,input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        select,input[type=text] {
            border: 2px solid red;
            border-radius: 4px;
        }
        select,input[type=text] {
            background-color: #3CBC8D;
            color: white;
        }
    </style>
    @if(!empty($formPubs))
    <form>
        @foreach($formPub as $item)
            <label>{{$item['name']}}</label>
            @if($item['type_data']=='input')
                <input type="text" name="{{$item['name_data']}}" value="">
            @elseif($item['type_data']=='select')
                <div class="custom-select">
                    <select name="{{$item['name_data']}}" class="dropdown-select">
                            <option value="0">--Chon--</option>
                        @php $i=1; @endphp
                    @foreach($item['value_data'] as $value)
                            <option value="{{$i++}}">{{$value}}</option>
                    @endforeach
                </select>
                </div>
            @endif
        @endforeach
            <input style="padding: 5px 30px" type="submit" name="btn-search" value="Submit">
    </form>
    @endif
    <table border="1">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Tags</th>
            <th>Country</th>
            <th>AR</th>
            <th>Age</th>
            <th>Budget</th>
            <th>Social Network</th>
            <th>Exp</th>
            <th>Payout</th>
        </tr>
        @foreach($offer as $item)
            <tr>
                <td><img class="image-product" src="{{$item['image']}}"> </td>
                <th>{{$item['name']}}</th>
                <td>{{$item['tags']}}</td>
                <td>{{$item['country']}}</td>
                <td>{{$item['ar']}}</td>
                <td>{{$item['age_of_use']}}</td>
                <td>{{$item['budget']}}</td>
                <td>{{$item['social_network']}}</td>
                <td>{{$item['exp']}}</td>
                <td>{{$item['payout']}}</td>
                <td>{{$item['priority']}}</td>
            </tr>
        @endforeach
    </table>
        <table border="1">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Tags</th>
                <th>Country</th>
                <th>AR</th>
                <th>Age</th>
                <th>Budget</th>
                <th>Social Network</th>
                <th>Exp</th>
                <th>Payout</th>
            </tr>
            @foreach($result as $item)
                <tr>
                    <td><img class="image-product" src="{{$item['image']}}"></td>
                    <th>{{$item['name']}}</th>
                    <td>{{$item['tags']}}</td>
                    <td>{{$item['country']}}</td>
                    <td>{{$item['ar']}}</td>
                    <td>{{$item['age_of_use']}}</td>
                    <td>{{$item['budget']}}</td>
                    <td>{{$item['social_network']}}</td>
                    <td>{{$item['exp']}}</td>
                    <td>{{$item['payout']}}</td>
                    <td>{{$item['priority']}}</td>
                </tr>
            @endforeach
        </table>
    </form>

@endsection
