<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Auth;

use Redirect;
//use Illuminate\Validation\Validator;
use Validator;  
//use Illuminate\Support\Facades\Validator;
use App\Validator\CustomValidator;

class Advertisement extends Model{
    public $timestamps = false;
    protected $table = 'advertisement';
    
    public function image(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Image','id','cover');
    }
    
    public function user(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\User','id','user_id');
    }
    
    public function images(){
        return $this->hasMany('App\Models\Image','adv_id','id');
    }
    
    public function tags(){
        return $this->hasMany('App\Models\Tag','adv_id','id');
    }
    
    public function scopeStatusActive($query){
        return $query->where('status','=',1);
    }
    
    public function scopeCategory($query,$category){
        if(!$category) return;
        
        return $query->whereHas('tags',function($query) use ($category){
              $query->where('tag_id', '=', $category);
          });
    }
        
    public function changeStatus($id){
        $data = self::getCurrent($id);
        
        $data->active = $data->active == 1 ? 0 :1;
        $this->active = $data->active;
        $data->save();
        return true;
    }
    
    public static function getSearchData($get){
          $data = self::with('image','images','tags')
                  ->category($get->category)
                  ->where('moderation' ,'=', 1)
                  ->where('active' ,'=', 1)
                  ->statusActive()
                ->limit('30')->get();
          return $data;
    }
    
    public function editFullDescription($id, $post){
        $data = self::getCurrent($id);
        $data->full_description = $post->full_description;
        return $data->save();
    }
   
    public function editCommon($id,$post){
        $data = self::getCurrent($id);
        
        $data->title = $post->title;
        $data->description = $post->description;
        $data->type = $post->type;
        $data->max_members = $post->max_members;
        
        if($data->save()){
            return true;
            
        }
    }
    
    public function getList(){
        $data = self::where('user_id' ,'=', Auth::user()->id)
                ->where('end_date','>','"'.date("Y-m-d H:i:s".'"'))
                ->where('end_date','!=','0000-00-00 00:00:00')  
                ->get();
        
        return $data;
    }
    
    public function getLimit($limit=10){
        $data = self::where('user_id' ,'=', Auth::user()->id)
                ->where('moderation' ,'=', 1)
                ->where('status' ,'=', 1)
                ->limit($limit)->get();
        
        return $data;
    }
    
    public static function getCurrent($id){
        $data = Advertisement::with('image','images','tags')->where('id','=',$id)
                
                //->where('user_id','=',Auth::user()->id)
                ->limit(1)
                ->get();
        if($data->isEmpty())return null;
        
        return $data[0];
    }
    
    public function addTag($adv_id,$type){
        $tag = new Tag();
        $tag->tag_id = $type;
        $tag->user_id = Auth::user()->id;
        $tag->adv_id = $adv_id;
        $tag->save();
    }
    
    /*public function messages(){
        return [
            'title.required' => '111111111',
            //'body.required'  => 'A message is required',
        ];
    }*/
    
    public function addNew($post){
        $row = new self();
        
        /*Validator::resolver(function($translator, $data, $rules, $messages){
            return new CustomValidator($translator, $data, $rules, $messages);
        });*/
        
        /*Validator::extend('foo', function($attribute, $value, $parameters){
            return $value == 'foo';
        });*/
        
        $validator = Validator::make(
            [
                'title' => $post->title,
                'description' => $post->description,
                'type' => $post->type,
                'max_members' => $post->max_members,
                'start_date' => $post->start_date,
                'start_time' => $post->start_time,
                'end_date' => $post->end_date,
                'end_time' => $post->end_time,
            ],
            [
                'title' => 'required|min:5|max:120',
                'description' => 'required|min:10|max:400',
                'type' => 'type',
                'max_members' => 'required|min:1',
                'start_date' => 'required|date_format:d-m-Y',
                'start_time' => 'required|date_format:H:i',
                'end_date' => 'required|date_format:d-m-Y',
                'end_time' => 'required|date_format:H:i',
            ],
            [
                //'title.foo' => '222',
                'title.required' => '111111111',
                'type.type' => 'Вы должны ввести хотя бы один тип',
            ]
        );
        
        if ($validator->fails()){
            $this->errors = $validator->errors();
            return false;
        }
        
        $row->user_id = Auth::user()->id;
        $row->title = $post->title;
        $row->description = $post->description;
        
        $row->max_members = $post->max_members;
        $row->date = date('Y-m-d H:i:s');
        $row->moderation = Auth::user()->vip ? 1 : 0;
        
        $row->start_date = date("Y-m-d H:i:s",strtotime($post->start_date.' '.$post->start_time));
        $row->end_date = date("Y-m-d H:i:s",strtotime($post->end_date.' '.$post->end_time));
                
        if($row->save()){
            foreach($post->type as $item){
                $this->addTag($row->id,$item);
            }
        }
        
        return $row->id;
    }
   
}
