<style>
    #loginModal .modal-dialog{
        width:400px;
    }
    #loginModal .label{
        color: black;
    }
</style>

<script>        
    app.controller('registrationCtrl', function($scope,$http){
        $('#registrationModal').modal('show');        
        $scope.form = {};
        $scope.submit = function($event){                        
            var req = {
                url: '/registration',
                method: 'POST',
                data: $scope.form,
                responseType: 'text',
            };
            $http(req).then(function(ret){                
                if(ret.data.status == 'success'){
                
                }else{
                    
                }
            });
            
            $event.preventDefault();
            //$event.defaultPrevented();
        }        
    });
</script>
<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" ng-controller="registrationCtrl">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title font-header"><p><strong>Регистрация</strong></p></h4>
            </div>

            <div class="modal-body">
                <form action="" method="POST" ng-submit="submit($event)">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Имя:</div>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Имя" name='firstname' ng-model="form.firstname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Фамилия:</div>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Фамилия" name='lastname' ng-model="form.lastname">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Email:</div>
                            </div>

                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="Email" name='email' ng-model="form.email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Пароль:</div>
                            </div>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" placeholder='Password' name='password' ng-model="form.password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="label">Повторить пароль:</div>
                            </div>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" placeholder='Password' name='conf_password' ng-model="form.conf_password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-blue" value="Зарегистрировать">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>