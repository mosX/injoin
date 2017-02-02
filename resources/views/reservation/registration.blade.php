@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Регистрация на Событие</div>
    <script>
        app.controller('reservCtrl', function($scope,$http){
            $scope.form = {};
            $scope.form.transfer_id = $('select[name=transfer] option').eq(0).val(); //ставим по умолчанию первый из списка
            $scope.form.adv_id = 0;
            
            $scope.seats = <?=$seats->toJson()?>;
            //console.log($scope.seats);
            
            /*$('select[name=transfer]').change(function(){
                console.log('32342');
            });*/
            
            $scope.getTransfer = function(){
                var id = $('option:selected','select[name=transfer]').val();
                //console.log(id);
                var req = {
                    url: '/reservation/registration/gettransfer/'+id,                    
                    method: 'GET',
                    responseType: 'text',
                };
                $http(req).then(function(ret){
                    $scope.seats = ret.data;
                });
                
                //event.preventDefault();
            }
            
            $scope.reservPlace = function(index,event){                
                $scope.form.seat_id = $scope.seats[index].id;
                var req = {
                    url: '/reservation/registration/seat/'+$scope.form.seat_id,
                    data:$scope.form,
                    method: 'POST',
                    responseType: 'text',
                };
                $http(req).then(function(ret){
                    if(ret.data.status == 'success'){
                        //$(event.target).addClass('selected');
                        $scope.seats = ret.data.data;
                        //location.reload();
                    }else{
                        alert(ret.data.message);
                    }
                });

                event.preventDefault();
            }
        });
    </script>
    <div class="inner" ng-controller="reservCtrl">
        @if($reservations)
            <div class="error">Вы уже создали заявку на это событие</div>
        @endif

        @if($data->with_moderation)
            <div class="notification">Данное Объявление требует Подтверждения владельца .</div>
        @endif

        <p>Если вы согласны с условиями и выполнили все действия указанные автором события то нажмите на "Забронировать"</p>
        <form style="width:500px;">
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-label">Транспорт</div>
                    </div>
                    <div class="col-sm-6">             
                        <input type="hidden" name="adv_id" value="<?=$id?>" ng-init="form.adv_id = <?=$id?>" ng-model="form.adv_id">
                        <select class="form-control" name="transfer" ng-model="form.transfer_id" ng-change='getTransfer()'>
                            <?php foreach($transfer_list as $item){  ?>
                                <option value="<?=$item->transfer->id?>"><?=$item->transfer->name?></option>
                            <?php } ?>
                        </select>                        
                    </div>
                </div>
            </div>
            <style>
                .transfer_block{
                    width:500px;
                    height:200px;
                    position:relative;
                    border: 1px solid #dddddd;
                }
                .transfer_block .item{
                    position:absolute;
                    background: black;
                    height: 20px;
                    width: 20px;
                    cursor:pointer;
                }
                .transfer_block .item.selected{
                    background: green;
                }
            </style>
            <div class="transfer_block">
                <div ng-repeat="item in seats" class="item @{{item.reserved ? 'selected':''}}" ng-click="reservPlace($index,$event)" style="left:@{{item.x_pos*30}}px; top:@{{item.y_pos*30}}px"></div>                
            </div>
        </form>
        @if(!$reservations)
            <form action="" method="POST">
                <ul>
                    <li><input type="submit" value="Забронировать" name="add" class="btn btn-blue"></li>
                </ul>
            </form>
        @endif
    </div>
@endsection

