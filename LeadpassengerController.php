<?php

namespace App\Http\Controllers;

use App\Models\Lead_Passenger_location;
use App\Models\travel;
use App\Models\LeadPassenger;
use App\Models\register;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Scheduling\Schedule;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;
use DB;
use Mail;
use App\Mail\updatetomandoob;


class LeadpassengerController extends Controller
{

    public function index()
    {
        $get_email = Auth()->guard('lead_passenger')->user()->email;
        $get_bookings = DB::table('bookings')->where('lead_passenger_email', $get_email)->get();
        //dd($get_bookings);
        $get_id = DB::table('b2b_dow_laravel.task_details')->where('email', $get_email)->orderBy('id', 'DESC')->first('employee_id');
        $get_ids = $get_id->employee_id;
        $get_detail = DB::table('tasks')->get();
        //dd($get_detail);
        return view('template/frontend/userdashboard/employeepanel/index', compact('get_bookings', 'get_detail'));
    }
    public function lead_passenger_location()
    {
        $get_id = auth()->guard('lead_passenger')->user()->id;
        $location1 = \DB::table('b2b_dow_laravel.lead__passenger_locations')->where('uid',$get_id)->get();
        $ip1 = $_SERVER['REMOTE_ADDR'];
        $ip = substr($ip1, strrpos($ip1, ':'));
        $location = \Location::get($ip);
        $insert = new Lead_Passenger_location;
        $insert->ip = $location->ip;
        $insert->countryName = $location->countryName;
        $insert->countryCode = $location->countryCode;
        $insert->regionCode = $location->regionCode;
        $insert->regionName = $location->regionName;
        $insert->cityName = $location->cityName;
        $insert->zipCode = $location->zipCode;
        $insert->postalCode = $location->postalCode;
        $insert->latitude = $location->latitude;
        $insert->longitude = $location->longitude;
        $insert->areaCode = $location->areaCode;
        $insert->uid = $get_id;
        $insert->landing = 'on page';
        $insert->save();
        $insert_id = $insert->id;
        $get_id = Auth::guard('lead_passenger')->user()->id;
        //code to point stay markers of user
        $get_email = Auth::guard('lead_passenger')->user()->email;
        $invoiveno = DB::table('lead_passengers')
        ->join('Bookings','lead_passengers.email','=','Bookings.lead_passenger_email')
        ->select('Bookings.invoice_no','Bookings.hotel_makkah_checkavailability','Bookings.hotel_madinah_checkavailability','Bookings.transfer_checkavailability')
        ->where('lead_passengers.email','=',$get_email)
        ->get();
       if (!$invoiveno->isEmpty()){ 
            $hotel_makkah_checkavailability = json_decode($invoiveno[0]->hotel_makkah_checkavailability);
            $hmakkahname = '';
            $hmakkahin = '';
            $hmakkahout = '';
        if (!empty($hotel_makkah_checkavailability)) {
            $hmakkahname = $hotel_makkah_checkavailability->response->name;
            $hmakkahin = $hotel_makkah_checkavailability->response->checkInTime;
            $hmakkahout = $hotel_makkah_checkavailability->response->checkOutTime;
            $hmakkahdatein = $hotel_makkah_checkavailability->response->checkInDate;
            $hmakkahdateout = $hotel_makkah_checkavailability->response->checkOutDate;
        }
            $hotel_madinah_checkavailability = json_decode($invoiveno[0]->hotel_madinah_checkavailability);
            $hmadinahname = '';
            $hmadinahin = '';
            $hmadinahout = '';
        if (!empty($hotel_madinah_checkavailability)) {
            $hmadinahname = $hotel_madinah_checkavailability->response->name;
            $hmadinahin = $hotel_madinah_checkavailability->response->checkInTime;
            $hmadinahout = $hotel_madinah_checkavailability->response->checkOutTime;
            $hmadinahdatein = $hotel_madinah_checkavailability->response->checkInDate;
            $hmadinahdateout = $hotel_madinah_checkavailability->response->checkOutDate;   
        }
        $detail = array();
        if (!empty($get_id)) {
            $user_stay_marker = register::find($get_id);
            $user_stay_marker = $user_stay_marker->PnE;
            if($user_stay_marker!=""){
                $data = json_decode($user_stay_marker);
                //dd($data);
                foreach ($data as $key => $value) {
                    if($value->StayName=='Makkah' && !empty($hotel_makkah_checkavailability)){
                        $data[$key]->HotelName = $hmakkahname;
                        $data[$key]->checkin = $hmakkahin;
                        $data[$key]->checkout = $hmakkahout;
                        $data[$key]->hmakindate = date('Y-m-d', strtotime($hmakkahdatein));
                        $data[$key]->hmakoutdate = date('Y-m-d', strtotime($hmakkahdateout));
                    } else if($value->StayName=='Madinah' && !empty($hotel_madinah_checkavailability)){
                        $data[$key]->HotelName = $hmadinahname;
                        $data[$key]->checkin = $hmadinahin;
                        $data[$key]->checkout = $hmadinahout;
                        $data[$key]->hmadiindate = date('Y-m-d', strtotime($hmadinahdatein));
                        $data[$key]->hmadioutdate = date('Y-m-d', strtotime($hmadinahdateout));  
                    }
                    if($value->StayName=='Jeddah'){
                       // $data[$key]->HotelName2 = $value->StayName;
                       // $data[$key]->StayDates2 = $value->StayDates;
                       // $data[$key]->TimeIn2 = $value->TimeIn;
                       // $data[$key]->TimeOut2 = $value->TimeOut;
                    }
                }
            }
        }
        $detail = $data;              
        return view('template/frontend/userdashboard/employeepanel/pages/lead_passenger_location',compact('location','insert_id','get_id','detail'));
    }else{
        return view('template/frontend/userdashboard/employeepanel/pages/lead_passenger_location',compact('location','insert_id','get_id'));
         }
    }
    public function lead_login()
    {
        return view('template/frontend/userdashboard/employeepanel/pages/login');
    }
    public function lead_login_submit(Request $request)
    {
            $this->validate($request, [
                'email' => 'required'
            ]);

            $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];

