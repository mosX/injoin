<?php
    namespace App\Validators;
    
    use Illuminate\Validation\Validator;
    
    class CustomValidator{
        public function validateFoo($attribute, $value, $parameters){
            //Условия
            return false;
        }
        
        public function validateType($attribute, $value, $parameters){
            $cnt = 0;
            foreach($value as $item){
                if($item != 0){
                    $cnt ++;
                }
            }
            
            return !$cnt ? false : true;
        }
    }
?>