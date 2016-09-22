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
                
                //console.log(scal  + ' - '+length1 +' - '+length2 );
                                
                return Math.acos(angle);
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
            
            $scope.mouse_x = 0;
            $scope.mouse_y = 0;
            
            $scope.start_x = 450;
            $scope.start_y = 230;
            
            $scope.render = function(){
                $scope.ctx.clearRect(0,0,$scope.ws.width,$scope.ws.height);
                
                if($scope.mouse_x == 0 && $scope.mouse_y == 0) return;
                
                        
                $scope.drawStepLines();
                $scope.drawCathetus();
                
                $scope.drawHypotenuse();
                                
                $scope.getAngle();
                
                $scope.$digest();   //заполняет переменные
                
            }
            
            $('#canvas').mousemove(function(e){
                var rect = $($($scope.ws))[0].getBoundingClientRect();
                var offsetX = rect.x;
                var offsetY = rect.y;
        
                if(e.layerX){
                    $scope.mouse_x = e.layerX - offsetX;
                    $scope.mouse_y = e.layerY - offsetY;
                }else{
                  $scope.mouse_x = e.clientX - offsetX;
                  $scope.mouse_y = e.clientY - offsetY; 
                }

                //$('#x').val($scope.mouse_x);
                //$('#y').val($scope.mouse_y);
                
                $scope.render();
            });
            
            $scope.initCanvas();
                      
           $scope.drawCathetus = function(){
               $scope.ctx.save();
                    $scope.ctx.beginPath();
                        $scope.ctx.strokeStyle = '#c6c6c6';
                        $scope.ctx.moveTo($scope.mouse_x+0.5, $scope.mouse_y);
                        $scope.ctx.lineTo($scope.mouse_x+0.5, $scope.start_y);
                    $scope.ctx.closePath();
                    $scope.ctx.stroke();
                $scope.ctx.restore();
                
                $scope.BC = vector.length({x:$scope.mouse_x,y:$scope.mouse_y},{x:$scope.mouse_x,y:$scope.start_y});
                
                $scope.ctx.save();
                    $scope.ctx.fillStyle = 'black';
                    $scope.ctx.font = "bold 11px Tahoma";
                    
                    var text = 'L='+($scope.BC).toFixed(2);
                    //var length = this.ctx.measureText(text);
                    
                    $scope.ctx.textAlign = "left";
                    if($scope.mouse_y < $scope.start_y){
                        $scope.ctx.fillText(text, $scope.mouse_x+5, $scope.start_y-$scope.BC/2);
                    }else{
                        $scope.ctx.fillText(text, $scope.mouse_x+5, $scope.start_y+$scope.BC/2);    
                    }
                    
                    $scope.ctx.fillStyle = 'blue';
                    $scope.ctx.font = "bold 14px Tahoma";
                    $scope.ctx.fillText('C', $scope.mouse_x-15, $scope.start_y);
                $scope.ctx.restore();
           }
           
            $scope.drawHypotenuse = function(){
                var radius = 2;
                $scope.ctx.save();
                    $scope.ctx.beginPath();
                    $scope.ctx.fillStyle = 'black';

                        $scope.ctx.arc( $scope.start_x, $scope.start_y, radius, 0, 2 * Math.PI, false );
                    $scope.ctx.closePath();

                    $scope.ctx.fill();
                $scope.ctx.restore();
                
                $scope.ctx.save();
                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo($scope.start_x, $scope.start_y);
                        $scope.ctx.lineTo($scope.mouse_x, $scope.mouse_y);
                    $scope.ctx.closePath();
                    $scope.ctx.stroke();
                $scope.ctx.restore();
                
                //пишем текст в значение стрелочки
                $scope.AB= vector.length({x:$scope.start_x,y:$scope.start_y},{x:$scope.mouse_x,y:$scope.mouse_y});
                
                $scope.ctx.save();
                    $scope.ctx.fillStyle = 'black';
                    $scope.ctx.font = "bold 11px Tahoma";
                    
                    var text = 'L='+($scope.AB).toFixed(2);
                    //var length = this.ctx.measureText(text);
                    
                    $scope.ctx.textAlign = "left";
                    $scope.ctx.fillText(text, $scope.mouse_x+5, $scope.mouse_y-5);
                    
                    $scope.ctx.fillStyle = 'blue';
                    $scope.ctx.font = "bold 14px Tahoma";
                    $scope.ctx.fillText('B', $scope.mouse_x-15, $scope.mouse_y);
                $scope.ctx.restore();
                
                var radius = 3;
                $scope.ctx.save();
                    $scope.ctx.beginPath();
                    $scope.ctx.fillStyle = 'red';

                        $scope.ctx.arc( $scope.mouse_x, $scope.mouse_y, radius, 0, 2 * Math.PI, false );

                    $scope.ctx.closePath();

                    $scope.ctx.fill();
                $scope.ctx.restore();
                
            }
            
            $scope.drawStepLines = function(){  //линии воображаемого треугольника
                $scope.ctx.save();
                    $scope.ctx.strokeStyle = '#c6c6c6';
                    $scope.ctx.beginPath();
                        $scope.ctx.moveTo(0, $scope.start_y+0.5);
                        $scope.ctx.lineTo($scope.start_x+$scope.ws.width, $scope.start_y+0.5);
                    $scope.ctx.closePath();
                    $scope.ctx.stroke();
                $scope.ctx.restore();
                
                $scope.AC = vector.length({x:$scope.start_x,y:$scope.start_y},{x:$scope.mouse_x,y:$scope.start_y});
                
                $scope.ctx.save();
                    $scope.ctx.fillStyle = 'black';
                    $scope.ctx.font = "bold 11px Tahoma";
                    
                    var text = 'L='+($scope.AC).toFixed(2);
                    var l = this.ctx.measureText(text);
                    
                    $scope.ctx.textAlign = "left";
                    if($scope.mouse_x > $scope.start_x){
                        $scope.ctx.fillText(text, $scope.start_x+$scope.AC/2, $scope.start_y+15);
                    }else{
                        $scope.ctx.fillText(text, $scope.start_x-$scope.AC/2 - l.width, $scope.start_y+15);
                    }
                    
                    $scope.ctx.fillStyle = 'blue';
                    $scope.ctx.font = "bold 14px Tahoma";
                    $scope.ctx.fillText('A', $scope.start_x-15, $scope.start_y);
                $scope.ctx.restore();
            }
           
            $scope.getAngle = function(){
                var data =  vector.getAngle({A:{x:$scope.start_x,y:$scope.start_y},B:{x:$scope.mouse_x,y:$scope.mouse_y}},{A:{x:$scope.start_x,y:$scope.start_y},B:{x:$scope.mouse_x,y:$scope.start_y}});
                //$('#angle').val(vector.radToDeg(data));
                
                var obj = vector.segmentToVector({x:$scope.start_x,y:$scope.start_y},{x:$scope.mouse_x,y:$scope.mouse_y});
                $('#vector').val('{x:'+obj.x+';'+'y:'+obj.y+'}');
                                
                $scope.cos = $scope.AC / $scope.AB;
                $scope.angle = vector.radToDeg(Math.acos($scope.cos));
                
                if( (obj.x > 0 && obj.y < 0) ||  (obj.x < 0 && obj.y > 0)){
                    $scope.angle = 90 - $scope.angle;
                }
                
                if( obj.x > 0 && obj.y > 0){
                    $scope.angle = 90 + $scope.angle;
                }else if(obj.x < 0 && obj.y > 0){
                    $scope.angle = 180 + $scope.angle;
                }else if(obj.x < 0 && obj.y < 0){
                    $scope.angle = 270 + $scope.angle;
                }
                
                //$('#cos').val($scope.cos);
                
                //$('#angle').val($scope.angle);
                
                
                 $scope.ctx.save();
                    $scope.ctx.fillStyle = 'black';
                    $scope.ctx.font = "bold 11px Tahoma";
                    
                    var text = ($scope.angle).toFixed(2);
                    //var l = this.ctx.measureText(text);
                    
                    $scope.ctx.textAlign = "left";
                    
                    $scope.ctx.fillText(text, $scope.start_x, $scope.start_y+15);
                $scope.ctx.restore();
            }
           
            $scope.render();
           
        });
    </script>
           
    
    <div ng-controller="gameCtrl">
        <div class="form-group">
            x: <input type="text" id="x" ng-model="mouse_x">
            y: <input type="text" id="y" ng-model="mouse_y">
        </div>
        
        <div class="form-group">
            cos: <input type="text" id="cos" ng-model="cos">
            angle: <input type="text" id="angle" ng-model="angle">
            vector: <input type="text" id="vector">
        </div>
        <canvas id="canvas" width="900" height="500"></canvas>
    </div>
        
@endsection