@extends('layouts.online')
@section('title', 'Расположение мест в транспорте')

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
    <div class='page-heading'>Список созданного транспорта</div>
    <script>
        $('document').ready(function(){
            
            $('.transports').change(function(){
                var id = $('option:selected',this).val();
                console.log(id);
            });
        });
    </script>
    <div class="form-group">
        <select class="form-control transports">
            <option value="0">Транспорт</option>
            <?php foreach($data as $item){ ?>                
                <option value="<?=$item->id?>"><?=$item->name?></option>
            <?php } ?>
        </select>
    </div>
@endsection