<style>
    #header{
        color: white;
        border-radius: 0px;
        padding:13px 40px 0px 30px;
        background: #27292c;
        height: 80px;
        margin:0px;
    }
    #header .logo{
        background:url('/images/logo.png');
        width:186px;
        height:48px;
    }
    
    #header #navbar li > a{
        font-weight:bolder;
        font-size:20px;
        color :white;
        background: transparent;
    }
    #header #navbar li > a:hover{
        color :#f4ae01;
        background: transparent;
    }
</style>
<nav class="navbar" id='header'>
    <div class="navbar-header">
        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand logo"></a>
    </div>
    <div class="navbar-collapse collapse" id="navbar">
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li class="dropdown">
                <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider" role="separator"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>
        </ul>
        
        <style>
             #header .navbar-right .name{
                 margin-top:9px;
                position:relative;
                display:inline-block;
                vertical-align: middle;
            }
            #header .navbar-right .name > a{
                color: white;
                display:block;
                background: black;
                padding:0px 20px;
                border-radius: 6px;
                text-align: center;
                padding-top:7px;
            }
            #header .navbar-right .name.open > a{
                border-radius: 6px 6px 0px 0px;
            }
            #header .navbar-right .name .dropdown-menu{
                background: black;
                border-radius: 6px 0px 6px 6px;
                width:240px;
                top:34px;
                left:-83px;
            }
            #header .navbar-right .name .dropdown-menu li{
            }
            #header .navbar-right .name .dropdown-menu li a{
                height: 40px;
                padding-top:10px;
                font-size: 14px;
                color: white;
            }
            #header .navbar-right .name .dropdown-menu li:hover a{
                background:#262626;
            }
        </style>
        
        <ul class="nav navbar-nav navbar-right">
            <?php if(Auth::check()){ ?>
                <li class="name">
                    <a href="" data-toggle="dropdown" aria-expanded="true"><?=Auth::user()->firstname?> <?=Auth::user()->lastname?> <div class="caret"></div></a>
                    <ul class="dropdown-menu">
                        <li><a href="/advertisement/list/">Объявления</a></li>
                        <li><a href="/reservation/list/">Бронирование</a></li>
                        <li><a href="/profile/">Профиль</a></li>
                        <li><a href="/logout/">Выход</a></li>
                    </ul>
                </li>
                <li><a href="/logout/">Выход</a></li>
            <?php }else{ ?>
                <li><a href="#" data-target="#loginModal" data-toggle="modal">Вход</a></li>
                <li><a href="/">Регистрация</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>

    <style>
        #loginModal .modal-dialog{
            width:400px;
        }
        #loginModal .label{
            color: black;
        }
    </style>
    <script>
        $('document').ready(function(){
            $('#loginModal form').submit(function(){
                var email = $('input[name=email]',this).val();
                var password = $('input[name=password]',this).val();
                
                $.ajax({
                    url:'/login',
                    type:'POST',
                    data:{email:email,password:password},
                    success:function(msg){
                        var json = JSON.parse(msg);
                        if(json.status == 'success'){
                            location.href = '/';
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title font-header"><p><strong>Авторизация</strong></p></h4>
                </div>

                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="label">Email:</div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Email" name='email'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="label">Пароль:</div>
                                </div>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" placeholder='Password' name='password'>
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

