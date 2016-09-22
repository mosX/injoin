@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Мои Объявления</div>
    
    
    <table class="table table-striped">
        <tbody>
            <?php foreach($data as $item){ ?>
                <tr>
                    <td>
                        <?=$item->advertisement->title?>
                    </td>
                    <td>
                        <?php foreach($item->advertisement->tags as $tag){ ?>
                            <?=Config::get('app.types')[$tag->tag_id]?>
                        <?php } ?>
                    </td>
                    <td>
                        <?=$item->date?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
@endsection