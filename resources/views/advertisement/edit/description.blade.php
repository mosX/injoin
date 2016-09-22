@extends('layouts.online')
@section('title', 'Редактирование обяъвления')

@section('content')
    <div class='page-heading'>Настройки описания</div>
    
    <form action="" method="POST" class='form'>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <textarea class='form-control' name="full_description">{{$data->full_description}}</textarea>    
                </div>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type="submit" value="Сохранить" class='btn btn-blue'>
                </div>
            </div>
        </div>
    </form>
@endsection