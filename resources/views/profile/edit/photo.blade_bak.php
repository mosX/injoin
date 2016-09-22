@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Редактировать профиль</div>
    
    <style>
    .preview{
        display:block;
        margin:auto;
        width:200px;
        height:200px;
        background:#ddd;
        border:2px solid black;
        margin:10px 0px;    
        box-sizing: initial;
    }
    
    .preview .table{
        width:100%;
        height:100%;
    }
    
    .preview .cell{
        width:100%;
        height:100%;
        vertical-align: middle;
        text-align: center;
    }
    
    .preview img{
        max-width: 200px;
        max-height:200px;
    }
    .uploadFileBtn{
        display:block;
        width:100%;
        
        
    }
    .form_block{
        display:block;
        width:200px;
        margin-left:20px;
        margin-bottom:10px;
        
    }
</style>
<script>
    function addImage(file){
        $('.preview img').attr('src',file);
    }
</script>
<div class='pagetitle'>Добавление Фотографий</div>
<div class="form_block">
    <div class="preview">
        <div class="table">
            <div class="cell">
                <img src="<?=Auth::user()->ava ? '/assets/users/'.Auth::user()->id.'/'.Auth::user()->ava:'/images/noava.png'?>">
            </div>
        </div>
    </div>

    <div class="uploadFileBtn">Загрузить
        <iframe id="hiddenIframeUpload" src="/profile/edit/saveava/"></iframe>
    </div>    
</div>

@endsection