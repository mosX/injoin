@extends('layouts.online')
@section('title', 'Редактирование обяъвления')

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
    <div class='page-heading'>Редактирование Объявления</div>
    
    <form action="" method="POST" class='form well'>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class='label'>Заголовок</div>
                </div>
                <div class='col-sm-12'>
                    <input type='text' value="{{$data->title}}" class='form-control' name="title">
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class='label'>Короткое описание</div>
                </div>
                <div class='col-sm-12'>
                    <textarea class='form-control' name="description">{{$data->description}}</textarea>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class='label'>Тип</div>
                </div>
                <div class='col-sm-12'>
                    <select class='form-control' name="type">
                        <option value="0">Выберите Тип</option>
                        @foreach($types as $key=>$item)
                            <option <?=$data->type == $key ? 'selected=selected':''?> value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class='label'>Максимальное Количество Участников</div>
                </div>
                <div class='col-sm-12'>
                    <input type='text' class='form-control' name="max_members" value="{{$data->max_members}}">
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
                                <input type='text' class="form-control" name="start_date" value="{{$data->start_date}}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class='input-group date timepicker'>
                                <input type='text' class="form-control" name="start_time" value="{{$data->start_date}}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="error"></div>
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
                                <input type='text' class="form-control" name="end_date" value="{{$data->end_date}}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class='input-group date timepicker'>
                                <input type='text' class="form-control" name="end_time" value="{{$data->end_date}}"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                            <div class="error"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            $(function(){
                $('.datepicker').datetimepicker({
                    locale: 'ru',
                    format: 'YYYY-MM-DD'
                    //sideBySide: true
                });
                
                $('.timepicker').datetimepicker({
                    format: 'HH:mm'
                });
            });
        </script>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type='submit' class='btn btn-blue' value="Изменить">
                </div>
            </div>
        </div>
    </form>
@endsection