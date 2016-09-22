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
    <div class='page-heading'>Создание Трансфера</div>
        
    <form action="" method="POST" class='form well'>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Название</div>
                </div>
                <div class='col-sm-9'>
                    <input type='text' class='form-control' name="name" value="<?=$post ? $post->title:''?>">
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
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-3'>
                    <div class='label'>Тип</div>
                </div>
                <div class='col-sm-9'>
                    <div class="type_selectors">
                        <select class='form-control' name="type">
                            <option value="0">Выберите Тип</option>
                            <?php foreach(Config::get('custom.transfers') as $key=>$item){ ?>
                                <option value="<?=$key?>"><?=$item?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="error"><?=$errors ? $errors->first('type'):''?></div>
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
    </form>
@endsection