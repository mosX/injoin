@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Список Бронирований</div>
    
    @if($data)
        <table class="table">
            @foreach($data as $item)
                <tr>
                    <td>
                        <div class="image_preview">
                            @if($item->advertisement->image)
                                <img src="/assets/adv/{{$item->author_id}}/{{$item->adv_id}}/thumb{{$item->advertisement->image->name}}">
                            @endif
                        </div>
                    </td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->date}}</td>
                    <td>
                        @if($item->moderation == 0)
                            <span style="color:red;">ожидает подтверждения</span>
                            <div class="approve status_btn">Подтвердить</div>
                        @else
                            <span style="color:green;">подтверждено</span>
                            <div class="cancel status_btn">Отменить</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection