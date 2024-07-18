<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Userdetails;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Auth;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
class AdminController extends Controller
{
    public function index(){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('users', json_encode($array));
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    public function settings(){
        $data=  User::where('id', Auth::user()->id)->first();
        $user = Userdetails::where('user_id', $data->id)->first();
        
        return view('backend.setting', compact('data','user'));
    }

    public function settingsUpdate(Request $request){
        // return $request->all();
        $this->validate($request,[
            'short_des'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required',
            'logo'=>'required',
            'address'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
        ]);
        $data=$request->all();
        // return $data;
        $settings=Settings::first();
        // return $settings;
        $status=$settings->fill($data)->save();
        if($status){
            request()->session()->flash('success','Setting successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword(){
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success','Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request){
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }

    public function thankyou()
    {
        return view('backend.thankyou');
    }

    public function updateSetting(Request $request)
    {
        $contact_person_name = $request->contact_person_name;
        $contact_person_mobile = $request->contact_person_mobile;
        $contact_person_alternate_number = $request->contact_person_alternate_number;
        $contact_person_alternate_email = $request->contact_person_alternate_email;
        $business_name = $request->business_name;
        $business_type = $request->business_type;
        $bank_name = $request->bank_name;
        $bank_account_number = $request->bank_account_number;
        $ifsc_code = $request->ifsc_code;
        $brand_name = $request->brand_name;
        $gst_number = $request->gst_number;

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->phone = $contact_person_mobile;
        $data->name = $contact_person_name;
        $data->alternate_mail = $contact_person_alternate_email;
        $data->alternate_number = $contact_person_alternate_number;
        $data->gst_number = $gst_number;
        $data->update();
        
        $business_data = Userdetails::where('user_id', $id)->first();

        if($business_data)
        {

            $business = Userdetails::where('user_id', $id)
                        ->update(['business_name' => $business_name,
                                    'business_type' => $business_type,
                                    'bank_name' => $bank_name,
                                    'account_number' => $bank_account_number,
                                    'ifsc_code' => $ifsc_code,
                                    'brand_name' => $brand_name,
                                    'user_id' => $data->id,
                                    'gst' => $gst_number]);
        }else{
            $business = new Userdetails();
            $business->business_name = $business_name;
            $business->business_type = $business_type;
            $business->bank_name = $bank_name;
            $business->account_number = $bank_account_number;
            $business->ifsc_code = $ifsc_code;
            $business->brand_name = $brand_name;
            $business->user_id = $data->id;
            $business->gst = $gst_number;
            $business->save();
        }

        




    }
}
