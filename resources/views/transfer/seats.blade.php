@extends('layouts.online')
@section('title', 'Расположение мест в транспорте')

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
    <div class='page-heading'>Расположение мест в транспорте</div>
        
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
    
    <script>
        app.controller('seatsCtrl', function($scope){
            $scope.start_x = 0;
            $scope.start_y = 0;

            $scope.mouse_x = 0;
            $scope.mouse_y = 0;
            $scope.pos_x = 0;
            $scope.pos_y = 0;
            
            $scope.move_status = false;

            $scope.height = 0;
            $scope.width = 0;

            $scope.status = 0;
            $scope.item_id = 0;

            $scope.block_width = $('#canvas').width();
            $scope.block_height = $('#canvas').height();
                                                
            $scope.editInfo = function($event){
                $event.preventDefault();
                
                $.ajax({
                    url:'/transfer/seats/info/'+$scope.element_id,
                    type:'POST',
                    data:{number:$scope.number, description:$scope.description},
                    success:function(msg){
                        $('#seatEditModal').modal('hide');
                    }
                });
            }
                                                            
            $scope.getCanvaPos = function(){
                var params = $('#canvas')[0].getBoundingClientRect();
                var x = params.x;
                var y = params.y;

                $scope.pos_x = parseInt($scope.mouse_x+$scope.start_x - x);
                $scope.pos_y = parseInt($scope.mouse_y+$scope.start_y - y);

                $('#x2').val($scope.pos_x);
                $('#y2').val($scope.pos_y);
            }
            
            $('.tools .item').mousedown(function(e){     //выбор из предложеныъ инструментов                
                var mouse_x = e.pageX;
                var mouse_y = e.pageY;
                
                var rect = $(this)[0].getBoundingClientRect();
                
                var parent = $('.maincontent')[0].getBoundingClientRect();
                
                $scope.item_margin_pos_x = mouse_x - rect.x;
                $scope.item_margin_pos_y = mouse_y - rect.y;
                
                var left = mouse_x - $scope.item_margin_pos_x  - parent.x;
                var top = mouse_y - $scope.item_margin_pos_y  - parent.y;
                
                //$scope.status = 1;
                $scope.move_status = true;
                $('.selected_element').empty();
                
                $scope.height = parseInt($(this).css('height'));
                $scope.width = parseInt($(this).css('width'));
                var el = $(this).clone();
                
                $('.selected_element').append(el);
                
                
                                
                $('.selected_element').css({'display':'block'});
                $('.selected_element').css({'background':'red','left':left+'px','top':top+'px'});
            });
            
            $('.maincontent').mousemove(function(e){
                var mouse_x = e.pageX;
                var mouse_y = e.pageY;
                    
                if($scope.move_status > 0){ //если мы нажали на елемент выбора
                    var parent = $('.maincontent')[0].getBoundingClientRect();
    
                    var left = mouse_x - $scope.item_margin_pos_x  - parent.x;
                    var top = mouse_y - $scope.item_margin_pos_y  - parent.y;
                    
                    $('.selected_element').css({'left':left,'top':top});
                }
                
                if($scope.item_id > 0){ //для существующего елемента
                    var parent = $('.maincontent #canvas')[0].getBoundingClientRect();
    
                    var left = mouse_x - $scope.item_margin_pos_x  - parent.x;
                    var top = mouse_y - $scope.item_margin_pos_y  - parent.y;
                    
                    $('#canvas .item[data-id='+$scope.item_id+']').css({'position':'absolute','left':left,'top':top});
                }
            });
            
            $('body').mouseup(function(e){
                $scope.getCanvaPos();
                
                $('.selected_element').empty().css({'display':'none'});
            });
            
            
            $scope.saveItemPosition = function(e){   //сохраняем позицию объекта
                $scope.getCanvaPos();
                
                if($scope.move_status == true){
                    //if($scope.pos_x < 0 || $scope.pos_y < 0) return false;
                    
                    $scope.move_status = false;
                    var el = $('.selected_element .item');
                    var parent = $('.maincontent #canvas')[0].getBoundingClientRect();
                    
                    var mouse_x = e.pageX;
                    var mouse_y = e.pageY;
                    
                    var left = mouse_x - parent.x;
                    var top = mouse_y - parent.y;
                    
                    //выравниваем по сетке с допуском 50 на 50
                    left = Math.floor(left / 50);
                    top = Math.floor(top / 50);
                    
                    $(el).css({'position':'absolute','left':(left*50),'top':(top*50)});
                    //$('#canvas').append(el);

                    $.ajax({
                        url:location.href,
                        type:'POST',
                        data:{x:left , y:top},
                        success:function(msg){
                            var json = JSON.parse(msg);
                            if(json.status == 'success'){
                                $('#canvas').append(
                                    '<div data-id="4" class="seat item" ng-mousedown="moveItems($event)" style="position:absolute; top:'+(top*50)+'px;left:'+(left*50)+'px">'
                                    +'<a href="" class="edit"></a>'
                                    +'<div class="number"></div>'
                                    +'</div>'
                                );
                            }else{
                                
                            }
                        }
                    });
                }
                
                if($scope.item_id){ //меняем позицию уже соществующего
                    var el = $('#canvas .item[data-id='+$scope.item_id+']');
                    
                    var item_id = $scope.item_id;
                    $scope.item_id = 0;
                    
                    var x_pos = Math.floor((parseInt($(el).css('left')) + $scope.item_margin_pos_x)/50);
                    var y_pos = Math.floor((parseInt($(el).css('top'))  + $scope.item_margin_pos_y)/50);
                    
                    $(el).css({'position':'absolute','left':(x_pos*50),'top':(y_pos*50)});
                    
                    $.ajax({
                        url:'/transfer/seats/1/edit',
                        type:'POST',
                        data:{x:x_pos , y:y_pos,seat_id:item_id},
                        success:function(msg){                            
                            //$scope.item_id = 0; 
                        }
                    });
                }
            }
            
            $scope.moveItems = function(e){
                var el = e.target;
                
                //if($($event.target).attr('class') == undefined) return;
                /*if($($event.target).attr('class').indexOf('edit') != -1){
                    $scope.element_id = $(el).parent('.item').attr('data-id');
                    
                    $.ajax({
                        url:'/transfer/seats/1/modal/'+$scope.element_id,
                        type:'GET',
                        success:function(msg){
                            var json = JSON.parse(msg);
                            $scope.number = json.number;
                            $scope.description = json.description;
                            
                            $scope.$digest();
                            
                            $('#seatEditModal').modal('show');
                        }
                    });
                }*/
                
                if($(el).attr('class').indexOf('item') != -1){
                    $scope.item_id = $(el).attr('data-id');
                        
                    $scope.height = $(el).height();
                    $scope.width = $(el).width();
                    
                    var mouse_x = e.pageX;
                    var mouse_y = e.pageY;
                    var parent = $('.maincontent #canvas')[0].getBoundingClientRect();
                    var element = $(el)[0].getBoundingClientRect();
                    
                    $scope.item_margin_pos_x = mouse_x - element.x;
                    $scope.item_margin_pos_y = mouse_y - element.y;
                    
                    var left = mouse_x - parent.x - $scope.item_margin_pos_x;
                    var top = mouse_y - parent.y - $scope.item_margin_pos_y;
                    
                    $(el).css({'position':'absolute','left':left,'top':top});
                }
            }
             
            $('#canvas').on('mousedown','.item',function(e){
               ////ng-mousedown="moveItems($event)" 
               $scope.moveItems(e);
               //console.log('test');
            });
            /*$('#canvas').on('.item','doubleclick',function(){
                
            });*/
        });
    </script>

    
    
    <div id="seats" ng-controller="seatsCtrl">

        <input type="text" value="" ng-model="element_id">
        
        <input type="text" id="x" value="0" ng-model="x">
        <input type="text" id="y" value="0">

        <input type="text" id="x2" value="0">
        <input type="text" id="y2" value="0">
    
        <div class="tools">
            <div class="selected_element"></div>
            <ul>
                <li><div class="seat item" ng-mousedown=""></div></li>
            </ul>
        </div>

        <div id="canvas" ng-mouseup="saveItemPosition($event)"  style="overflow: hidden">
            <?php if($data){ ?>
                <?php foreach($data as $item){ ?>
                    <div data-id="<?=$item->id?>" class="seat item"  style="position:absolute; top:<?=$item->y_pos*50?>px;left:<?=$item->x_pos*50?>px">
                        <a href="" class="edit"></a>
                        <div class="number"><?=$item->number?></div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    
            <div class="modal fade" id="seatEditModal" tabindex="-1" role="dialog">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button class="close" data-dismiss="modal">×</button>
                           <h4 class="modal-title font-header"><p><strong>Редактировать</strong></p></h4>
                       </div>

                       <div class="modal-body">
                           <form action="/" method="POST" ng-submit="editInfo($event)" novalidate>
                               <div class="form-group">
                                   <div class="row">
                                       <div class="col-sm-12">
                                           <div class="label">Номер:</div>
                                       </div>

                                       <div class="col-sm-12">
                                           <input type="text" class="form-control" placeholder="Number" name='number' ng-model="number">
                                           <input type="hidden" class="" name="id" ng-model="element_id">
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group">
                                   <div class="row">
                                       <div class="col-sm-12">
                                           <div class="label">Описание:</div>
                                       </div>
                                       <div class="col-sm-12">
                                           <input type="text" class="form-control" placeholder='Description' name='description' ng-model="description">
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group">
                                   <div class="row">
                                       <div class="col-sm-12">
                                           <input type="submit" class="btn btn-blue" value="Изменить">
                                       </div>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    
@endsection