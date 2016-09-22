@extends('layouts.online')
@section('title', 'Создание обяъвления')

<?php //p($errors->first('title'))?>

@section('content')
    @section('css')
        @parent
        <link type="text/css" rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
    @endsection

    @section('js')
        @parent
            <script type="text/javascript" src="/js/moment.js"></script>
            <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
    @endsection
    
    <div class='page-heading'>Выбрать место для посадки</div>
        <style>
        .tools{
            margin-top:10px;
        }
        
        .tools ul li{
            display:inline-block;
        }
        
        #seats .item{
            position:relative;
        }
        
        #seats .item .edit{
            cursor:pointer;
            position:absolute;
            right:0px;
            top:0px;
            width:10px;
            height:10px;
            background : blue;
        }
        #seats .item .number{
            text-align: center;
            color: white;
            margin-top:8px;
        }
        
        #seats .seat{
            width:40px;
            height:40px;
            background: black;
            cursor:pointer;
        }
        
        .selected_element{
            width:25px;
            height:25px;
            display:none;
            position:absolute;
        }
        
        #canvas{
            position:relative;
            width:900px;
            height:400px;
            border: 1px solid black;
        }
    </style>
    
    
    <div id="seats" ng-controller="mainCtrl">
    
        <div id="canvas" ng-mouseup="saveItemPosition()" ng-mousedown="moveItems($event)">
            <?php if($data){ ?>
                <?php foreach($data as $item){ ?>
                    <div data-id="<?=$item->id?>" class="seat item" style="position:absolute; top:<?=$item->y_pos?>px;left:<?=$item->x_pos?>px">
                        <a href="" class="edit"></a>
                        <div class="number"><?=$item->number?></div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
@endsection