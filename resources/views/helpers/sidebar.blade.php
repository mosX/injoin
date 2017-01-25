<style>
    #sidebar_wraper{
        display:table-cell;
        height:auto;
        vertical-align: top;
        background: #323840;
        border-right: 3px solid #13c6ec;
    }
    
    #sidebar{
        width:300px;
        min-height:300px;
        background:#212730 ;
        border-bottom: 1px solid #3a4454;
        z-index:2;
        padding:30px 0px 30px 40px;
    }
    
    #sidebar .panel{
        border:none;
        background:transparent;
        margin:0px;
        
        border-bottom: 1px solid #323840;
    }
    
    #sidebar .panel a{
        
        cursor:pointer;
        display:block;
        
        padding-left:20px;
        
        height:55px;
        width:100%;
        font-size:18px;
        padding-top:14px;
        color: white;
        font-weight:bolder;
        text-decoration: none;
        border-radius: 30px 0px 0px 30px;
    }
    
    #sidebar .panel.active > a,#sidebar .panel > a:hover{
        background: #13c6ec;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        position:relative;
        z-index: 10;
    }
    #sidebar .panel .panel-collapse li{
        padding-left:40px;
    }
    #sidebar .panel .panel-collapse a{
        background:none;
        height:auto;
        font-size:14px;
        line-height:18px;
        min-height:30px;
        background: #059dbd;
        padding:7px;
        padding-left:20px;
        margin-bottom:1px;
        position:relative;
    }
    #sidebar .panel .panel-collapse li.active a,#sidebar .panel .panel-collapse li a:hover{
        box-shadow: 0px 2px 5px rgba(0,0,0,0.5);
        background:#13c6ec;
        z-index: 9;
    }
</style>

<?php $rout = Route::currentRouteName()?>

<script>
    $('document').ready(function(){
        $('#sidebar_wraper #sidebar .panel').click(function(){
            $('#sidebar_wraper #sidebar .panel').removeClass('active');
            
            if($(this).attr('class').indexOf('active') == -1){
                $(this).addClass('active');
            }
        });
    });
    
</script>
<div id="sidebar_wraper">
    <div id="sidebar">
        <div class="panel {{explode('.',$rout)[0] == "profile" ? "active":""}}">
            <a class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#sidebar" href="#collapse1">ПРОФИЛЬ</a>
            
            <ul aria-expanded="false" id="collapse1" class="panel-collapse collapse {{explode('.',$rout)[0] == "profile" ? "in":""}}">
                <li class="{{$rout == "profile.index" ? "active":""}}">
                    <a href="/profile/">Просмотреть</a>
                </li>
                <li class="{{$rout == "profile.edit.common" ? "active":""}}">
                    <a href="/profile/edit/common/">Основное</a>
                </li>
                <li class="{{$rout == "profile.edit.personal" ? "active":""}}">
                    <a href="/profile/edit/personal/">Личные данные</a>
                </li>
                <!--<li class="{{$rout == "profile.edit.photo" ? "active":""}}">
                    <a href="/profile/edit/photo">Фотография</a>
                </li>-->
            </ul>
        </div>
        
        <?php if(explode('.',$rout)[0] == 'advertisement' && explode('.',$rout)[1] == 'edit'){ ?>
            <div class="panel active">
                <a class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#sidebar" href="#collapse2">ОБЪЯВЛЕНИЕ</a>

                <ul aria-expanded="false" id="collapse2" class="panel-collapse collapse in">
                    <li class="{{$rout == "advertisement.edit.common" ? "active":""}}">
                        <a href="/advertisement/edit/common/{{$id}}">Основные настройки</a>
                    </li>
                    <li class="{{$rout == "advertisement.edit.photo" ? "active":""}}">
                        <a href="/advertisement/edit/photo/{{$id}}">Настройка Фотографии</a>
                    </li>
                    <li class="{{$rout == "advertisement.edit.description" ? "active":""}}">
                        <a href="/advertisement/edit/description/{{$id}}">Настройка Описания</a>
                    </li>
                    <li class="{{$rout == "advertisement.edit.address" ? "active":""}}">
                        <a href="/advertisement/edit/address/{{$id}}">Настройка Располажения</a>
                    </li>
                    <li class="{{$rout == "advertisement.edit.transfer" ? "active":""}}">
                        <a href="/advertisement/edit/transfer/{{$id}}">Трансфер</a>
                    </li>
                    <li class="{{$rout == "advertisement.edit.advanced" ? "active":""}}">
                        <a href="/advertisement/edit/advanced/{{$id}}">Продвинутые Настройки</a>
                    </li>
                </ul>
            </div>
        <?php } ?>
        <div class="panel {{$rout == "advertisement.search" ? "active":""}}">
            <a href="/advertisement/search/">ПОИСК</a>
        </div>
        
        <div class="panel {{$rout == "transfer.create" ? "active":""}}">
            <a  data-toggle="collapse" data-parent="#sidebar" href="#collapse2">ТРАНСПОРТ</a>
            
            <ul aria-expanded="false" id="collapse2" class="panel-collapse collapse {{explode('.',$rout)[0] == "transfer" ? "in":""}}">
                <li class="{{$rout == "transfer.create" ? "active":""}}">
                    <a href="/transfer/create/">Создать транспорт</a>
                </li>
                <li class="{{$rout == "transfer.list" ? "active":""}}">
                    <a href="/transfer/view/">Мой транспорт</a>
                </li>
            </ul>
        </div>
        
        <div class="panel {{$rout == "advertisement.create" ? "active":""}}">
            <a href="/advertisement/create/">СОЗДАТЬ ОБЪЯВЛЕНИЕ</a>
        </div>

        <div class="panel {{$rout == "advertisement.index" ? "active":""}}">
            <a href="/advertisement/">ПРОСМОТРЕТЬ ОБЪЯВЛЕНИЯ</a>
        </div>

        <div class="panel {{$rout == "reservation.index" ? "active":""}}">
            <a href="/reservation/">БРОНИРОВАНИЯ</a>
        </div>
    </div>
</div>