            if ($login = Auth::guard('lead_passenger')->attempt($credentials)) {
                $get_id = \DB::table('b2b_dow_laravel.lead_passengers')->where('email', '=', $request->email)->first();
                $user_ids = $get_id->id;
                $ip1 = $_SERVER['REMOTE_ADDR'];
                //dd($ip1);
                $ip = substr($ip1, strrpos($ip1, ':'));
                $data = \Location::get($ip);
                //dd($data);
                $insert = new Lead_Passenger_location;
                $insert->login = 'login';
                $insert->ip = $data->ip;
                $insert->countryName = $data->countryName;
                $insert->countryCode = $data->countryCode;
                $insert->regionCode = $data->regionCode;
                $insert->regionName = $data->regionName;
                $insert->cityName = $data->cityName;
                $insert->zipCode = $data->zipCode;
                $insert->postalCode = $data->postalCode;
                $insert->latitude = $data->latitude;
                $insert->longitude = $data->longitude;
                $insert->areaCode = $data->areaCode;
                $insert->uid = $user_ids;
                $insert->save();

                $status = DB::table('lead_passengers')->where('id', $user_ids)->update([
                'status'=> 1
                ]);
                return redirect()->intended('dashboard');
            }
    }
                public function lead_logout()
                {   
                $ip1 = $_SERVER['REMOTE_ADDR'];
                //dd($ip1);
                $ip = substr($ip1, strrpos($ip1, ':'));
                $data = \Location::get($ip);
                //dd($data);
                $user_ids = auth()->guard('lead_passenger')->user()->id;
                $insert = new Lead_Passenger_location;
                $insert->logout = 'logout';
                $insert->ip = $data->ip;
                $insert->countryName = $data->countryName;
                $insert->countryCode = $data->countryCode;
                $insert->regionCode = $data->regionCode;
                $insert->regionName = $data->regionName;
                $insert->cityName = $data->cityName;
                $insert->zipCode = $data->zipCode;
                $insert->postalCode = $data->postalCode;
                $insert->latitude = $data->latitude;
                $insert->longitude = $data->longitude;
                $insert->areaCode = $data->areaCode;
                $insert->uid = $user_ids;
                $insert->save();
                $status = DB::table('lead_passengers')->where('id', $user_ids)->update([
                'status'=> 0,
                'latitude'=> $data->latitude,
                'longitude'=> $data->longitude
                ]);
                Auth::guard('lead_passenger')->logout();
                return redirect('login');
    }
    public function update_ip1(Request $request,$id)
    { 
                $uid = $request->uid;
                $insert = ($request->ip);
                $jh = $insert['ip'];
                $flight = Lead_Passenger_location::find($id);
                $flight->ip = $jh;
                $flight->update();
                print_r($flight);
    }
    public function update_travel(Request $req)
            {
                $distance = $req->time;
                $start = $req->first;
                $end = $req->second;
                $user_id = $req->uid;
                $insert = new travel;
                $insert->starting_point = $start;
                $insert->end_point = $end;
                $insert->route = $distance;
                $insert->uid = $user_id;
                $insert->save();
    }
    public function register_view(){
                 $lead_passenger_emailz = Auth()->guard('lead_passenger')->user()->email;
                 //dd($lead_passenger_emailz);
                 $lead_passenger_booking = DB::table('bookings')->where('lead_passenger_email','=', $lead_passenger_emailz)->get();
                 if (!empty($lead_passenger_booking)) {
                       $availability = json_decode($lead_passenger_booking[0]->hotel_makkah_checkavailability);
                //dd($availability);
                $hcheckInDate1 = $availability->response->checkInDate;
                $hcheckInDate = date('d/m/Y', strtotime($hcheckInDate1));
                $hcheckOutDate1 = $availability->response->checkOutDate;
                $hcheckOutDate = date('d/m/Y', strtotime($hcheckOutDate1));
                $hcheckInTime = $availability->response->checkInTime;
                $hcheckOutTime = $availability->response->checkOutTime;
                $city_name = $availability->response->city;
                $booking_invoice_no = $lead_passenger_booking[0]->invoice_no;
                //dd($booking_invoice_no);
                $booking_details = array();
                array_push($booking_details, $hcheckInDate, $hcheckOutDate, $hcheckInTime, $hcheckOutTime, $city_name, $booking_invoice_no);
                //dd($booking_details);
                return view('template/frontend/userdashboard/employeepanel/pages/register',compact('booking_details'));
         }else{
                return redirect('dashboard')->with('status', 'We havent Recived Your Booking.So you cant Access this Page until you made Booking with the help of Umrah Operator !');
         }
      
    }
    public function register_process(Request $req){
         $data = [];
        foreach ($req->staydetails['stay_at'] as $key => $value) {
                 $data[] = array(
                'StayName'=> $value,
                'StayDates' => $req->staydetails['stay_date'][$key],
                'TimeIn' => $req->staydetails['check_in'][$key],
                'TimeOut' => $req->staydetails['check_out'][$key]
            );
        }
        $save = new register;
        $save->email = $req->email;
        $save->mobile = $req->mobile;
        $save->dateofbirth = $req->dateofbirth;
        $save->passport = $req->passport;
        $save->nationality = $req->nationality;
        $save->gender = $req->gender;
        $save->arrivalairpot = $req->arrivalairpot;
        $save->arrivalflight = $req->arrivalflight;
        $save->arrivaldate = $req->arrivaldate;
        $save->arrivaltime = $req->arrivaltime;
        $save->departureairport = $req->departureairport;
        $save->departureflight = $req->departureflight;
        $save->departuredate = $req->departuredate;
        $save->departuretime = $req->departuretime;
        $save->PnE = json_encode($data);
        $save->save();
        //dd($save);

        $lead_user_email = Auth()->guard('lead_passenger')->user()->email;
        $user = DB::table('task_details')
        ->where('email','=',$lead_user_email)
        ->select('email')
        ->first();
        
if (!empty($user)) {
          
        //dd($info);die(); 
$updates = [
        'title' => [
            'email' => $req->email,
            'mobile' => $req->mobile,
            'passport' => $req->passport,
            'nationality' => $req->nationality,
            'gender' => $req->gender,
            'landing_airport' => $req->arrivalairpot,
            'landing_flight' => $req->arrivalflight,
            'landing_date' => $req->arrivaldate,
            'landing_time' => $req->arrivaltime,
            'dep_airport' => $req->departureairport,
            'dep_flight' => $req->departureflight,
            'dep_date' => $req->departuredate,
            'dep_time' => $req->departuretime,
        ],

        'body' => json_decode($save->PnE)
        
    ];

        \Mail::to($user)->send(new updatetomandoob($updates));
        
        return redirect('dashboard')->with('status', 'Plan Is Registered Successfully!');
}
        
return redirect('dashboard')->with('status', 'Your not Registered in our System!');
    
        
    

        
    }
    
}
