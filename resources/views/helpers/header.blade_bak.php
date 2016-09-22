  <script>
    $('document').ready(function(){
        $('.login_start').click(function(){
            $('#login_modal').css({'display':'block'});
            return false;
        });

        $('.registration_start').click(function(){
            $('#registration_modal').css({'display':'block'});
            return false;
        });
    });
</script>

<style>
    #header .panel .user_block {
        display:inline-block;
        font-weight:bolder;
        font-size:22px;
        margin:0px 10px;
        position:relative;
    }

    #header .panel .user .icon{
        background: url('/images/user_icon.png');
        width:35px;
        height:35px;
        display: inline-block;
        vertical-align: middle;
        margin-right:10px;
    }
    #header .panel .user_block .menu_block{
        z-index: 1000;
        position:absolute;
        top:0px;
    }
    #header .panel .user_block .menu{
        display:none;
        padding:10px 0px;
        border-bottom:2px solid white;
        position:relative;
        background: black;
        min-width:150px;
        top:55px;
    }
    #header .panel .user_block:hover .menu{
        display:block;
    }
    #header .panel .user_block .menu li{
        height:30px;
    }
    #header .panel .user_block .menu li.active a,#header .panel .user_block .menu li:hover a{
        border-left:3px solid white;
    }
    #header .panel .user_block .menu a{
        padding-top:6px;
        border-left:3px solid transparent;
        padding-left:10px;
        margin:0px;
        font-size: 14px;
        width:100%;
        height:100%;
    }
</style>

<div id="header">
    <a href="/" class="logo"></a>
    <div class='panel'>
        <a href='' class='login_start'>Вход</a>
        <a href='' class='registration_start'>Регистрация</a>
        <a href='/advertisement/create/' class='btn'>Создать Объявление</a>
    </div>
</div>