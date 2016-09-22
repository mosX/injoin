@extends('layouts.online')
@section('title', 'Просмотреть Брони')

@section('content')
<script>
    $('document').ready(function(){
        $('.confirm_reserv').click(function(){
            var id = parseInt($(this).attr('data-id'));
            
            $.ajax({
                url:'/reservation/confirm/'+id,
                type:'GET',
                success:function(msg){
                    var json = JSON.parse(msg);
                    if(json.status == 'success'){
                        location.href = location.href;
                    }
                }
            });
            return false;
        });
    });
</script>
    <div class='page-heading'>Бронирования</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Подтверждение</th>
                <th>Создано</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td><?=$item->user->firstname?> <?=$item->user->lastname?></td>
                <td>
                    <?php if(!$item->moderation){ ?>
                        <a href="" class="btn btn-primary confirm_reserv" data-id="<?=$item->id?>">Ожидает подтверждения</a>
                    <?php } ?>                    
                </td>
                <td><?=$item->date?></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection