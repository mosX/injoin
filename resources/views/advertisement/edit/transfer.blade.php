@extends('layouts.online')
@section('title', 'Редактирование обяъвления')
@section('css')
    @parent
    <link type="text/css" rel="stylesheet" href="/css/fancybox/jquery.fancybox.css">
@endsection
@section('js')
    @parent
        <script type="text/javascript" src="/js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
@endsection

@section('content')
    <div class='page-heading'>Редактирование Трансфер</div>
    
    <style>        
        .seat.item{
            position:relative;
        }
        
        .seat.item .edit{
            cursor:pointer;
            position:absolute;
            right:0px;
            top:0px;
            width:10px;
            height:10px;
            background : blue;
        }
        .seat.item .number{
            text-align: center;
            color: white;
            margin-top:8px;
        }
        
        .seat{
            width:20px;
            height:20px;
            background: black;
            cursor:pointer;
        }
        
        .selected_element{
            width:25px;
            height:25px;
            display:none;
            position:absolute;
        }
        
        .canvas{
            position:relative;
            width:auto;
            height:200px;
            border: 1px solid black;
        }
        #selected .canvas{
            margin-bottom: 10px;
            
        }
        #selected .canvas .close{
            position:absolute;
            right:10px;
            top:10px;
            opacity:1;
            background: #dddddd;
            width:26px;
            height: 26px;
            padding:1px 5px;
            text-align: center;
            border-radius: 15px;
        }
    </style>
    <script>
        app.controller('transferCtrl', function($scope,$http){
            $scope.transfer_id = '0';
            $scope.seats = [];
            
            $scope.addTransfer = function(){
                var req = {
                    url: location.href,
                    method: 'POST',
                    responseType: 'text',
                    data:{'id':$scope.transfer_id}
                };
                $http(req).then(function(ret){
                    if(ret.data.status == 'success'){
                        location.reload();
                    }
                });
            }
            
            $scope.previewTransfer = function($event){
                var req = {
                    url: '/advertisement/edit/transfer_preview/'+$scope.transfer_id,
                    method: 'GET',
                    responseType: 'text',
                };
                $http(req).then(function(ret){
                    $scope.seats = ret.data;
                });
            }
            
            $scope.remove = function(id,event){
                var req = {
                    url: '/advertisement/edit/transfer_remove/'+id,
                    method: 'GET',
                    responseType: 'text',
                };
                $http(req).then(function(ret){                    
                    if(ret.data.status == 'success'){
                        $(event.target).closest('.element').remove();
                    }
                });
            }
            
        });
    </script>
    
    <div class="row" ng-controller="transferCtrl">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="label">Выберите трансфер</div>
                    </div>
                    <div class="col-sm-12">
                        <select class="form-control" name="transfer" ng-change="previewTransfer($event)" ng-model="transfer_id">
                            <option selected value="0">Выберите трансфер</option>
                            <?php foreach($data as $item){ ?>
                                <option value="<?=$item->id?>"><?=$item->name?></option>
                            <?php } ?>
                        </select>                        
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <button class="btn btn-primary" ng-click="addTransfer()">Добавить</button>
            </div>
            
            <div class="form-group">
                <div id="preview">
                    <div class="canvas" ng-mouseup="saveItemPosition()" ng-mousedown="moveItems($event)" ng-hide="seats.length == 0">
                        <div ng-repeat="item in seats" data-id="@{{item.id}}" class="seat item" style="position:absolute; top:@{{item.y_pos*30}}px;left:@{{item.x_pos*30}}px"></div>
                    </div>

                </div>
            </div>
            
            <h3>Выбранные</h3>
            <div id="selected">                
                <?php foreach($transfers as $item){ ?>
                    <div class="element">
                        <?php if($item->transfer){?>
                            <h3><?=$item->transfer->name?></h3>
                        <?php } ?>
                        <div class="canvas">
                            <div class="close" ng-click="remove(<?=$item->id?>,$event)">×</div>
                            <?php foreach($item->seats as $seat){ ?>
                                <div data-id="<?=$seat->id?>" class="seat item" style="position:absolute; top:<?=$seat->y_pos*30?>px;left:<?=$seat->x_pos*30?>px">
                                    <div class="number"><?=$seat->number?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>    
@endsection