@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Регистрация на Событие</div>
    
    <div class="inner">
        @if($reservations)
            <div class="error">Вы уже создали заявку на это событие</div>
        @endif

        @if($data->with_moderation)
            <div class="notification">Данное Объявление требует Подтверждения владельца .</div>
        @endif

        <p>Если вы согласны с условиями и выполнили все действия указанные автором события то нажмите на "Забронировать"</p>
        @if(!$reservations)
            <form action="" method="POST">
                <ul>
                    <li><input type="submit" value="Забронировать" name="add" class="btn btn-blue"></li>
                </ul>
            </form>
        @endif
    </div>
@endsection

