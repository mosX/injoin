@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Персональные данные</div>
    
<?php if(Auth::user()->lat && Auth::user()->lng){ ?>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>
    <script>
        $('document').ready(function(){
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

                var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(<?=Auth::user()->lat?>, <?=Auth::user()->lng?>),
                        draggable: false,
                        optimized: false,
                        map: map
                    });
        });
    </script>
<?php } ?>
    
<style>
    .personal_info{
        width:100%;
        display:table;
    }
    
    .personal_info .ava{
        cursor:pointer;
        overflow: hidden;
        border: 1px solid grey;
        text-align: center;
        vertical-align: middle;
        width:200px;
        height:200px;
        display:table-cell;
        position:relative;
    }
    
    .personal_info .ava img{
        max-width: 190px;
        max-height:190px;
    }
    
    .personal_info .info{
        display: table-cell;
    }
</style>
<style>
    .ava .ava_action{
        padding-top:5px;
        background: rgba(0,0,0,0.5);
        min-height: 30px;
        position:absolute;
        bottom:-30px;
        width:100%;
        
    }
    .ava .ava_action a{
        text-decoration: none;
        display:block;
        width:100%;
        height: 100%;
        color: #d6d6d6;
        font-size:12px;
        text-align: center;   
    }
    .ava .ava_action a:hover{
        color: white;
    }
</style>
<script>
    $('document').ready(function(){
       $('.ava').hover(function(){
           $('.ava .ava_action').animate({'bottom':'0px'},200);
       },function(){
           $('.ava .ava_action').animate({'bottom':'-30px'},200);
       });
       
       $('.ava .ava_action a').click(function(){
           var iframe = $('iframe.ava_update_frame')[0].contentDocument;
           console.log(iframe);
           console.log($('#upload-form',iframe));
           $('#upload-form input[name=file]',iframe).click();
           return false;
       });
    });
</script>

<script>
    function addImage(file){
        $('.ava img').attr('src',file);
    }
</script>


<div class="panel personal_info">
    <div class="ava">
        <iframe width="0" height="0" class="ava_update_frame" src="/profile/updateava/" style="display: none;"></iframe>
        <img src="<?=Auth::user()->ava ? "/assets/users/".Auth::user()->id."/".Auth::user()->ava : '/images/noava.png'?>">
        <div class="ava_action"><a href="">Загрузить новую фотографию</a></div>
    </div>
    
    <div class="info">
        <div class="row">
            <div class="col-sm-2">
                <div class="label">Имя:</div>
            </div>
            <div class="col-sm-10">
                {{Auth::user()->firstname}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="label">Фамилия:</div>
            </div>
            <div class="col-sm-10">
                {{Auth::user()->lastname}}
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">
                <div class="label">Email:</div>
            </div>
            <div class="col-sm-10">
                {{Auth::user()->email}}
            </div>
        </div>
        
        @if((int)Auth::user()->birthday)
            <div class="row">
                <div class="col-sm-2">
                    <div class="label">Дата Рождения:</div>
                </div>
                <div class="col-sm-10">
                    {{date("Y-m-d",strtotime(Auth::user()->birthday))}}
                </div>
            </div>
        @endif
        
        <div class="row">
            <div class="col-sm-2">
                <div class="label">На сайте с:</div>
            </div>
            <div class="col-sm-10">
                <?=date('Y-m-d H:i:s',strtotime(Auth::user()->date))?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">
                <div class="label">Был на сайте:</div>
            </div>
            <div class="col-sm-10">
                <?=date('Y-m-d H:i:s',strtotime(Auth::user()->last_login))?>
            </div>
        </div>
    </div>
</div>

<style>
    .tag img{
        max-width:200px;
        max-height:150px;
    }
    .tag{
        box-sizing: content-box;
        border: 2px solid black;
        width:200px;
        height:200px;
        text-align: center;
    }
    .tag .cover{
        width:200px;
        margin:auto;
        height: 150px;
        display:table;
    }
    .tag .cover .img_block{
        display:table-cell;
        vertical-align: middle;
    }

    
</style>
@if($data)
    <div class="block" style='margin-bottom:20px;'>
        <h2>Последние объявления</h2>
        <div class="row tags">
            @foreach($data as $item)
                <div class="col-sm-4">
                    <div class="tag">
                        <div class="cover">
                            <div class='img_block'>
                                <img align="middle" src="<?=$item->image ? '/assets/adv/'.$item->user_id.'/'.$item->id.'/'.$item->image->name : '/images/noimage.jpg'?>">
                            </div>
                        </div>
                        <a href="/advertisement/show/<?=$item->id?>/" class="title"><?=$item->title?></a>
                        <div class="date"><?=$item->date?></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="block">
    <div id="map" style="width:100%; height:300px;"></div>
</div>
@endsection