<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Where Should I live in LA</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
         <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style>
.dot {
  height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;
}

#mapid { height: 580px; }
</style>
        <!-- JS -->
        <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script>
        $(document).ready( function () {
            $('#la-results').DataTable({
                "searching": false,
                "order": [[ 0, "desc" ]]
            });
        });
        </script>

<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>

    </head>
    <body>
        <div class="container">
            <h1>Find an LA Neighborhood to Live In</h1>
<?php

if (isset($preferences)) {
    $testChecked = function($field) use ($preferences){
        if (isset($preferences[$field])) {
            return "checked";
        }
    };
} else {
    $testChecked = function() { return ""; };
}
?>
<form action="/" method="POST">
    @csrf
  <div class="form-group">
    <label for="cost" class="col-4 col-form-label"><strong>Maximum Median Price</strong></label>
    <div>
      <select id="cost" name="cost" class="custom-select">
        <option @if (isset($preferences) && $preferences['cost'] == 0) selected @endif value="0"><$500k</option>
        <option @if (isset($preferences) && $preferences['cost'] == 1) selected @endif value="1">$700k</option>
        <option @if (isset($preferences) && $preferences['cost'] == 2) selected @endif value="2">$900k</option>
        <option @if (isset($preferences) && $preferences['cost'] == 3) selected @endif value="3">>$900k</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label><strong>What do you do for fun?</strong></label>
    <div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="atm" id="fun_0" type="checkbox"class="custom-control-input" {{  $testChecked('atm') }} value="atm">
        <label for="fun_0" class="custom-control-label">I'll need to get cash first</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="bars_and_clubs" id="fun_1" type="checkbox" class="custom-control-input" {{  $testChecked('bars_and_clubs') }} value="bars_and_clubs">
        <label for="fun_1" class="custom-control-label">I like to boogie.</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="movies_and_theaters" id="fun_2" type="checkbox" class="custom-control-input" {{  $testChecked('movies_and_theaters') }} value="movies_and_theaters">
        <label for="fun_2" class="custom-control-label">Entertain me</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="professional_sports" id="fun_3" type="checkbox" class="custom-control-input" {{  $testChecked('professional_sports') }} value="professional_sports">
        <label for="fun_3" class="custom-control-label">I'm at the game</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="restaurants" id="fun_4" type="checkbox" class="custom-control-input" {{  $testChecked('restaurants') }} value="restaurants">
        <label for="fun_4" class="custom-control-label">Checking out a new place to eat</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label><strong>What kind of landscapes do you like to live near?</strong></label>
    <div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="parks" id="outdoor_0" type="checkbox"class="custom-control-input" {{  $testChecked('parks') }} value="parks">
        <label for="outdoor_0" class="custom-control-label">Parks</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="historic_landmark" id="outdoor_1" type="checkbox" class="custom-control-input" {{  $testChecked('historic_landmark') }} value="historic_landmark">
        <label for="outdoor_1" class="custom-control-label">Historical Landscapes</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="movies_and_theaters" id="outdoor_2" type="checkbox" class="custom-control-input" {{  $testChecked('movies_and_theaters') }} value="movies_and_theaters">
        <label for="outdoor_2" class="custom-control-label">Water</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label><strong>What kind of local amenities do you like?</strong></label>
    <div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="culture" id="indoor_0" type="checkbox"class="custom-control-input" {{  $testChecked('culture') }} value="culture">
        <label for="indoor_0" class="custom-control-label">Museums</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="drinking" id="indoor_1" type="checkbox" class="custom-control-input" {{  $testChecked('drinking') }} value="drinking">
        <label for="indoor_1" class="custom-control-label">Winery, Brewery, or Distillery</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="colleges_and_universities" id="indoor_2" type="checkbox" class="custom-control-input" {{  $testChecked('colleges_and_universities') }} value="colleges_and_universities">
        <label for="indoor_2" class="custom-control-label">College or University</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label><strong>What do you like to shop for?</strong></label>
    <div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="food_and_beverage_retailer" id="retail_0" type="checkbox" {{  $testChecked('food_and_beverage_retailer') }} class="custom-control-input" value="food_and_beverage_retailer">
        <label for="retail_0" class="custom-control-label">Cooking/Kitchen Supplies</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="marijuana_dispenseries" id="retail_1" type="checkbox" class="custom-control-input" {{  $testChecked('marijuana_dispenseries') }} value="marijuana_dispenseries">
        <label for="retail_1" class="custom-control-label">Sativa, Indica, Hybrid, it is all good.</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="clothing_retail" id="retail_3" type="checkbox" class="custom-control-input" {{  $testChecked('clothing_retail') }} value="clothing_retail">
        <label for="retail_3" class="custom-control-label">Besides getting new clothes?</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="large_retail" id="retail_4" type="checkbox" class="custom-control-input" {{  $testChecked('large_retail') }} value="large_retail">
        <label for="retail_4" class="custom-control-label">Fun? I am buying stuff for the family</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="retail" id="retail_5" type="checkbox" class="custom-control-input" {{  $testChecked('retail') }} value="retail">
        <label for="retail_5" class="custom-control-label">I just need retail therapy</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label><strong>What sports do you like to play?</strong></label>
    <div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="outdoor_athletics" id="play_0" type="checkbox" class="custom-control-input" {{  $testChecked('outdoor_athletics') }} value="outdoor_athletics">
        <label for="play_0" class="custom-control-label">Anything as long as it is outside</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="indoor_athletics" id="play_1" type="checkbox" class="custom-control-input" {{  $testChecked('indoor_athletics') }} value="indoor_athletics">
        <label for="play_1" class="custom-control-label">Anything as long as it is inside</label>
      </div>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input name="video_games" id="play_2" type="checkbox" class="custom-control-input"  {{  $testChecked('video_games') }} value="video_games">
        <label for="play_2" class="custom-control-label">E Sports are a thing, Mom</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>


