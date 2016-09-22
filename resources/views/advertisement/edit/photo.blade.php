@extends('layouts.online')
@section('title', 'Редактирование обяъвления')
@section('css')
    @parent
    <link type="text/css" rel="stylesheet" href="/css/fancybox/jquery.fancybox.css">
@endsection
@section('js')
    @parent
        <script type="text/javascript" src="/js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
@endsection

@section('content')
    <div class='page-heading'>Редактирование Фотографии</div>
    
    <style>
        .preview{
            display:table;
            margin:auto;
            width:200px;
            height:200px;
            background:#ddd;
            border:2px solid black;
            margin:10px 0px;
            box-sizing: initial;
        }
        .preview .image{
            display:table-cell;
            text-align: center;
            vertical-align: middle;
        }
        .preview img{
            max-width: 200px;
            max-height: 200px;
        }
        
        .form_block{
            text-align: center;
            width:200px;
            margin-left:20px;
        }
    </style>
    <script>
        function addError(error){
            $('.form_block .error').text(error);
        }
    </script>
    
    
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancybox").fancybox();
    });
</script>

<script>
     $('document').ready(function(){
       $('.photo_action').click(function(){
           var iframe = $('iframe.addphoto_frame')[0].contentDocument;
           
           $('#upload-form input[name=file]',iframe).click();
           return false;
       });
    });
    
</script>
<script>
    function addImage(file,file2){
        console.log(file);
        
        $('.images').append('<div class="item">'
                +'<div class="image_preview">'
                    +'<a class="fancybox" rel="group" href="'+file2+'"><img src="'+file+'"></a>'
                    //+'<img src="'+file+'">'
                +'</div>'
            +'</div>');
    }
</script>
    <div class="form_block">
        <div class="preview">
            <div class='image' style='width:100%;height:100%;'>
                <?php if(!$data){ ?>
                    <img src='/assets/adv/<?=Auth::user()->id?>/<?=$id?>/thumb{{$data->image->name}}'>
                <?php }else{ ?>
                    <img src='/images/noimage.jpg'>
                <?php } ?>
            </div>
        </div>
        
        <iframe width="0" height="0" class="addphoto_frame" src="/advertisement/edit/addphoto/{{$id}}/" style="display: none;"></iframe>
        <a href="" class="btn btn-blue photo_action" style="padding-top:4px;">Загрузить</a>
            
        <div class="error"></div>    
    </div>

    <style>
        .images{
            margin-top:20px;
        }
       
        
        .images .element img{
            
            vertical-align: middle;
            max-width:200px;
            max-height:200px;
        }
        
        .images .item{
            display:inline-block;
            border: 1px solid black;
            margin:0px 10px;
        }
    </style>
    <div class="images">
        <?php foreach($data->images as $item){ ?>
            <div class="item">
                <div class="image_preview">
                    <a class="fancybox" rel="group" href="/assets/adv/<?=$item->user_id?>/<?=$item->adv_id?>/<?=$item->name?>"><img src="/assets/adv/<?=$item->user_id?>/<?=$item->adv_id?>/thumb<?=$item->name?>"></a>
                </div>
            </div>
        <?php } ?>
    </div>
@endsection