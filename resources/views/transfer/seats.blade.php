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
        app.controller('mainCtrl', function($scope){
            $scope.start_x = 0;
            $scope.start_y = 0;

            $scope.mouse_x = 0;
            $scope.mouse_y = 0;
            $scope.pos_x = 0;
            $scope.pos_y = 0;

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
            
            $('.tools .item').mousedown(function(){     //выбор из предложеныъ инструментов
                $scope.status = 1;
                $('.selected_element').empty();
                
                $scope.height = parseInt($(this).css('height'));
                $scope.width = parseInt($(this).css('width'));
                var el = $(this).clone();
                
                $('.selected_element').append(el);
                                
                $('.selected_element').css({'display':'block'});
                $('.selected_element').css({'left':$scope.mouse_x-$scope.width,'top':$scope.mouse_y-$scope.height});
            });
            
            $('body').mouseup(function(e){
                $scope.getCanvaPos();
                
                $('.selected_element').empty().css({'display':'none'});
            });
            
            
            $scope.saveItemPosition = function(){   //сохраняем позицию объекта
                $scope.getCanvaPos();
                if($scope.status == 1){
                    if($scope.pos_x < 0 || $scope.pos_y < 0) return false;

                    $scope.status = 0;
                    var el = $('.selected_element .item');
                    $(el).css({'position':'absolute','left':$scope.pos_x-$scope.width,'top':$scope.pos_y-$scope.height});
                    $('#canvas').append(el);

                    $.ajax({
                        url:location.href,
                        type:'POST',
                        data:{x:$scope.pos_x-$scope.width , y:$scope.pos_y-$scope.height},
                        success:function(msg){

                        }
                    });
                }
                
                if($scope.item_id){
                    var el = $('#canvas .item[data-id='+$scope.item_id+']');
                    
                    var x = $scope.pos_x-$scope.width;
                    var y = $scope.pos_y-$scope.height;
                    
                    $(el).css({'position':'absolute','left':x,'top':y});
                                        
                    $.ajax({
                        url:'/transfer/seats/1/edit',
                        type:'POST',
                        data:{x:x , y:y,seat_id:$scope.item_id},
                        success:function(msg){
                            
                            $scope.item_id = 0; 
                        }
                    });
                }
            }
            
            $('.maincontent').mousemove(function(e){
                $scope.getCanvaPos();
                
                var params = $(this)[0].getBoundingClientRect();
                $scope.start_x = params.x;
                $scope.start_y = params.y;
                
                $scope.mouse_x = e.clientX - $scope.start_x;
                $scope.mouse_y = e.clientY - $scope.start_y;
                                
                $('#x').val($scope.mouse_x);
                $('#y').val($scope.mouse_y);
                if($scope.status == 1){
                    $('.selected_element').css({'left':$scope.mouse_x-$scope.width,'top':$scope.mouse_y-$scope.height});
                }
                
                if($scope.item_id > 0){
                    $('#canvas .item[data-id='+$scope.item_id+']').css({'position':'absolute','left':$scope.pos_x-$scope.width,'top':$scope.pos_y-$scope.height});
                }
            });
            
           
            
            $scope.moveItems = function($event){
                var el = $event.target;
                
                if($($event.target).attr('class') == undefined) return;
                if($($event.target).attr('class').indexOf('edit') != -1){
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
                }
                
                if($($event.target).attr('class').indexOf('item') != -1){
                    $scope.item_id = $(el).attr('data-id');

                    $scope.height = $(el).height();
                    $scope.width = $(el).width();

                    var x = $scope.pos_x-$scope.width;
                    var y = $scope.pos_y-$scope.height;

                    $(el).css({'position':'absolute','left':x,'top':y});
                }
            }
            
            $('#canvas').on('.item','doubleclick',function(){
                
            });
        });
    </script>

    
    
    <div id="seats" ng-controller="mainCtrl">

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