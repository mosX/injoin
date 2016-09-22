@extends('layouts.main')
@section('title', 'InJoin')

@section('content')
    <style>
        .mainpreview{
            width:100%;
        }
        .mainpreview .element{
            background-position: center center;
            margin:10px 5px;
            width:100%;
            height:300px;
            display:inline-block;
            vertical-align: top;
            position:relative;
            text-align: center;
        }
        .mainpreview .element span{
            margin-top:250px;
            position:relative;
            bottom:0px;
            display:inline-block;
            padding:10px 15px;
            border-radius: 7px 7px 0px 0px;
            font-size:24px;
            background:rgba(255,255,255,0.7);
        }
        /*.mainpreview .element.small{
            width:475px;
        }
        .mainpreview .element.big{
            width:700px;
        }*/
        .search_btn{
            width:300px;
            margin:20px auto;
            text-align: center;
            font-weight:bolder;
            cursor:pointer;
            color: white;
            display:block;
            padding:10px 20px;
            background:#0065a6;
        }
    </style>

    <div class='container'>
        <a href="/advertisement/search/" class="search_btn">ПОИСК ОБЪЯВЛЕНИЙ</a>
        
        <div class="row mainpreview">
            <div class="col-sm-7">
                <div class="element" style="background-image:url('/images/main/image1.jpg')"><span>Шацкие озера</span></div>    
            </div>
            <div class="col-sm-5">
                <div class="element small" style="background-image:url('/images/main/image2.jpg')"><span>Камянец подольский</span></div>    
            </div>
            
            <div class="col-sm-5">
                <div class="element small" style="background-image:url('/images/main/image3.jpg')"><span>Почаев</span></div>
            </div>
            <div class="col-sm-7">
                <div class="element big" style="background-image:url('/images/main/image4.jpg')"><span>Каток</span></div>
            </div>
            
            <div class="col-sm-7">
                <div class="element big" style="background-image:url('/images/main/image5.jpg')"><span>Октобер Фест</span></div>
            </div>
            <div class="col-sm-5">
                <div class="element small" style="background-image:url('/images/main/image6.jpg')"><span>Картинг</span></div>
            </div>
            
            <div class="col-sm-5">
                <div class="element small" style="background-image:url('/images/main/image7.jpg')"><span>Поход в Кинотеатр</span></div>
            </div>
            <div class="col-sm-7">
                <div class="element big" style="background-image:url('/images/main/image8.jpg')"><span>Велопрогулки</span></div>
            </div>
        </div>        
        
    </div>
@endsection