@extends('layouts.online')
@section('title', 'Редактирование обяъвления')

@section('content')
    <div class='page-heading'>Продвинутые настройки</div>
    
    <form action='' method='POST' class='form'>
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <label>С Подтверждением</label>
                    <input type="checkbox" value="1" name="with_moderation">
                </div>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='row'>
                <div class='col-sm-12'>
                    <input type='submit' value='Сохранить' class='btn btn-blue'>
                </div>
            </div>
        </div>
    </form>
@endsection