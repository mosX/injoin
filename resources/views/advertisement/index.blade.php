@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Объявления</div>
    <script>
        app.directive('activityBtn', function (){
            return function(scope,element,attrs){
                $('input',element).click(function(){
                    //sconsole.log('test');
                    var id = attrs.activityBtn;
                    
                    $.ajax({
                        url:"/advertisement/"+id,
                        type:'POST',
                        dataType:'JSON',
                        success:function(json){
                            if(json.status == 'success'){
                                if(json.active == 1){
                                    $('.active',element).removeClass('hidden');
                                    $('.unactive',element).addClass('hidden');
                                }else{
                                    $('.active',element).addClass('hidden');
                                    $('.unactive',element).removeClass('hidden');
                                }
                            }
                        }
                    });
                    return false;
                });
            }
        });

        app.controller('CourseListCtrl',function($scope){
            
        });
    </script>
    <style>
        .red{
            color: red;
        }
        
        .green{
            color: green;
        }
    </style>
    <div ng-controller="CourseListCtrl">
        <table class="table">
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>
                            <div class="image_preview">
                                @if($item->image)
                                    <img src="/assets/adv/{{Auth::user()->id}}/{{$item->id}}/{{$item->image->name}}">
                                @else
                                    <img src="/images/noimage.jpg">
                                @endif
                            </div>
                        </td>

                        <td>
                            {{$item->title}}
                            <ul>
                                <li><a href="/advertisement/edit/common/{{$item->id}}/">Редактировать объявление</a></li>
                                <li><a href="/advertisement/show/{{$item->id}}/">Просмотреть объявление</a></li>
                                <li><a href="/reservation/show/{{$item->id}}/">Просмотреть бронирования</a></li>
                            </ul>
                        </td>
                        <td>
                            <span class="{{strtotime($item->start_date) > time() ? 'red':'green' }}">{{date("Y-m-d H:i:s",strtotime($item->start_date))}}</span> - 
                            <span class="{{strtotime($item->end_date) < time() ? 'red':'green' }}">{{$item->end_date}}</span>
                        </td>
                        <td activity-btn="{{$item->id}}">
                            @if($item->moderation)
                                <input type="button" class="btn btn-green active {{!$item->active ? 'hidden':''}}" value="Выключить">
                                <input type="button" class="btn btn-red unactive {{$item->active ? 'hidden':''}}" value="Включить">
                            @else
                                <span style="color: red; font-weight:bolder;">На модерации</span>
                            @endif
                        </td>
                        <td>{{date('Y-m-d H:i:s',strtotime($item->date))}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>  
    </div>
@endsection