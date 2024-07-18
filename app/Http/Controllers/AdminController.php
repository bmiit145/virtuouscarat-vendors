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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
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
        // Validate the request data
        $validatedData = $request->validate([
            'contact_person_name' => 'required|string|max:255',
            'contact_person_mobile' => 'required|string|max:15',
            'contact_person_alternate_number' => 'nullable|string|max:15',
            'contact_person_alternate_email' => 'nullable|email|max:255',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:11',
            'brand_name' => 'required|string|max:255',
            'gst_number' => 'required|string|max:15',
        ]);
    
        // Fetch the authenticated user's ID
        $id = Auth::user()->id;
        
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
    
        
         $user = User::where('id', $id)->first();
         $email = $user->email;
        // Fetch or create business details for the user
        $business_data = Userdetails::where('user_id', $id)->first();
        if ($business_data) {
            $business_data->update([
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'bank_name' => $request->bank_name,
                'account_number' => $request->bank_account_number,
                'ifsc_code' => $request->ifsc_code,
                'brand_name' => $request->brand_name,
                'gst' => $request->gst_number,
                'otp' => $otp,
            ]);
        } else {
            $business_data = Userdetails::create([
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'bank_name' => $request->bank_name,
                'account_number' => $request->bank_account_number,
                'ifsc_code' => $request->ifsc_code,
                'brand_name' => $request->brand_name,
                'user_id' => $id,
                'gst' => $request->gst_number,
                'otp' => $otp,
            ]);
        }
    
        // Send OTP via email
        Mail::to($email)->send(new SendOtpMail($otp));
    
        // Return a JSON response indicating OTP has been sent
        return response()->json([
            'success' => true,
            'message' => 'OTP sent to email. Please verify to update settings.'
        ]);
    }
    
    public function verifyOtpAndUpdateSetting(Request $request)
    {
        // Validate the OTP
        $validatedData = $request->validate([
            'otp' => 'required|integer',
        ]);
    
        // Fetch the authenticated user's ID
        $id = Auth::user()->id;
    
        // Fetch business details
        $business_data = Userdetails::where('user_id', $id)->first();
    
        // Check if the OTP matches
        if ($business_data->otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 400);
        }
    
        // Update user details
        $user = User::find($id);
        $user->phone = $request->contact_person_mobile;
        $user->name = $request->contact_person_name;
        $user->alternate_mail = $request->contact_person_alternate_email;
        $user->alternate_number = $request->contact_person_alternate_number;
        $user->gst_number = $request->gst_number;
        $user->save();
    
        // Update business details
        $business_data->update([
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'bank_name' => $request->bank_name,
            'account_number' => $request->bank_account_number,
            'ifsc_code' => $request->ifsc_code,
            'brand_name' => $request->brand_name,
            'gst' => $request->gst_number,
            'otp' => null // Clear the OTP after verification
        ]);
    
        // Return a JSON response with success message and updated data
        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
            'user' => $user,
            'business_details' => $business_data
        ]);
    }
    
    
}
