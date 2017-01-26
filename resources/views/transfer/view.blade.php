@extends('layouts.online')
@section('title', 'Расположение мест в транспорте')

@section('content')
    @section('css')
        @parent
        
    @endsection

    @section('js')
        @parent
            
    @endsection
    <div class='page-heading'>Список созданного транспорта</div>
    <script>
        /*$('document').ready(function(){
            $('.transports').change(function(){
                var id = $('option:selected',this).val();
                
                $.ajax({
                    url:'/transfer/view/'+id,
                    type:'GET',
                    success:function(msg){
                        console.log(msg);
                    }
                });
            });
        });*/
    </script>
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
        
        #canvas{
            position:relative;
            width:900px;
            height:400px;
            border: 1px solid black;
        }
    </style>
    <script>
        app.controller('viewCtrl', function($scope){
            $scope.transfer = '0';
            $scope.seats = [];
                
            $scope.getSeats = function(){
                $.ajax({
                    url:'/transfer/view/'+$scope.transfer,
                    type:'GET',
                    success:function(msg){                        
                        var json = JSON.parse(msg);                        
                        $scope.seats = json;
                        $scope.$digest();
                    }
                });
            }            
            $scope.editLink = function(){
                location.href = '/transfer/seats/'+$scope.transfer;
            };
        });
    </script>
    
    <div id="seats" ng-controller="viewCtrl">
        <div class="form-group">
            <select class="form-control transports" ng-change="getSeats()" ng-model="transfer">
                <option value="0">Транспорт</option>                
                <?php foreach($data as $item){ ?>                
                    <option value="<?=$item->id?>"><?=$item->name?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <div id="canvas"  style="overflow: hidden; position:relative;">
                <div ng-repeat="item in seats" data-id="" class="seat item"  style="position:absolute; top:@{{item.y_pos*50}}px;left:@{{item.x_pos*50}}px ; height: 40px; width:40px;">
                </div>           
            </div>
        </div>
        <div class='form-group'>
            <a class='btn btn-primary' ng-click="editLink()" ng-hide='transfer == 0'>Редактировать</a>
        </div>
    </div>
@endsection