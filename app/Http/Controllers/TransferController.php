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

use App\Models\Transfer;
use App\Models\Seat;
/*use App\Models\Advertisement;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Image;*/

use Redirect;

class TransferController extends Controller{
    public function index(){
        
    }
    
    public function create(){
        return view('transfer.create',['data'=>null,'errors'=>null,'post'=>null]);
    }
    
    public function create_post(Request $post){
        Transfer::add($post);
        
        return redirect('/transfer/create/');
        //return view('transfer.create',['data'=>null,'errors'=>null,'post'=>null]);
    }
    
    public function view(){
        $list = Transfer::getMyList();
        return view('transfer.view',['data'=>$list]);
    }
    public function view_seats($id){
        //$list = Transfer::getMyList();
        
        $data = Seat::get($id);
        echo json_encode($data);
        
        //return view('transfer.view',['data'=>$data]);
    }
    
    public function seats($id){
        $data = Seat::get($id);
        return view('transfer.seats',['data'=>$data,'errors'=>null,'post'=>null]);
    }
    
    public function seats_modal($id,$seat){
        $row = Seat::getPosition($seat);
        
        echo '{"number":"'.$row->number.'","description":"'.$row->description.'"}';
    }
    public function seats_edit_info($seat,Request $post){
        $row = Seat::editInfo($seat,$post);
    }
    
    public function seats_edit($id,Request $post){
        if(Seat::edit($id,$post)){
            return '{"status":"success"}';
        }else{
            return '{"status":"error"}';
        }
    }
    
    public function seats_post($id,Request $post){
        $id = Seat::add($id,$post);
        if($id){
            return '{"status":"success","id":"'.$id.'"}';
        }else{
            return '{"status":"error"}';
        }
        //return view('transfer.seats',['data'=>null,'errors'=>null,'post'=>null]);
    }
}
