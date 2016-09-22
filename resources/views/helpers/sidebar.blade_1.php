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

<div id="sidebar_wraper">
    <div id="sidebar">
        <div class="panel {{$rout == "profile.index" ? "active":""}}">
            <a href="/profile/">ПРОФИЛЬ</a>
        </div>
        
        <div class="panel active">
            <a class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#sidebar" href="#collapse1">Основные настройки<div class="caret"></div></a>
            
            <ul aria-expanded="false" id="collapse1" class="panel-collapse collapse in">
                <li class="active">
                    <a href="/account/internals/">Сотрудники</a>
                </li>
                <li class="">
                    <a href="/account/gateways/">Внешние Номера</a>
                </li>
                <li class="">
                    <a href="/groups/">Группы</a>
                </li>
                <li class="">
                    <a href="/inbound/">Распределение входящих звонков</a>
                </li>
                <li class="">
                    <a href="/outbound/">Распределение исходящих звонков</a>
                </li>
                <li class="">
                    <a href="/audio/">Голосовое приветствие</a>
                </li>
                <li class="">
                    <a href="/ivr/">IVR</a>
                </li>
                <li class="">
                    <a href="/account/stickers/">Stickers</a>
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