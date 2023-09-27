<?php

namespace App\Http\Controllers;

use App\Models\area;
use App\Models\lsttable;
use App\Models\menu;
use App\Models\orders;
use App\Models\title_menu;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginUser(Request $request){
        $credentials= $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('index_admin');
        }else{
            session()->flash('error','Error');
            return back();
        }
    }

    public function registerUser(Request $request){
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required|max:50|min:8',
            'password_ck' => 'required|max:50|min:8|same:password',
        ],[
            'email.required'=>'ER',
            'username.required'=>'ER',
            'password.required'=>'ER',
            'password.max'=>'ER',
            'password.min'=>'ER',
            'password_ck.required'=>'ER',
            'password_ck.max'=>'ER',
            'password_ck.min'=>'ER',
            'password_ck.same'=>'Confirm Password Error'
        ]);
        $data = new User();
        $data->id_user = 'U'.time().rand(0,1000);
        $data->email = $request->email;
        $data->username = $request->username;
        $data->password = Hash::make($request->password);
        $data->save();
        session()->flash('success','Create success');
        return redirect()->route('login');
    }

    public function logout(Request $request){
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        session()->flash('success','See you again');
        return redirect()->route('login');
    }

    public function index(){
        if (Auth::user()->id_area == 0) {
            $table_offcanvas = DB::table('lsttable')
                            ->join('area','lsttable.id_area','=','area.id_area')
                            ->orderBy('id_area')
                            ->select('lsttable.*','area.title')->get();
        }else{
            $table_offcanvas = DB::table('lsttable')
                                ->join('area','lsttable.id_area','=','area.id_area')
                                ->where('lsttable.id_area',Auth::user()->id_area)
                                ->orderBy('id_area')
                                ->select('lsttable.*','area.title')->get();
        }
        return view('admin.index', compact('table_offcanvas'));
    }

    public function pic_area_index(Request $request){
        if ($request->data == 0) {
            $table_offcanvas = DB::table('lsttable')
                            ->join('area','lsttable.id_area','=','area.id_area')
                            ->orderBy('id_area')
                            ->select('lsttable.*','area.title')->get();
        }else{
            $table_offcanvas = DB::table('lsttable')
                            ->join('area','lsttable.id_area','=','area.id_area')
                            ->where('lsttable.id_area',$request->data)
                            ->orderBy('id_area')
                            ->select('lsttable.*','area.title')->get();
        }
        return view('admin.index', compact('table_offcanvas'));
    }

    public function create_table(Request $request) {
        $data = new lsttable();
        $data->member = $request->member;
        $data->id_area = $request->id_area;
        $data->des = $request->des;
        $data->save();
        session()->flash('success','Craete Success');
        return back();
    }

    public function view_other(){
        $table_offcanvas = lsttable::all();
        return view('admin.other', compact('table_offcanvas'));
    }
    
    public function create_area_other(Request $request){
        area::updateOrCreate(['title'=>$request->title]);
        session()->flash('success','Create Success');
        return redirect()->route('view_other');
    }

    public function create_menu(Request $request){
        menu::updateOrCreate([
            'title'=>$request->title_menu,
            'name'=>$request->name_menu,
            'size'=>$request->size_menu
        ],[
            'price'=>$request->price_menu,
            'des'=>$request->des_menu
        ]);
        session()->flash('success','Create Success');
        return back();
    }

    public function order(Request $request){
        $id_table = $request->id;
        $sum_price = 0;
        for($q = 0; $q <= count($request->itemCard_quality); $q++){
            $data['value_menu'] = [
                'name'=>$request->itemCard_name_menu,
                'size'=>$request->itemCard_size_menu,
                'price'=>$request->itemCard_price_menu,
                'quality'=>$request->itemCard_quality
            ];
            if(!empty($request->itemCard_quality[$q]) and !empty($request->itemCard_price_menu[$q])){
                $sum_price += $request->itemCard_price_menu[$q];
            }
        }
        $table_offcanvas = lsttable::all();
        return view('admin.check_order', $data, compact('id_table','table_offcanvas','sum_price'));
    }

    public function create_order(Request $request){
        $imp = implode(",", $request->arraryMenu);
        $methods = $request->methods;
        $id = $request->id;

        if ($methods == 1) {// atm
            session()->flash('error','Chưa có chức năng này');
            return back();
        }elseif ($methods == 2) {// QRCODE
            session()->flash('error','Chưa có chức năng này');
            return back();
        }elseif ($methods == 3) {//Cash
            orders::create([
                'id_order'=>'ORD'.time().$id,
                'id_table'=>$id,
                'name_menu'=>$imp,
                'check_in'=>Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
                'check_bill'=>$methods
            ]);
        }else{
            orders::create([
                'id_order'=>'ORD'.time().$id,
                'id_table'=>$id,
                'name_menu'=>$imp,
                'check_in'=>Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
                'check_bill'=>$methods
            ]);
        }
    
        lsttable::where('id_table',$request->id)->update(['status'=>1]);
        return redirect()->route('index_admin');
    }

    public function checkout(Request $request){
        orders::where('id_order',$request->id_order)->update(['check_bill'=>0,'check_out'=>Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString()]);
        lsttable::where('id_table',$request->id_table)->update(['status'=>0]);
        session()->flash('success','');
        return back();
    }

    public function destroy_BillOrder(Request $request){
        orders::where('id_order',$request->id_order)->update(['check_bill'=>0,'status'=>0]);
        lsttable::where('id_table',$request->id_table)->update(['status'=>0]);
        session()->flash('success','');
        return back();
    }
}
