@extends('layouts.online')
@section('title', 'Редактирование обяъвления')

@section('content')
    <div class='page-heading'>Место проведения</div>
    
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>
    
<script>
    $('document').ready(function(){
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('location'));
        //autocomplete.bindTo('bounds', map);   //показывает автозапалнение относительно границ отображаемой части карты
        //загружаем карту там где указано значение... TODO что бы не создавало объект каждый раз а лишь меняло параметры
            var myOptions = {
                zoom: 13,
                draggable: true,
                zoomControl: true,
                scrollwheel: false,
                disableDoubleClickZoom: true,
                <?php if($data->lat){ ?>
                    center: new google.maps.LatLng(<?=$data->lat?>, <?=$data->lng?>),
                <?php }else{ ?>
                    center: new google.maps.LatLng(-33.8688, 151.2195),
                <?php } ?>
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            
            var map = new google.maps.Map(document.getElementById("map"), myOptions);
            
        google.maps.event.addListener(map, "dragend", function(event){
            setCoords(map.getCenter().lat(),map.getCenter().lng());
        });
            
        autocomplete.addListener('place_changed', function(){            
            map.setCenter(new google.maps.LatLng(autocomplete.getPlace().geometry.location.lat(),autocomplete.getPlace().geometry.location.lng()));
            setCoords(autocomplete.getPlace().geometry.location.lat(),autocomplete.getPlace().geometry.location.lng());
        });
    });
    function setCoords(lat,lng){
        //position_x = lat;
        //position_y = lng;
        $('form input[name=lat]').val(lat);
        $('form input[name=lng]').val(lng);
    }
    
</script>
<style>
    .map_block{
        width:100%;
        height:400px;
        position:relative;
    }
    #map{
        width:100%;
        height:100%;
    }
    .map_pin{
        height: 46px;
        position: absolute;
        width: 31px;
        background:url('/images/pin.png');
        left:50%;
        top:50%;
        margin-top:-23px;
        margin-left:-15.5px;
    }
</style>

<form action='' method='POST' class="form">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <input class="form-control" type="text" id="location" value='<?=$data->address?>' name='address'>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <div class='map_block'>
                    <div id="map"></div>
                    <div class="map_pin"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <input type='submit' value='Сохранить' class="btn btn-blue">
                <input type='hidden' name='lat' value='<?=(int)$data->lat?>'>
                <input type='hidden' name='lng' value='<?=(int)$data->lng?>'>
            </div>
        </div>
    </div>
</form>

@endsection