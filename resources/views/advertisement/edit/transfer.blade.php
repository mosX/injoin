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
        
        #canvas{
            position:relative;
            width:auto;
            height:200px;
            border: 1px solid black;
        }
    </style>
    <script>
        app.controller('transferCtrl', function($scope){
            $scope.transfer_id = '0';
            $scope.seats = [];
            
            $scope.addTransfer = function(){
                $.ajax({
                    url:location.href,
                    type:'POST',
                    data:{'id':$scope.transfer_id},
                    success:function(msg){
                        
                    }
                });
            }
            
            $scope.previewTransfer = function($event){                
                $.ajax({
                    url:'/advertisement/edit/transfer_preview/'+$scope.transfer_id,
                    type:'GET',
                    success:function(msg){
                        //$('#preview').html(msg);
                        var json = JSON.parse(msg);
                        console.log(json);
                        $scope.seats = json;
                        $scope.$digest();
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
                    <div id="canvas" ng-mouseup="saveItemPosition()" ng-mousedown="moveItems($event)">                        
                        <div ng-repeat="item in seats" data-id="@{{item.id}}" class="seat item" style="position:absolute; top:@{{item.y_pos*30}}px;left:@{{item.x_pos*30}}px">
                            
                        </div>                        
                    </div>

                </div>
            </div>
            
            <h3>Выбранные</h3>
            <div id="selected">
                <?php foreach($transfers as $item){ ?>
                    <div id="canvas" ng-mouseup="saveItemPosition()" ng-mousedown="moveItems($event)">
                        <?php foreach($item->seats as $seat){ ?>
                            <div data-id="<?=$seat->id?>" class="seat item" style="position:absolute; top:<?=$seat->y_pos*30?>px;left:<?=$seat->x_pos*30?>px">
                                <div class="number"><?=$seat->number?></div>
                            </div>
                        <?php } ?>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    
@endsection