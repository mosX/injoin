@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Просмотр Объявления</div>

    <div class="row">
        <div class="col-sm-6">
            <form class="form" action="" method="GET">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="label">Категория</div>
                                </div>
                                <div class="col-sm-8">
                                    <select name="category" class="form-control">
                                        <option value="0">Все</option>
                                        <?php foreach(Config::get('app.types')  as $key=>$item){ ?>
                                            <option <?=Request::input('category') == $key ? 'selected':''?> value="<?=$key?>"><?=$item?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="submit" value="Фильтр" class="btn btn-blue">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
<style>
    .adv_element{
        position:relative;
        padding:5px;
        box-shadow: 0px 0px 5px rgba(0,0,0,0.5);
        text-align: center;
        width:220px;;
        display:inline-block;
        margin-bottom: 25px;
        margin-right:20px;
        height: 300px;
    }
    .adv_element:last-child{
        margin-right:0px;
    }
    .adv_element img{
        max-width:200px;
        width:auto;
    }
    .adv_element .cover{
        width:100%;
        border:2px solid black;
        display:table;
        height:200px;
    }
    
    .adv_element .cover .inner{
        width:100%;
        display:table-cell;
        vertical-align: middle;
    }
    .adv_element .category{
        font-size:12px;
        color: #555;
    }
    .adv_element .category span{
        font-size:12px;
        font-weight:bolder;
    }
    .adv_element .author{
        font-size:11px;
    }
    .adv_element .date{
        font-size:11px;
        color: #777;
    }
    .adv_element .signature{
        position:absolute;
        right:10px;
        bottom:5px;
    }
</style>
    <div class="well">
        <?php foreach($data as $item){ ?>
            <div class="adv_element">
                <a href="/advertisement/show/<?=$item->id?>/" class="cover">
                    <div class="inner">
                        <?php if($item->image){ ?>
                            <img align="middle" src="/assets/adv/<?=$item->user_id?>/<?=$item->id?>/thumb<?=$item->image->name?>">
                        <?php } ?>
                    </div>
                </a>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="category pull-left">Категория: 
                            <?php if($item->tags){ ?>
                                <?php foreach($item->tags as $tag){ ?>
                                    <span><?=Config::get('app.types')[$tag->tag_id]?></span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <a href="/advertisement/show/<?=$item->id?>/" class="title pull-left"><?=$item->title?></a>
                    </div>
                </div>
                <div class="signature text-right">
                    <a href="/profile/show/?id=<?=$item->user_id?>" class="author"><?=$item->user->firstname?> <?=$item->user->lastname?></a>
                    <div class="date"><?=$item->date?></div>
                </div>

            </div>
        <?php } ?>
    </div>
@endsection