@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')

<div class="row">
    <div class="col-sm-6">
        <div class='page-heading'>Просмотр Объявления</div>

        @section('css')
            @parent
            <link type="text/css" rel="stylesheet" href="/css/fancybox/jquery.fancybox.css">
        @endsection

        @section('js')
            @parent
                <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>
                <script type="text/javascript" src="/js/jquery.fancybox.js"></script>
                <script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
        @endsection

        @if($data->lat && $data->lng)
            <script>
                $('document').ready(function(){
                     var myOptions = {
                            zoom: 13,
                            draggable: true,
                            zoomControl: true,
                            scrollwheel: false,
                            disableDoubleClickZoom: true,
                            @if($data->lat)
                                center: new google.maps.LatLng({{$data->lat}}, {{$data->lng}}),
                            @else
                                center: new google.maps.LatLng(-33.8688, 151.2195),
                            @endif
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };

                        var map = new google.maps.Map(document.getElementById("map"), myOptions);

                        var marker = new google.maps.Marker({
                                position: new google.maps.LatLng({{$data->lat}}, {{$data->lng}}),
                                draggable: false,
                                optimized: false,
                                map: map
                            });
                });
            </script>
        @endif

        <script type="text/javascript">
            $(document).ready(function() {
                $(".fancybox").fancybox();
            });
        </script>

        <style>
            .cover{
                height:300px;
                width:300px;
                display:table;
                border:2px solid black;
            }
            .cover .inner{
                vertical-align: middle;
                display:table-cell;
            }

            .cover img{
                max-height:300px;
                max-width:300px;
            }

            .info .label{
                font-size:14px;
            }
        </style>

        <div class="block">
            <div class="row">
                <div class="col-sm-6">
                    <div class="cover">
                        <div class="inner">
                            <?php if($data->image){ ?>
                                <img src="/assets/adv/{{$data->user_id}}/{{$data->id}}/{{$data->image->name}}">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="info">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="label">Заголовок:</div>
                                </div>
                                <div class="col-sm-8">{{$data->title}}</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="label">Тип:</div>
                                </div>
                                <div class="col-sm-8">
                                    <?php if(!$data->tags->isEmpty()){ ?>
                                        <?php foreach($data->tags as $tag){ ?>
                                            {{Config::get('custom.types')[$tag->tag_id]}}
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="label">Создано:</div>
                                </div>
                                <div class="col-sm-8">{{date('Y-m-d',strtotime($data->date))}}</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="label">Осталось мест:</div>
                                </div>
                                <div class="col-sm-8">{{$data->max_members - $count}}</div>
                            </div>
                        </div>
                        
                        <?php if(Auth::user()->id == $data->user_id){ ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="/reservation/show/{{$data->id}}" class="btn btn-blue">Просмотреть Забронированных</a>
                                        </div>
                                    </div>
                                </div>
                        <?php }else{ ?>
                            <?php if(Auth::user()->id && Auth::user()->id != $data->user_id && !$reservations){ ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="/reservation/registration/{{$data->id}}" class="btn btn-blue">Забронировать Место</a>
                                        </div>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span style="color:red; font-weight:bolder;">Вы уже создали заявку на это объявление</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
        </div>

        <style>
            .block.images .element{
                cursor:pointer;
                width:150px;
                height:150px;
                display:inline-block;
                vertical-align: top;
                background: #ddd;
                border: 1px solid black;
                margin:5px;
                box-sizing: initial;
            }
            .block.images .element img{
                max-height:150px;
                max-width:150px;
            }

            .images .element .image{
                display:table;
                height: 100%;
            }
            .images .element .inner{
                display:table-cell;
                vertical-align: middle;
            }

            .block.images .element .cell{
                vertical-align: middle;
                text-align: center;
            }
        </style>
        <div class="block images">
            <?php foreach($data->images as $item){ ?>
                <div class="element">
                    <div class="image">
                        <div class="inner">
                            <a class="fancybox" rel="group" href="/assets/adv/<?=$item->user_id?>/<?=$item->adv_id?>/<?=$item->name?>"><img src="/assets/adv/<?=$item->user_id?>/<?=$item->adv_id?>/thumb<?=$item->name?>"></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <?=nl2br($data->full_description)?>
        </div>

        <div class="block">
            <div id="map" style="width:100%; height:300px;"></div>
        </div>
    </div>
</div>
@endsection