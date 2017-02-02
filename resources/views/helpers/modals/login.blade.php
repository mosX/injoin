<style>
    #loginModal .modal-dialog{
        width:400px;
    }
    #loginModal .label{
        color: black;
    }
</style>

<script>        
    app.controller('loginCtrl', function($scope,$http){
        $scope.login = function($event){
            $.ajax({
                url:'/login',
                type:'POST',
                data:{email:$scope.email,password:$scope.password},
                success:function(msg){
                    var json = JSON.parse(msg);
                    if(json.status == 'success'){
                        location.href = '/';
                    }
                }
            });
            $event.preventDefault();
        }
    });
</script>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" ng-controller="loginCtrl">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title font-header"><p><strong>Авторизация</strong></p></h4>
            </div>

            <div class="modal-body">
                <form action="/test" method="POST" ng-submit="login($event)" novalidate>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Email:</div>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Email" name='email' ng-model="email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Пароль:</div>
                            </div>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" placeholder='Password' name='password' ng-model="password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-blue" value="Войти">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>