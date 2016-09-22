<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App;
use View;
use Config;

use Route;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Middleware\Auth;

use App\Models\Advertisement;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Image;

class ProfileController extends Controller{
    
    public function updateava(){
        return view('profile.updateava',['status'=>'',"filename"=>'','error'=>'']);
    }
    
    public function completed(){
        return view('profile.completed',['data'=>Reservation::getMyCompletedReservations()]);
    }
    
    public function moderated(){
        return view('profile.moderated',['data'=>Reservation::getMyModeratedReservations()]);
    }
    
    public function signed(){
        return view('profile.signed',['data'=>Reservation::getMySignedReservations()]);
    }
    
    public function updateava_post(Request $request){
        $file = $request->file('file');
        
        $photos = new Image();
        $path = public_path('assets/users/'.Auth::user()->id);
        
        $photos->initImage($file,$path);
        $error = null;
        if($photos->validation == false){
            $status = 'error';
            $error = $photos->error;
        }else{
            
            $filename = $photos->filename;
            $status = 'success';
            
            $photos->unlinkOld(Auth::user()->ava,['thumb','small','']); //удалить старые файлы
            $photos->updateAva($filename);
        }
        
        return view('profile.updateava',['status'=>$status,"filename"=>$filename,'error'=>$error]);
    }
    
    public function index(){
        $adertisement = new Advertisement();
        
        return view('profile.index',['data'=>$adertisement->getLimit(10)]);
    }
        
    public function edit_common(){
        return view('profile.edit.common',array());
    }
    
    public function edit_personal(){
        return view('profile.edit.personal',array());
    }
    
    public function edit_photo(){
        return view('profile.edit.photo',array());
    }
    
    /*public function saveava_post(Request $request){
        $file = $request->file('file');
        
        $photos = new Image();
        $path = public_path('assets/users/'.Auth::user()->id);
        
        $photos->initImage($file,$path);
        if($photos->validation == false){
            $status = 'error';
            $error = $photos->error;
        }else{
            $filename = $photos->filename;
            $status = 'success';
            
            $photos->unlinkOld(Auth::user()->ava,['thumb','small','']); //удалить старые файлы
            
            $photos->updateAva($filename);
        }
        
        return view('profile.edit.saveava',['status'=>$status,"filename"=>$filename,'error'=>$error]);
    }
    
    public function saveava(){
        return view('profile.edit.saveava',['status'=>'','filename'=>'','error'=>'']);
    }*/
    
}
