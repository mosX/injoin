@extends('layouts.online')
@section('title', 'Создание обяъвления')

@section('content')
    <div class='page-heading'>Объявления</div>
    <style>
        canvas{
            border: 1px solid black;
        }
    </style>
    
    <script>
        app.controller('firstCtrl', function($scope){
            $scope.ws = $('#first')[0];
            $scope.ctx = $scope.ws.getContext('2d');

            $scope.width = $scope.ws.width;
            $scope.height = $scope.ws.height;
            
            $scope.activeBlock = 2;
            
            $scope.collision = {};
            
            $scope.blocks = {
                1:{x:50,y:100,width:100,height:50,projection:'blue',dist:20.5},
                2:{x:150,y:140,width:50,height:50,projection:'red',dist:25.5},
                3:{x:240,y:160,width:50,height:50,projection:'orange',dist:30.5}
            };
            
            $scope.player = $scope.blocks[$scope.activeBlock];
           
            $scope.moveLeft = function(){
                $scope.player.x -= 5;
                $scope.checkCollision(-5,0);
            }
            
            $scope.moveUp = function(){
                $scope.player.y -= 5;
                $scope.checkCollision(0,-5);
            }
            
            $scope.moveRight = function(){
                $scope.player.x += 5;
                $scope.checkCollision(5,0);
            }
            
            $scope.moveDown = function(){
                $scope.player.y += 5;
                $scope.checkCollision(0,5);
            }
            $scope.debug = {};
            $scope.debug.collision = function(){
                for(var key in $scope.collision){
                    $scope.ctx.save();
                        $scope.ctx.lineWidth = 1.5;
                        $scope.ctx.strokeStyle = 'green';

                        $scope.ctx.beginPath();
                            $scope.ctx.moveTo($scope.collision[key].x1, 40);
                            $scope.ctx.lineTo($scope.collision[key].x2, 40);
                        $scope.ctx.closePath();

                        $scope.ctx.stroke();

                        $scope.ctx.beginPath();
                            $scope.ctx.moveTo($scope.width-40, $scope.collision[key].y1);
                            $scope.ctx.lineTo($scope.width-40, $scope.collision[key].y2);
                        $scope.ctx.closePath();

                        $scope.ctx.stroke();

                    $scope.ctx.restore();
                }
            }
            
            $scope.render = function(){
                $scope.ctx.clearRect(0,0,$scope.ws.width,$scope.ws.height);
                                
                $scope.debug.collision();
                
                for(var key in $scope.blocks){
                    $scope.drawObject($scope.blocks[key]);
                }
                
                $scope.collision = {};
            }
            
            $scope.drawObject = function(el){
                $scope.ctx.save();
                    $scope.ctx.beginPath();
                        $scope.ctx.fillStyle = 'rgba(0,255,0,0.1)';
                        $scope.ctx.strokeStyle = 'black';
                        $scope.ctx.rect(el.x+0.5,el.y+0.5,el.width,el.height);
                    $scope.ctx.closePath();
                    $scope.ctx.fill();
                    $scope.ctx.stroke();
                $scope.ctx.restore();  
                
                //рисум проекции
                
                $scope.ctx.save();
                    $scope.ctx.lineWidth = 1.5;
                    $scope.ctx.strokeStyle = el.projection;

                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo(el.x+0.5, el.dist);
                        $scope.ctx.lineTo(el.x+0.5+el.width, el.dist);
                    $scope.ctx.closePath();
                    
                    $scope.ctx.stroke();
                    
                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo($scope.width - el.dist, el.y+0.5);
                        $scope.ctx.lineTo($scope.width - el.dist, el.y+0.5+el.height);
                    $scope.ctx.closePath();

                    $scope.ctx.stroke();
                $scope.ctx.restore();
            }
            
            $scope.initCollision = function(key){
                var block = $scope.blocks[key];
                
                var ax1 = $scope.player.x;
                var ax2 = $scope.player.x + $scope.player.width;
                var ay1 = $scope.player.y;
                var ay2 = $scope.player.y + $scope.player.height;
                
                var bx1 = block.x;
                var bx2 = block.x + block.width;
                var by1 = block.y;
                var by2 = block.y + block.height;
                
                var checkX = true;
                var checkY = true;
                                                
                //Проверяем горизонталь
                if(checkX && ax1 >= bx1 && ax2 <= bx2 ){    //внутри первый блок
                    $scope.collision[key] = {x1:ax1,x2:ax2,y1:null,y2:null};
                    checkX = false;
                }
                
                if(checkX && bx1 >= ax1 && bx2 <= ax2 ){    //внутри второй блок
                    $scope.collision[key] = {x1:bx1,x2:bx2,y1:null,y2:null};
                    checkX = false;
                }
                
                if( checkX &&  bx1 > ax1 && bx1 < ax2){   //справа
                    $scope.collision[key] = {x1:bx1,x2:ax2,y1:null,y2:null};
                    checkX = false;
                }
                
                if( checkX && bx2 > ax1 && bx2 < ax2 && bx1 < ax1){    //слева
                    $scope.collision[key] = {x1:ax1,x2:bx2,y1:null,y2:null};
                    checkX = false;
                }
                
                //Проверяем вертикаль
                if(checkY && ay1 >= by1 && ay2 <= by2 ){    //внутри первый блок
                    $scope.collision[key] = {x1:null,x2:null,y1:ay1,y2:ay2};
                    checkY = false;
                }
                
                if(checkY && by1 >= ay1 && by2 <= ay2 ){    //внутри второй блок
                    $scope.collision[key] = {x1:null,x2:null,y1:by1,y2:by2};
                    checkY = false;
                }
                
                if( checkY &&  by1 > ay1 && by1 < ay2){ //снизу
                    $scope.collision[key] = {x1:null,x2:null,y1:by1,y2:ay2};
                    checkY = false;
                }
                
                if( checkY && by2 > ay1 && by2 < ay2){
                    $scope.collision[key] = {x1:null,x2:null,y1:ay1,y2:by2};
                    checkY = false;
                }
             
                
                return (!checkX && !checkY);
            }
            
            $scope.checkCollision = function(x,y){
                for(var key in $scope.blocks){
                    if($scope.activeBlock != key){
                       if($scope.initCollision(key) == true){
                           $scope.player.x -= x;
                           $scope.player.y -= y;
                          
                           $scope.collision[key] = {};
                           $scope.initCollision(key);   //перепроверить для ДЕБАГА
                       }
                    }   
                }
            }
            
            $('body').keydown(function(e){               
                switch(e.keyCode){
                    case 37: 
                        $scope.moveLeft();
                        
                        $scope.render();
                        break;
                    case 38: 
                        $scope.moveUp();    
                        $scope.render(); 
                        break;
                    case 39: 
                        $scope.moveRight(); 
                        $scope.render(); 
                        break;
                    case 40: 
                        $scope.moveDown();  
                        $scope.render(); 
                        break;
                }
            });
            
            
            $scope.render();
            
        });
    </script>
    
    <script>
        /*var Vector = {
            checkDotAccessory:function(line,dot){  //проверяет или точка пренадлежит отрезку  
                var result = Math.abs(Math.sqrt(Math.pow(line.x1-dot.x,2)+Math.pow(line.y1-dot.y,2)) + Math.sqrt(Math.pow(line.x2-dot.x,2)+Math.pow(line.y2-dot.y,2)) - Math.sqrt(Math.pow(line.x2-line.x1,2)+Math.pow(line.y2-line.y1,2)));
                
                return result == 0;
            },
            degToRad:function(deg){
                var rad = deg * (Math.PI / 180);
                
                return rad;
            },
            radToDeg:function(rad){
                var rad = rad * (180/Math.PI);
                
                return rad;
            },
            
            segmentToVector:function(A,B){
                var obj = {}; 
                obj.x = B.x - A.x;
                obj.y = B.y - A.y;
                
                return obj;
            },
            
            length:function(A,B){   //получаем длинну отрезка
                var coord = this.segmentToVector(A,B);
                
                var length = Math.sqrt( Math.pow(coord.x,2) + Math.pow(coord.y,2) );
                
                return length;
            },
            
            setLength:function(A,B,len){        //получает координаты вектора с заданной длинной. нужно приплюсовать к начальной точке
                var coord = this.segmentToVector(A,B);
                
                var length = Math.sqrt( Math.pow(coord.x,2) + Math.pow(coord.y,2) );
                
                coord.x = coord.x / length * len;
                coord.y = coord.y / length * len;
                
                return coord;
            }
        }*/
           
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
           
        app.controller('secondCtrl', function($scope,vector){
            $scope.ws = $('#second')[0];
            $scope.ctx = $scope.ws.getContext('2d');

            $scope.width = $scope.ws.width;
            $scope.height = $scope.ws.height;
            
            var segment1 = {A:{x:150,y:150},B:{x:300,y:150}};    
            var segment2 = {A:{x:200,y:200},B:{x:350,y:50}};
            
            var obj = vector.findCrossing(segment1,segment2);
            var x = obj.x;
            var y = obj.y;
            
            console.log(x);
            console.log(y);
            
            var length = vector.length(segment1.A, segment1.B);
            
            var x1 = segment1.A.x;
            var y1 = segment1.A.y;
            
            var x2 = segment1.B.x;
            var y2 = segment1.B.y;
            
            var x3 = 200;
            var y3 = 100;
            
            
            var x4 = ((x2-x1)*(y2-y1)*(y3-y1)+x1*Math.pow(y2-y1, 2)+x3*Math.pow(x2-x1, 2))/(Math.pow(y2-y1, 2)+Math.pow(x2-x1, 2));
            var y4 = (y2-y1)*(x4-x1)/(x2-x1)+y1;

            //var x5 = length * (x4-x3)/(y4-y3)+x4;
            //var y5 = (y4-y3)*(x5-x4)/(x4-x3)+y4;
            
            console.log(x4+';'+y4);
            //console.log(x5+';'+y5);

            return 0;
            
            var radius = 3;
            $scope.ctx.save();
                $scope.ctx.beginPath();
                $scope.ctx.fillStyle = 'red';
                
                    $scope.ctx.arc( x, y, radius, 0, 2 * Math.PI, false );
                    
                $scope.ctx.closePath();
                
                $scope.ctx.fill();
            $scope.ctx.restore();
            
            $scope.ctx.save();
                $scope.ctx.beginPath();
                $scope.ctx.fillStyle = 'red';
                
                    $scope.ctx.arc( x3, y3, radius, 0, 2 * Math.PI, false );
                    
                $scope.ctx.closePath();
                
                $scope.ctx.fill();
            $scope.ctx.restore();
            
            $scope.ctx.save();
                    $scope.ctx.lineWidth = 1;
                    $scope.ctx.strokeStyle = 'red';

                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo(segment1.A.x, segment1.A.y);
                        $scope.ctx.lineTo(segment1.B.x, segment1.B.y);
                    $scope.ctx.closePath();
                    $scope.ctx.stroke();
                    
                    $scope.ctx.strokeStyle = 'blue';
                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo(segment2.A.x, segment2.A.y);
                        $scope.ctx.lineTo(segment2.B.x, segment2.B.y);
                    $scope.ctx.closePath();
                    $scope.ctx.stroke();
                    
                $scope.ctx.restore();
            ////////////////
            
        });
    </script>
    
    <div ng-controller="secondCtrl">
        <canvas id="second" width="600" height="400"></canvas>
    </div>
    
    <div ng-controller="firstCtrl">
        <canvas id="first" width="600" height="400"></canvas>
    </div>
    
    
@endsection