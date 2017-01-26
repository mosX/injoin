<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App;
use View;
use Config;

use Route;

use DB;
use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Middleware\Auth;

use Validator;

use App\Models\Tag;
use App\Models\Advertisement;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Image;

use App\Models\Seat;
use App\Models\Adv_transfer;
use App\Models\Transfer;

use Redirect;

class AdvertisementController extends Controller{
    
    public function colision(){
        return view('advertisement.colision',[]);
    }
    
    public function game(){
        return view('advertisement.game',[]);
    }
    public function vector(){
        return view('advertisement.vector',[]);
    }
    
    public function index(){
        $adertisement = new Advertisement();
        
        return view('advertisement.index',[
                "data"=>$adertisement->getList()
            ]);
    }
    
    public function transfer_preview($id){
        $data = Seat::get($id);
        echo json_encode($data);
        /*return view('advertisement.edit.transfer_preview',[
                "data"=>$data
            ]);*/
    }
    
    public function add_transfer($id, Request $post){
        Adv_transfer::addNew($id,$post->id);
        //p($post->id);
    }
    
    public function edit_transfer($id){
        $transfers  = Adv_transfer::getSelected($id);
        
        $data = Transfer::getAll();
        return view('advertisement.edit.transfer',['data'=>$data,'transfers'=>$transfers,'id'=>$id]);
    }
    
    public function changeAdvStatus($id){
        $adertisement = new Advertisement();
        
        if($adertisement->changeStatus($id)){
            $json = new \stdClass();
            $json->status = 'success';
            $json->active = $adertisement->active;
            
            return json_encode($json);
        }else{
            return '{"status":"error"}';
        }
    }
    
    public function search(Request $request){
        //$adertisement = new Advertisement();
        $data = Advertisement::getSearchData($request);
        
        return view('advertisement.search',['data'=>$data]);
    }
    
    public function show($id){
        //$adertisement = new Advertisement();
        $data = Advertisement::getCurrent($id);
        if(!$data){
            return view('advertisement.show_error',[]);
        }
        
        $reservations = new Reservation();
        $reserv = $reservations->checkReservation($id);
        $count = $reservations->countReservations($id);
        
        return view('advertisement.show',['data'=>$data,'reservations'=>$reserv,'count'=>$count]);
    }
    
    public function create(Request $request){ 
        return View::make('advertisement.create',['types'=>Config::get('custom.types'),'errors'=>null,'post'=>null]);
    }
    
    public function createPOST(Request $request){
        
        $adertisement = new Advertisement();
        $id = $adertisement->addNew($request);
        if($id){
            return redirect('/advertisement/edit/common/'.$id);
        }else{
            return View::make('advertisement.create',['types'=>Config::get('custom.types'),'errors'=>$adertisement->errors,'post'=>$request]);
        }
    }
    
    public function edit_common($id){
        //$adertisement = new Advertisement();
        $data = Advertisement::getCurrent($id);

        return view('advertisement.edit.common',['types'=>Config::get('app.types'),'data'=>$data,'id'=>$id]);
    }
    
    public function edit_common_post(Request $request , $id){
        $adertisement = new Advertisement();
        
        if($adertisement->editCommon($id,$request)){
            return Redirect::route('advertisement.edit.common',['id'=>$id]);
        }
    }
    
    public function edit_address($id){
        //$adertisement = new Advertisement();
        $data = Advertisement::getCurrent($id);

        return view('advertisement.edit.address',['id'=>$id,'data'=>$data]);
    }
    
    public function edit_address_post(Request $request,$id){
                //$adertisement = new Advertisement();
        Advertisement::changeCoords($request->lat,$request->lng,$id);
        
        return Redirect::route('advertisement.edit.address',['id'=>$id]);

        //return view('advertisement.edit.address',['id'=>$id,'data'=>$data]);
    }
    
    public function edit_photo($id){
        //$adertisement = new Advertisement();
        $data = Advertisement::getCurrent($id);
        
        return view('advertisement.edit.photo',['data'=>$data,'id'=>$id]);
    }
    
    public function addphoto_get($id){
        return view('advertisement.edit.addphoto',['status'=>'',"filename"=>'','error'=>'','id'=>$id]);
    }
    
    public function addphoto_post($id, Request $request){
        $file = $request->file('file');
        
        $images = new Image();
        $path = public_path('assets/adv/'.Auth::user()->id.'/'.$id);
        
        $images->initImage($file,$path);
        $error = null;
        if($images->validation == false){
            $filename = '';
            $status = 'error';
            $error = $images->error;
        }else{
            $filename = $images->filename;
            $status = 'success';
            
            $images->addPhoto($id,$filename);
        }
                
        return view('advertisement.edit.addphoto',['status'=>$status,"filename"=>$filename,'error'=>$error,'id'=>$id]);
    }
        
    public function edit_description($id){
        //$adertisement = new Advertisement();
        $data = Advertisement::getCurrent($id); 

        return view('advertisement.edit.description',['data'=>$data,'id'=>$id]);
    }
    
    public function edit_description_post($id, Request $request){
        $adertisement = new Advertisement();
        
        if($adertisement->editFullDescription($id,$request)){
            return Redirect::route('advertisement.edit.description',['id'=>$id]);
        }
    }
    
    public function edit_advanced($id){
        
        $data = Advertisement::getCurrent($id);

        return view('advertisement.edit.advanced',['data'=>$data,'id'=>$id]);
    }
    
}
