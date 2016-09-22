@extends('layouts.online')
@section('title', 'Редактирование обяъвления')

@section('content')
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
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type='submit' class='btn btn-blue' value="Изменить">
                </div>
            </div>
        </div>
    </form>
@endsection