@if (isset($la_data))

<div id="mapid"></div>
<script type="text/javascript" src="js/zips.js"></script>

<script>

var zipScores = [
@foreach($la_data as $zip)
{
    zip: {{$zip->zip}},
    score: {{$zip->score/$max_score}}
},
@endforeach
];


    var rgbToHex = function (rgb) {
        rgb = Math.round(rgb);
        var hex = Number(rgb).toString(16);
        if (hex.length < 2) {
            hex = "0" + hex;
        }
        return hex;
    };

    function getColor(nameKey){
        for (var i=0; i < zipScores.length; i++) {
            color = "#FFFFFF";
            if (zipScores[i].zip == nameKey) {
                red =  rgbToHex(255*zipScores[i].score);
                blue = rgbToHex(255*(1-zipScores[i].score));
                color = "#"+red+"00"+blue;
                return color;
            }
        }
    }

	function style(feature) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.3,
			fillColor: getColor(feature.properties.zipcode)
		};
	}

	var mymap = L.map('mapid').setView([{{  $la_data[0]->lat    }}, {{  $la_data[0]->long    }}], 10);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

    var geojson = L.geoJson(zipData, {style: style}).addTo(mymap);

</script>
<script>$('#la-results').DataTable();</script>
<p>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-2">
                Best Match
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(255,0,0)"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                Worst Match
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(0,0,255)"></span>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-7 offset-sm-3">
                Above Average Growth
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(0,255,0)"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7 offset-sm-3">
                Average Growth
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(0,255,255)"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7 offset-sm-3">
                Below Average Growth
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(0,0,255)"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7 offset-sm-3">
                Negative Growth
            </div>
            <div class="col-sm-1">
                <span class="dot" style="background-color:rgb(0,0,0)"></span>
            </div>
        </div>
    </div>
  </div>
</div>




<table id="la-results" class="display" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">Score</th>
                <th>Zip Code</th>
                <th>Community</th>
                <th class="text-center">2018 Growth</th>
                <th class="text-center">2017 Growth</th>
                <th class="text-center">2016 Growth</th>
            </tr>
        </thead>
        <tbody>


@foreach($la_data as $zip)
            <tr>
                <td class="text-center">
                    <span class="dot" style="background-color:rgb({{ 255*($zip->score/$max_score)    }},0,{{ 255*(1-($zip->score/$max_score))    }})"></span><br/>
                    {{number_format(100*$zip->score/$max_score,2)}}%
                </td>
                <td>{{$zip->zip}}</td>
                <td>{{$zip->community}}</td>
                <td class="text-center">
                    <span class="dot" style="background-color:rgb( 0,{{255*($zip->growth_2018/App\LaData::AVG_2018_GROWTH)    }},{{ 255*(App\LaData::AVG_2018_GROWTH/$zip->growth_2018)    }})"></span><br/>
                    {{number_format(100*$zip->growth_2018,2)}}%
                </td>
                <td class="text-center">
                    <span class="dot" style="background-color:rgb( 0,{{255*($zip->growth_2017/App\LaData::AVG_2017_GROWTH)    }},{{ 255*(App\LaData::AVG_2017_GROWTH/$zip->growth_2017 )    }})"></span><br/>
                    {{number_format(100*$zip->growth_2017,2)}}%
                </td>
                <td class="text-center">
                    <span class="dot" style="background-color:rgb( 0,{{255*($zip->growth_2016/App\LaData::AVG_2016_GROWTH)    }},{{ 255*(App\LaData::AVG_2016_GROWTH/$zip->growth_2016)    }})"></span><br/>
                    {{number_format(100*$zip->growth_2016,2)}}%
                </td>
            </tr>
@endforeach


        </tbody>
</table>
@endif




        </div>
    </body>
</html>



