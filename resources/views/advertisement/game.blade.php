@extends('layouts.game')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Объявления</div>
    <style>
        canvas{
            border: 1px solid black;
        }
    </style>    
       
    <script>           
        app.service('vector',function(){
            this.checkDotAccessory = function(line,dot){  //проверяет или точка пренадлежит отрезку  
                var result = Math.abs(
                        Math.sqrt(Math.pow(line.x1-dot.x,2)+Math.pow(line.y1-dot.y,2)) + Math.sqrt(Math.pow(line.x2-dot.x,2)+Math.pow(line.y2-dot.y,2)) - Math.sqrt(Math.pow(line.x2-line.x1,2)+Math.pow(line.y2-line.y1,2))
                        );
                
                return result == 0;
            };
            
            this.degToRad = function(deg){
                var rad = deg * (Math.PI / 180);
                
                return rad;
            };
            
            this.radToDeg = function(rad){
                var deg = rad * (180/Math.PI);
                
                return deg;
            };
            
            this.segmentToVector = function(A,B){
                var obj = {}; 
                obj.x = B.x - A.x;
                obj.y = B.y - A.y;
                
                return obj;
            };
            
            this.length = function(A,B){   //получаем длинну отрезка
                var vector = this.segmentToVector(A,B);
                
                var length = this.module(vector);
                
                return length;
            };
            
            this.module = function(vector){
                var module = Math.sqrt( Math.pow(vector.x,2) + Math.pow(vector.y,2) );
                
                return module;
            }
            
            this.setLength = function(A,B,len){        //получает координаты вектора с заданной длинной. нужно приплюсовать к начальной точке
                var coord = this.segmentToVector(A,B);
                
                var length = this.module(coord);
                
                coord.x = coord.x / length * len;
                coord.y = coord.y / length * len;
                
                return coord;
            }
            
            this.scalar = function(vector1,vector2){    ///находим скалярное произведение
                var scal = vector1.x * vector2.x + vector1.y * vector2.y;
                return scal;
            }
            
            this.getAngle = function(segment1,segment2){
                var vector1 = this.segmentToVector(segment1.A,segment1.B);
                var vector2 = this.segmentToVector(segment2.A,segment2.B);
                
                //находим скалярное произведение
                var scal = this.scalar(vector1,vector2);
                
                //найдем модуль векторов
                var length1 = this.module(vector1);
                var length2 = this.module(vector2);
                
                var angle = ( scal / (length1*length2) );
                                
                return Math.asin(angle);
            }
            
            this.proection = function(segment1, segment2){
                var vector1 = this.segmentToVector(segment1.A,segment1.B);
                var vector2 = this.segmentToVector(segment2.A,segment2.B);
                                
                var scalar = this.scalar(vector1,vector2);
                
                var length = this.module(vector2);
                
                var proection = scalar / length; 
                
                return proection;
            }
            
            this.findCrossing = function(segment1,segment2){
                var v1 = this.segmentToVector(segment1.A,segment1.B);
                var v2 = this.segmentToVector(segment2.A,segment2.B);
                                
                var x = v1.y * v2.x - v2.y * v1.x;

                if(!x || !v2.x){
                    console.log('Перпендекулярны');
                    return {x:segment2.A.x ,y:segment1.A.y};
                }

                var y = segment2.A.x * segment2.B.y - segment2.A.y * segment2.B.x;
                x = ((segment1.A.x * segment1.B.y - segment1.A.y * segment1.B.x) * v2.x - y * v1.x) / x;
                y = (v2.y * x - y) / v2.x;

                if (((segment1.A.x <= x && segment1.B.x >= x) || (segment1.B.x <= x && segment1.A.x >= x)) && ((segment2.A.x <= x && segment2.B.x >= x) || (segment2.B.x <= x && segment2.A.x >= x))){
                    return {x:x,y:y};
                }else{
                    return false;
                }
            }
        });
        
    
    </script>
    
    <script>
        app.controller('gameCtrl', function($scope,vector){
            $scope.initCanvas = function(){
                $scope.ws = $('#canvas')[0];
                $scope.ctx = $scope.ws.getContext('2d');

                $scope.width = $scope.ws.width;
                $scope.height = $scope.ws.height;    
            };
            
            $scope.buildBlocks = function(){
                for(var key in $scope.blocks){
                    //console.log($scope.blocks[key]);
                    $scope.ctx.save();
                        $scope.ctx.beginPath();
                            $scope.ctx.fillStyle = $scope.blocks[key].bg;
                            $scope.ctx.strokeStyle = 'black';
                            
                            $scope.ctx.rect(
                                    $scope.blocks[key].x+0.5 + $scope.map.x,
                                    $scope.blocks[key].y+0.5 + $scope.map.y,
                                    $scope.blocks[key].width,
                                    $scope.blocks[key].height
                                    );
                        $scope.ctx.closePath();
                        $scope.ctx.fill();
                        $scope.ctx.stroke();
                    $scope.ctx.restore();  
                }
            }
            
            $scope.moveLeft = function(el){
                $scope.blocks[el].x -=5;
                $scope.checkCollision($scope.player,-5,0);
                
                if($scope.blocks[el].x + $scope.map.x < $scope.ws.width / 2 - $scope.blocks[el].width/2){
                    $scope.map.x += 5;
                }
            }
            
            $scope.moveUp = function(el){
                ///if($scope.playerFalling == true) return;
                
                $scope.blocks[el].y -=10;
                var check_y = $scope.blocks[el].y;
                $scope.jumpHeight -= 10;
                $scope.checkCollision($scope.player,0,-10);
                
                if($scope.jumpHeight <=0){
                    clearInterval($scope.jumpInterval);
                    $scope.jumpInterval = null;
                    $scope.jumpHeight = 100;
                }
                
                if(el == $scope.player){    //ставим статус падает или нет
                    if(check_y != $scope.blocks[el].y){
                        //console.log('TOP');
                        clearInterval($scope.jumpInterval);
                        $scope.jumpInterval = null;
                    }
                }   
            }
            
            $scope.moveRight = function(el){
                $scope.blocks[el].x +=5;
                $scope.checkCollision($scope.player,5,0);
                //console.log($scope.blocks[el].x + ' - ' + $scope.ws.width);
                
                if($scope.blocks[el].x + $scope.map.x >= $scope.ws.width / 2 - $scope.blocks[el].width/2){
                    $scope.map.x -= 5;
                }
            }
            
            $scope.moveDown = function(el){
                $scope.blocks[el].y +=5;
                
                var check_y = $scope.blocks[el].y;
                $scope.checkCollision(el,0,5);
                               
                if(el == $scope.player){    //ставим статус падает или нет
                    if(check_y != $scope.blocks[el].y){
                        $scope.playerFalling = false;
                    }else{
                        $scope.playerFalling = true;
                        
                    }
                }   
            }
            
            $scope.render = function(){
                $scope.ctx.clearRect(0,0,$scope.ws.width,$scope.ws.height);
                               
                $scope.buildBlocks();     
            }
            
            $scope.pushObject = function(key,x,y){
                $scope.blocks[key].x += x;
                $scope.blocks[key].y += y;
                
                var start_x = $scope.blocks[key].x;
                //var end_x = $scope.blocks[key].x;
                
                $scope.checkCollision(key,x,y); //проверяем столкновение для блока который двигаем
                
                if($scope.blocks[key].x != start_x) return false;
                return true;
            }
            
            $scope.checkCollision = function(el,x,y){
                for(var key in $scope.blocks){
                    if(el == key) continue;
                    if($scope.initCollision(el,key) == true){
                        if($scope.blocks[key].static == false && y == 0){   //для горизонтального движения
                            if($scope.pushObject(key,x,y) == false){ //если не передвинулся то двигаем предыдущий назад
                                $scope.blocks[el].x -= x;
                                $scope.blocks[el].y -= y;
                            }
                        }else{
                            $scope.blocks[el].x -= x;
                            $scope.blocks[el].y -= y;
                        }

                        $scope.initCollision(el,key);   //перепроверить для ДЕБАГА
                    }
                }
                
            }
            
            $scope.initCollision = function(first,second){
                var first = $scope.blocks[first];
                var second = $scope.blocks[second];
                
                var ax1 = first.x;
                var ax2 = first.x + first.width;
                var ay1 = first.y;
                var ay2 = first.y + first.height;
                
                var bx1 = second.x;
                var bx2 = second.x + second.width;
                var by1 = second.y;
                var by2 = second.y + second.height;
                
                var checkX = true;
                var checkY = true;
               
                //Проверяем горизонталь
                if(checkX && ax1 >= bx1 && ax2 <= bx2 ){    //внутри первый блок
                    //console.log(first);
                    checkX = false;
                }
                
                if(checkX && bx1 >= ax1 && bx2 <= ax2 ){    //внутри второй блок
                    checkX = false;
                }
                
                if( checkX &&  bx1 > ax1 && bx1 < ax2){   //справа
                    checkX = false;
                }
                
                if( checkX && bx2 > ax1 && bx2 < ax2 && bx1 < ax1){    //слева
                    checkX = false;
                }
                
                //Проверяем вертикаль
                if(checkY && ay1 >= by1 && ay2 <= by2 ){    //внутри первый блок
                    checkY = false;
                }
                
                if(checkY && by1 >= ay1 && by2 <= ay2 ){    //внутри второй блок
                    checkY = false;
                }
                
                if( checkY &&  by1 > ay1 && by1 < ay2){ //снизу
                    checkY = false;
                }
                
                if( checkY && by2 > ay1 && by2 < ay2){
                    checkY = false;
                }
             
                return (!checkX && !checkY);
            }
            
            $scope.gravity = function(){
                setInterval(function(){
                    for(var key in $scope.blocks){
                        if($scope.blocks[key].static == true) continue;  //если объект статичный
                        
                        $scope.moveDown(key);
                        $scope.render();
                    }
                },$scope.frames);
            };
            $scope.frames = 1000/60;
            
            $scope.playerFalling = false;
            
            $scope.player = 1;
            
            $scope.map = {};
            $scope.map.x = 0;
            $scope.map.y = 0;
            
            //создаем объект с елементами
           $scope.blocks = {
               1:{x:50,y:240,width:50,height:50,bg:'red',static:false},
               8:{x:50,y:170,width:50,height:50,bg:'purple',static:true},
               2:{x:10,y:290,width:200,height:50,bg:'grey',static:true},
               5:{x:230,y:400,width:200,height:50,bg:'blue',static:true},
               6:{x:450,y:400,width:200,height:50,bg:'grey',static:true},
               7:{x:670,y:400,width:200,height:50,bg:'silver',static:true},
               3:{x:105,y:100,width:30,height:60,bg:'green',static:false},
               4:{x:145,y:200,width:30,height:60,bg:'grey',static:false},
            }
           
            $scope.gravity();
            $scope.initCanvas();
                      
            $scope.render();
           
            $scope.actions = {};
           
            $scope.moveRightInterval = null;
            $scope.moveLeftInterval = null;

            $scope.jumpHeight = 200;    //высота с учетом того что действует гравитация
            $scope.jumpInterval = null;
           
            $('body').keyup(function(e){
                switch(e.keyCode){
                    case 37:
                         clearInterval($scope.moveLeftInterval);
                         $scope.moveLeftInterval = null;
                         break;
                    case 39:
                         clearInterval($scope.moveRightInterval);
                         $scope.moveRightInterval = null;
                         break;
                }
            });
           
            $('body').keydown(function(e){
                switch(e.keyCode){
                    case 37:
                        if($scope.moveLeftInterval == null){
                            $scope.moveLeftInterval = setInterval(function(){
                                $scope.moveLeft($scope.player);
                                $scope.render();
                            },$scope.frames);
                        }
                        break;
                    case 38: 
                        if($scope.playerFalling == false && $scope.jumpInterval == null){
                        //if($scope.jumpInterval == null){
                            //console.log($scope.jumpInterval);
                            $scope.jumpInterval = setInterval(function(){
                                $scope.moveUp($scope.player);        
                                $scope.render();
                            },$scope.frames);
                        }
                        break;
                    case 39: 
                        if($scope.moveRightInterval == null){
                            $scope.moveRightInterval = setInterval(function(){
                                $scope.moveRight($scope.player);
                                
                                $scope.render(); 
                            },$scope.frames);
                        }
                        break;
                    case 40: 
                        $scope.moveDown($scope.player);
                        $scope.render(); 
                        break;
                }
            });
           
           //console.log($scope.blocks);
        });
    </script>
           
    
    <div ng-controller="gameCtrl">
        <canvas id="canvas" width="900" height="500"></canvas>
    </div>
        
@endsection