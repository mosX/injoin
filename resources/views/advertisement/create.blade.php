@extends('layouts.online')
@section('title', 'Создание обяъвления')

<?php //p($errors->first('title'))?>

@section('content')
    @section('css')
        @parent
        <link type="text/css" rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
    @endsection

    @section('js')
        @parent
            <script type="text/javascript" src="/js/moment.js"></script>
            <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
    @endsection
    <div class='page-heading'>Создание Объявления</div>
    
    <?php //p($login_error) ?>    
    
    <form action="" method="POST" class='form well'>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Заголовок</div>
                </div>
                <div class='col-sm-9'>
                    <input type='text' class='form-control' name="title" value="<?=$post ? $post->title:''?>">
                    <div class="error"><?=$errors ? $errors->first('title'):''?></div>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Короткое описание</div>
                </div>
                <div class='col-sm-9'>
                    <textarea class='form-control' name="description"><?=$post ? $post->description:''?></textarea>
                    <div class="error"><?=$errors ? $errors->first('description'):''?></div>
                </div>
            </div>
        </div>
        <style>
            .type_selectors select{
                margin-bottom:10px;
            }
        </style>
        <script>
            $('document').ready(function(){
                $('.add_type').click(function(){
                    
                    var select = $('.type_selectors select').eq(0).clone();
                    $('option',select).eq(0).attr('selected','selected');
                    $('.type_selectors').append(select);
                    return false;
                });
            });
        </script>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Тип</div>
                </div>
                <div class='col-sm-9'>
                    <div class="type_selectors">
                        <?php if($post && $post->type){ ?>
                            <?php foreach($post->type as $type){ ?>
                                <?php if(!$type) continue ?>
                                <select class='form-control' name="type[]">
                                    <option value="0">Выберите Тип</option>
                                    @foreach($types as $key=>$item)
                                        <option <?=$type == $key? 'selected="selected"':''?> value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            <?php } ?>
                        <?php }else{ ?>
                            <select class='form-control' name="type[]">
                                <option value="0">Выберите Тип</option>
                                @foreach($types as $key=>$item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        <?php } ?>
                    </div>
                    <a href="" class="btn btn-blue pull-right add_type">Добавить</a>
                    <div class="error"><?=$errors ? $errors->first('type'):''?></div>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Максимальное Количество Участников</div>
                </div>
                <div class='col-sm-9'>
                    <input type='text' class='form-control' name="max_members" value="<?=$post ? $post->max_members:''?>">
                    <div class="error"><?=$errors ? $errors->first('max_members'):''?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <div class="label">Начало</div>
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class='input-group date datepicker'>
                                <input type='text' class="form-control" name="start_date" value="<?=$post ? $post->start_date:''?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="error"><?=$errors ? $errors->first('start_date'):''?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class='input-group date timepicker'>
                                <input type='text' class="form-control" name="start_time" value="<?=$post ? $post->start_time:''?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="error"><?=$errors ? $errors->first('start_time'):''?></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <div class="label">Окончание</div>
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class='input-group date datepicker'>
                                <input type='text' class="form-control" name="end_date" value="<?=$post ? $post->end_date:''?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="error"><?=$errors ? $errors->first('end_date'):''?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class='input-group date timepicker'>
                                <input type='text' class="form-control" name="end_time" value="<?=$post ? $post->end_time:''?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="error"><?=$errors ? $errors->first('end_time'):''?></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type='submit' class='btn btn-blue'>
                </div>
            </div>
        </div>
        
        <script>
            $(function(){
                $('.datepicker').datetimepicker({
                    locale: 'ru',
                    format: 'DD-MM-YYYY'
                    //sideBySide: true
                });
                
                $('.timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
        </script>
    </form>
@endsection