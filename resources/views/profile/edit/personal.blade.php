@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Редактировать профиль</div>
    
    
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
                    <?php if(Auth::user()->lat){ ?>
                        center: new google.maps.LatLng(<?=Auth::user()->lat?>, <?=Auth::user()->lng?>),
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
                console.log(autocomplete.getPlace());
                setCoords(autocomplete.getPlace().geometry.location.lat(),autocomplete.getPlace().geometry.location.lng());

                //var country = getRegion(autocomplete.getPlace().address_components,'country');
                var city = getRegion(autocomplete.getPlace().address_components,'locality');
                var street = getRegion(autocomplete.getPlace().address_components,'route');
                var street_number = getRegion(autocomplete.getPlace().address_components,'street_number');

                $('form input[name=city]').val(city);
                $('form input[name=address]').val(street+' '+street_number);
            });
        });

        function getRegion(data,region){

            for(var i = 0; i < data.length ; i++){
                for(var j = 0; j < data[i].types.length; j++){
                    if(data[i].types[j] == region){
                        return data[i].long_name;
                        break;
                    }

                }
            }
        }

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

    <p style="color:orange;">Данная информация будет отображаться лишь владельцам объявлений в случае если он укажет необходимость этих данных при бронирование.</p>

    <form action='' method='POST' class="form">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Серия паспорта</div>
                </div>
                <div class="col-sm-12">
                    <input class="form-control" type="text" name="passport" value="<?=Auth::user()->passport?>">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Идентификационный номер</div>
                </div>
                <div class="col-sm-12">
                    <input class="form-control" type="text" name="inn" value="<?=Auth::user()->inn?>">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Страна</div>
                </div>
                <div class="col-sm-12">
                    <select name="country" class="form-control">
                        <option value="0">Страна</option>

                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Город</div>
                </div>
                <div class="col-sm-12">
                    <input class="form-control" type='text' value="<?=Auth::user()->city?>" name="city" >
                </div>
            </div>
        </div>
            
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Адресс</div>
                </div>
                <div class="col-sm-12">
                    <input class="form-control" type='text' value="<?=Auth::user()->address?>" name="address" >
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <div class="label">Полный Адресс</div>
                </div>
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="location" value='<?=Auth::user()->full_address?>' name='full_address'>
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
                    <input type='hidden' name='lat' value='<?=(int)Auth::user()->lat?>'>
                    <input type='hidden' name='lng' value='<?=(int)Auth::user()->lng?>'>
                </div>
            </div>
        </div>
    </form>
@endsection