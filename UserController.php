<?php

namespace App\Http\Controllers\frontend\user_dashboard;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Input as input;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Hash;
use Auth;
use DB;
use App\User;
use App\Index;
use App\About_us;
use App\Models\Lead_Passenger_location;
// use App\Contact_us;
use App\Blog;
use App\Package;
use DateTime;
use \DateTimeZone;
use App\Gallery;
use App\Ourteam;
use App\WhyChoose;
use App\Models\Booking;
use App\Models\Active_Agents;
use App\Models\Agent;
use App\Models\Message;
use App\Models\AgentMarkup;
use App\Models\CustomerInvoice;
use App\Mail\SendEmailInvoiceVoucher;
use App\Mail\SendEmailInvoiceWithOutPrice;
class UserController extends Controller
{
    protected $booking;
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function index(){


  

$login_agent=Auth::guard('agent')->user()->email;


$get_notification=DB::table('leaves')->where('status',1)->count();


$login_agent=Auth::guard('agent')->user()->email;
            $today_hotel_makkahb2b = \DB::table('bookings')
                ->whereDate('created_at',date('Y-m-d'))
                ->where('agent_email',$login_agent)->where('hotel_makkah_brn', '!=', 'no_makkah')
                ->count();
                $today_hotel_madinab2b = \DB::table('bookings')
                ->whereDate('created_at',date('Y-m-d'))
                ->where('agent_email',$login_agent)->where('hotel_madina_brn', '!=', 'no_madina')
                ->count();
                $today_hotel_transferb2b = \DB::table('bookings')
                ->whereDate('created_at',date('Y-m-d'))
                ->where('agent_email',$login_agent)->where('transfer_brn', '!=', 'no_transfer')
                ->count();

 $total_today_b2b=$today_hotel_makkahb2b+$today_hotel_madinab2b+$today_hotel_transferb2b;

$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();




       
         $b2b_agents= \DB::table('agents')->get();


       
        
        
        
        


  $b2b_bookings = \DB::table('bookings')

            ->count();

        

        $email='ar@uo.dow.sa';

			$this->bookings= Booking::orderBy('id', 'DESC')->get();

		$data=(array)$this;
// print_r($data);die;




        $b2b_bookings = \DB::table('bookings')->orderBy('id', 'DESC')->where('agent_email',$login_agent)->get();
$datab2b=(array)$b2b_bookings;



            $total_bookingsb2b = [
                'hotel_makkah' => $this->getBookingStatsb2b('hotel_makkah_brn','no_makkah'),
                'hotel_madina' => $this->getBookingStatsb2b('hotel_madina_brn','no_madina'),
                'transfer' => $this->getBookingStatsb2b('transfer_brn','no_transfer'),

            ];

       

        $total_booking_count_b2b=$total_bookingsb2b['hotel_makkah']+$total_bookingsb2b['hotel_madina']+$total_bookingsb2b['transfer'];
       

            $total_bookings = [
                'hotel_makkah' => $this->getBookingStats('hotel_makkah_brn','no_makkah'),
                'hotel_madina' => $this->getBookingStats('hotel_madina_brn','no_madina'),
                'transfer' => $this->getBookingStats('transfer_brn','no_transfer'),
                'ground_services' => $this->getBookingStats('ground_service_brn','no_ground')
            ];

            $total_bookings_this_month = [
                'hotel_makkah' => $this->getBookingStats('hotel_makkah_brn','no_makkah','this_month'),
                'hotel_madina' => $this->getBookingStats('hotel_madina_brn','no_madina','this_month'),
                'transfer' => $this->getBookingStats('transfer_brn','no_transfer','this_month'),
                'ground_services' => $this->getBookingStats('ground_service_brn','no_ground','this_month')
            ];

            $total_bookings_this_week = [
                'hotel_makkah' => $this->getBookingStats('hotel_makkah_brn','no_makkah','this_week'),
                'hotel_madina' => $this->getBookingStats('hotel_madina_brn','no_madina','this_week'),
                'transfer' => $this->getBookingStats('transfer_brn','no_transfer','this_week'),
                'ground_services' => $this->getBookingStats('ground_service_brn','no_ground','this_week')
            ];

            $total_bookings_today = [
                'hotel_makkah' => $this->getBookingStats('hotel_makkah_brn','no_makkah','today'),
                'hotel_madina' => $this->getBookingStats('hotel_madina_brn','no_madina','today'),
                'transfer' => $this->getBookingStats('transfer_brn','no_transfer','today'),
                'ground_services' => $this->getBookingStats('ground_service_brn','no_ground','today')
            ];





        $total_bookingsb2c = [
            'hotel_makkah' => $this->getBookingStatsmonth('hotel_makkah_brn','no_makkah'),
            'hotel_madina' => $this->getBookingStatsmonth('hotel_madina_brn','no_madina'),
            'transfer' => $this->getBookingStatsmonth('transfer_brn','no_transfer'),
            'ground_services' => $this->getBookingStatsmonth('ground_service_brn','no_ground')
        ];

        $total_bookings_this_monthb2c = [
            'hotel_makkah' => $this->getBookingStatsmonth('hotel_makkah_brn','no_makkah','this_month'),
            'hotel_madina' => $this->getBookingStatsmonth('hotel_madina_brn','no_madina','this_month'),
            'transfer' => $this->getBookingStatsmonth('transfer_brn','no_transfer','this_month'),
            'ground_services' => $this->getBookingStatsmonth('ground_service_brn','no_ground','this_month')
        ];

        $total_bookings_this_weekb2c = [
            'hotel_makkah' => $this->getBookingStatsmonth('hotel_makkah_brn','no_makkah','this_week'),
            'hotel_madina' => $this->getBookingStatsmonth('hotel_madina_brn','no_madina','this_week'),
            'transfer' => $this->getBookingStatsmonth('transfer_brn','no_transfer','this_week'),
            'ground_services' => $this->getBookingStatsmonth('ground_service_brn','no_ground','this_week')
        ];

        $total_bookings_todayb2c = [
            'hotel_makkah' => $this->getBookingStatsmonth('hotel_makkah_brn','no_makkah','today'),
            'hotel_madina' => $this->getBookingStatsmonth('hotel_madina_brn','no_madina','today'),
            'transfer' => $this->getBookingStatsmonth('transfer_brn','no_transfer','today'),
            'ground_services' => $this->getBookingStatsmonth('ground_service_brn','no_ground','today')
        ];


        $total_bookingsb2b = [
            'hotel_makkah' => $this->getBookingStatsb2b('hotel_makkah_brn','no_makkah'),
            'hotel_madina' => $this->getBookingStatsb2b('hotel_madina_brn','no_madina'),
            'transfer' => $this->getBookingStatsb2b('transfer_brn','no_transfer'),

        ];
        $total_bookings_this_monthb2b = [
            'hotel_makkah' => $this->getBookingStatsb2b('hotel_makkah_brn','no_makkah'),
            'hotel_madina' => $this->getBookingStatsb2b('hotel_madina_brn','no_madina'),
            'transfer' => $this->getBookingStatsb2b('transfer_brn','no_transfer'),

        ];

        $total_bookings_this_weekb2b = [
            'hotel_makkah' => $this->getBookingStatsb2b('hotel_makkah_brn','no_makkah'),
            'hotel_madina' => $this->getBookingStatsb2b('hotel_madina_brn','no_madina'),
            'transfer' => $this->getBookingStatsb2b('transfer_brn','no_transfer'),

        ];
        $total_bookings_todayb2b = [
            'hotel_makkah' => $this->getBookingStatsb2b('hotel_makkah_brn','no_makkah'),
            'hotel_madina' => $this->getBookingStatsb2b('hotel_madina_brn','no_madina'),
            'transfer' => $this->getBookingStatsb2b('transfer_brn','no_transfer'),

        ];


        $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->get();

        // print_r($agent_active);
        // die();



			return view('template/frontend/userdashboard/index',compact(
			    'total_booking_count_b2b','data','b2b_bookings',
                'total_bookings','total_bookingsb2b', 'total_bookings_this_month','total_bookings_this_monthb2b',
                'total_bookings_this_week', 'total_bookings_today','b2b_agents','b2b_notification','data_b2b','today_hotel_makkahb2b','today_hotel_madinab2b','today_hotel_transferb2b','total_today_b2b','agent_active','get_notification'

            ));

			die;


die;
		// $this->index= Index::all();

		// $data=(array)$this;

	     // print_r($data['index']);die;



		return view('template/frontend/userdashboard/index',compact('data'));



	}


    public function getBookingStats($column,$value,$type = null,$date_from = null, $date_to = null)
    {
      
       $login_agent=Auth::guard('agent')->user()->email;
        $total_bookings = $this->booking->all()
                            ->where($column, '!=', $value)->where('agent_email',$login_agent)
                            ->count();
                           

        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));
        $current_week = $this->getCurrentWeek();

//        dd($first_day_of_this_month);

        if($type == 'this_month')
        {
            
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookings = $this->booking
            ->whereBetween('created_at',[$first_day_of_this_month,$last_day_of_this_month])
            ->where($column, '!=', $value)->where('agent_email',$login_agent)
            ->count();
           
        }

        elseif($type == 'this_week')
        {
            
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookings = $this->booking
                ->whereBetween('created_at',[$current_week['first_day'],$current_week['last_day']])
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
               
        }
        elseif($type == 'today')
        {
            
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookings = $this->booking
                ->whereDate('created_at',date('Y-m-d'))
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
               
        }
        elseif ($type == 'custom_range')
        {
            
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookings = $this->booking
                ->whereBetween('created_at',[$date_from,$date_to])
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
                
        }

        return $total_bookings;
	}


    public function getBookingStatsmonth($column,$value,$type = null,$date_from = null, $date_to = null)
    {
        $email = 'ar@uo.dow.sa';
        

        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));
        $current_week = $this->getCurrentWeek();

//        dd($first_day_of_this_month);

        if($type == 'this_month')
        {
            
        }

        elseif($type == 'this_week')
        {
            
        }
        elseif($type == 'today')
        {
            
        }
        elseif ($type == 'custom_range')
        {
           
        }

        
    }
    public function getBookingStatsb2b($column,$value,$type = null,$date_from = null, $date_to = null)
    {
       
      $login_agent=Auth::guard('agent')->user()->email;

        $total_bookingsb2b = \DB::table('bookings')
                            ->where($column, '!=', $value)->where('agent_email',$login_agent)
                            ->count();


        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));

        // print_r($first_day_of_this_month);
        //   print_r($last_day_of_this_month);
        //   die();
        $current_week = $this->getCurrentWeek();

//        dd($first_day_of_this_month);

        if($type == 'this_month')
        {
             
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookingsb2b = \DB::table('bookings')
            ->whereBetween('created_at',[$first_day_of_this_month,$last_day_of_this_month])
            ->where($column, '!=', $value)->where('agent_email',$login_agent)
            ->count();

        }

        elseif($type == 'this_week')
        {
           
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookingsb2b = \DB::table('bookings')
                ->whereBetween('created_at',[$current_week['first_day'],$current_week['last_day']])
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
                 
        }
        elseif($type == 'today')
        {
           
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookingsb2b = \DB::table('bookings')
                ->whereDate('created_at',date('Y-m-d'))
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
                
        }
        elseif ($type == 'custom_range')
        {
            
            $login_agent=Auth::guard('agent')->user()->email;
            $total_bookingsb2b = \DB::table('bookings')
                ->whereBetween('created_at',[$date_from,$date_to])
                ->where($column, '!=', $value)->where('agent_email',$login_agent)
                ->count();
                
        }

        return $total_bookingsb2b;
    }
 //b2c graph
    public function getBookingStatsb2c($column,$value,$type = null,$date_from = null, $date_to = null)
    {
        $email = 'ar@uo.dow.sa';
       

        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));
        $current_week = $this->getCurrentWeek();

//        dd($first_day_of_this_month);

        if($type == 'this_month')
        {
            
        }

        elseif($type == 'this_week')
        {
            
        }
        elseif($type == 'today')
        {
           
        }
        elseif ($type == 'custom_range')
        {
            
        }

       
    }








    public function getCurrentWeek()
    {
        $monday = strtotime("last monday");
        $monday = date('w', $monday)==date('w') ? $monday+(7*86400) : $monday;
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $this_week_sd = date("Y-m-d",$monday);
        $this_week_ed = date("Y-m-d",$sunday);

        return $data = ['first_day' => $this_week_sd, 'last_day' => $this_week_ed];
    }

    public function bookingChartByDate(Request $request)
    {
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');


        $total_bookings = [
            'hotel_makkah' => $this->getBookingStats('hotel_makkah_brn','no_makkah','custom_range',$date_from,$date_to),
            'hotel_madina' => $this->getBookingStats('hotel_madina_brn','no_madina','custom_range',$date_from,$date_to),
            'transfers' => $this->getBookingStats('transfer_brn','no_transfer','custom_range',$date_from,$date_to),
            'ground_services' => $this->getBookingStats('ground_service_brn','no_ground','custom_range',$date_from,$date_to)
        ];

        return response()->json($total_bookings);
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }




	public function user_profile(){


		$this->user=Auth::guard('web')->user()->get();
		$data=(array)$this;
		return view('template/frontend/userdashboard/pages/user_profile',compact('data'));
	}
	public function customer_invoice()
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
 $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

// $invoice_no="SELECT * FROM `bookings` WHERE `agent_email` = $login_agent AND `hotel_makkah_brn` != 'no_makkah' AND `hotel_madina_brn` != 'no_madina' AND `transfer_brn` != 'no_transfer'";

// $invoice_no = DB::table('bookings')->where('agent_email',$login_agent)->orwhere('hotel_makkah_brn','!=','no_makkah')->orwhere('hotel_madina_brn','!=','no_madina')->orwhere('transfer_brn','!=','no_transfer')->get();

$invoice_no = DB::table('bookings')
->where('agent_email',$login_agent)
->where(function($query){
    $query->orwhere('hotel_makkah_brn','!=','no_makkah')
    ->orwhere('hotel_madina_brn','!=','no_madina')
    ->orwhere('transfer_brn','!=','no_transfer');
})
->get();


// print_r($invoice_no);
// die();



// foreach ($invoice_no as $invoice) 


// {
// $hotel_name_makkah=json_decode($invoice->hotel_makkah_checkavailability);
//  if (isset($hotel_name_makkah)) 
//  {
    

  
// $makkah_room_quantity=0;

//    foreach ($hotel_name_makkah->response->roomGroups as $group_room_rate){
//             foreach ($group_room_rate->rooms as $room_rate){


// $makkah_room_quantity=$room_rate->quantity + $makkah_room_quantity;
// foreach ($room_rate->boardTypes as $room_type)
// {
// $rooms_type=$room_type->type;

//     }
//     // print_r($rooms_type);die;

// }
// }

  


//     $makkah_provider = $hotel_name_makkah->response->provider;
//    $makkah_name = $hotel_name_makkah->response->name;
//  }
 

//   $hotel_name_madina=json_decode($invoice->hotel_madinah_checkavailability);
//  if (isset($hotel_name_madina)) 
//  {

   


// // print_r($hotel_name_madina);die;

//     $madina_name=$hotel_name_madina->response->name;
//     $madina_provider=$hotel_name_madina->response->provider;

// $madina_room_quantity=0;
// $roomGroups=$hotel_name_madina->response->roomGroups;

//    foreach ($roomGroups as $group_room_rate){
//             foreach ($group_room_rate->rooms as $room_rate){


// $madina_room_quantity=$room_rate->quantity + $madina_room_quantity;


// foreach ($room_rate->boardTypes as $room_type)
// {
// $rooms_type=$room_type->type;

//     }
//     // print_r($rooms_type);die;




// }
// }
//  }
//    // print_r($group_room_rate->rooms);die(); 
 
// $transfer=json_decode($invoice->transfer_checkavailability);
// if (isset($transfer)) 
//  {
    

//     $transfer_name=$transfer->response->companyName;
//     $transfer_routeName=$transfer->response->routeName;
//     $transfer_vehicleTypeCode=$transfer->response->vehicleTypes[0]->vehicleTypeCode;


// // $transfer=$transfer->response->vehicleTypes[0]->categories[0]->quantity;
// $transfer_room_quantity=0;
//     $roomGroups=$transfer->response->vehicleTypes;


// foreach ($roomGroups as $group_room_rate){
//             foreach ($group_room_rate->categories as $room_rate){


// $transfer_room_quantity=$room_rate->quantity + $transfer_room_quantity;



// // foreach ($room_rate->boardTypes as $room_type)
// // {
// // $rooms_type=$room_type->type;

// //     }
//     // print_r($group_room_rate->categories);die;





// }
// }




//     $transfer_vehicleType=$transfer->response->vehicleTypes[0]->vehicleType;
//      $transfer_model_from=$transfer->response->vehicleTypes[0]->categories[0]->model->from;
//      $transfer_model_to=$transfer->response->vehicleTypes[0]->categories[0]->model->to;
//     $transfer_provider=$transfer->response->provider;
//  }

// $lead_passenger_details=json_decode($invoice->lead_passenger_details);

// }


// print_r($transfer_room_quantity);die();









		return view('template/frontend/userdashboard/pages/customer_invoice',compact('b2b_notification','login_agent','data_b2b','agent_active','invoice_no'));
	}
    public function get_customer_invoice(Request $request,$invoice_no)
    {
        
  $login_agent=Auth::guard('agent')->user()->id;
  $get_external_agent = DB::table('agents')->where('parent_id',$login_agent)->first();
$get_invoice_no = DB::table('bookings')->where('invoice_no',$invoice_no)->get();

foreach ($get_invoice_no as $invoice) 


{
$hotel_name_makkah=json_decode($invoice->hotel_makkah_checkavailability ?? '');
 if (isset($hotel_name_makkah)) 
 {
    

  
$makkah_room_quantity=0;

   foreach ($hotel_name_makkah->response->roomGroups as $group_room_rate){
            foreach ($group_room_rate->rooms as $room_rate){


$makkah_room_quantity=$room_rate->quantity + $makkah_room_quantity;
foreach ($room_rate->boardTypes as $room_type)
{
$makkah_rooms_type=$room_type->type;

    }
    // print_r($rooms_type);die;

}
}

  


    $makkah_provider = $hotel_name_makkah->response->provider;
   $makkah_name = $hotel_name_makkah->response->name;
 }
 

  $hotel_name_madina=json_decode($invoice->hotel_madinah_checkavailability ?? '');
 if (isset($hotel_name_madina)) 
 {

   


// print_r($hotel_name_madina);die;

    $madina_name=$hotel_name_madina->response->name;
    $madina_provider=$hotel_name_madina->response->provider;

$madina_room_quantity=0;
$roomGroups=$hotel_name_madina->response->roomGroups;

   foreach ($roomGroups as $group_room_rate){
            foreach ($group_room_rate->rooms as $room_rate){


$madina_room_quantity=$room_rate->quantity + $madina_room_quantity;


foreach ($room_rate->boardTypes as $room_type)
{
$madina_rooms_type=$room_type->type;

    }
    // print_r($rooms_type);die;




}
}
 }
   // print_r($group_room_rate->rooms);die(); 
 
$transfer=json_decode($invoice->transfer_checkavailability ?? '');
if (isset($transfer)) 
 {
    

    $transfer_name=$transfer->response->companyName;
    $transfer_routeName=$transfer->response->routeName;
    $transfer_vehicleTypeCode=$transfer->response->vehicleTypes[0]->vehicleTypeCode;


// $transfer=$transfer->response->vehicleTypes[0]->categories[0]->quantity;
$transfer_room_quantity=0;
    $roomGroups=$transfer->response->vehicleTypes;


foreach ($roomGroups as $group_room_rate){
            foreach ($group_room_rate->categories as $room_rate){


$transfer_room_quantity=$room_rate->quantity + $transfer_room_quantity;

}
}




    $transfer_vehicleType=$transfer->response->vehicleTypes[0]->vehicleType;
     $transfer_model_from=$transfer->response->vehicleTypes[0]->categories[0]->model->from;
     $transfer_model_to=$transfer->response->vehicleTypes[0]->categories[0]->model->to;
    $transfer_provider=$transfer->response->provider;
 }

$lead_passenger_details=json_decode($invoice->lead_passenger_details);

}


 return response()->json([

'makkah_room_quantity' =>$makkah_room_quantity ?? '',
'makkah_rooms_type' =>$makkah_rooms_type ?? '',
'madina_room_quantity' =>$madina_room_quantity ?? '',
'madina_rooms_type' =>$madina_rooms_type ?? '',
'transfer_room_quantity' =>$transfer_room_quantity ?? '',
    'hotel_name_makkah' =>$makkah_name ?? '',
    'makkah_provider' =>$makkah_provider ?? '',
    'hotel_name_madina' =>$madina_name ?? '',
    'madina_provider' =>$madina_provider ?? '',
    'transfer_name' =>$transfer_name ?? '',
    'transfer_provider' =>$transfer_provider ?? '',
    'transfer_routeName' =>$transfer_routeName ?? '',
    'transfer_vehicleTypeCode' =>$transfer_vehicleTypeCode ?? '',
      'transfer_vehicleType' =>$transfer_vehicleType ?? '',
    'transfer_model_from' =>$transfer_model_from ?? '',
    'transfer_model_to' =>$transfer_model_to ?? '',
    'lead_passenger_details' =>$lead_passenger_details,
     'get_invoice_no' =>   $get_invoice_no,
     'get_external_agent' =>   $get_external_agent
]);     
    }


    public function customer_invoice_submit(Request $request)
    {




                        $customer_invoice=new CustomerInvoice();
                        $customer_invoice->hotel_makkah_invoice_no=$request->hotel_makkah_invoice_no;
                        $customer_invoice->hotel_makkah_brn=$request->hotel_makkah_brn;
                        $customer_invoice->hotel_madina_invoice_no=$request->hotel_madina_invoice_no;
                        $customer_invoice->transfer_invoice_no=$request->transfer_invoice_no;
                        $customer_invoice->hotel_makkah_name=$request->hotel_makkah_name;
                        $customer_invoice->hotel_makkah_no_of_passenger=$request->hotel_makkah_no_of_passenger;
                        $customer_invoice->hotel_makkah_check_in=$request->hotel_makkah_check_in;
                        $customer_invoice->hotel_makkah_check_out=$request->hotel_makkah_check_out;
                        $customer_invoice->hotel_makkah_booking_date=$request->hotel_makkah_booking_date;

                        $customer_invoice->hotel_makkah_no_of_rooms=$request->hotel_makkah_no_of_rooms;
                        $customer_invoice->hotel_makkah_rooms_type=$request->hotel_makkah_rooms_type;
                        $customer_invoice->hotel_makkah_total_amount=$request->hotel_makkah_total_amount;
                        $customer_invoice->hotel_madina_brn=$request->hotel_madina_brn;
                        $customer_invoice->hotel_madina_name=$request->hotel_madina_name;
                        $customer_invoice->hotel_madina_no_of_passenger=$request->hotel_madina_no_of_passenger;
                        $customer_invoice->hotel_madina_check_in=$request->hotel_madina_check_in;
                        $customer_invoice->hotel_madina_check_out=$request->hotel_madina_check_out;
                        $customer_invoice->hotel_madina_booking_date=$request->hotel_madina_booking_date;
                        $customer_invoice->hotel_madina_no_of_rooms=$request->hotel_madina_no_of_rooms;
                        $customer_invoice->hotel_madina_rooms_type=$request->hotel_madina_rooms_type;
                        $customer_invoice->hotel_madina_total_amount=$request->hotel_madina_total_amount;
                        $customer_invoice->transfer_brn=$request->transfer_brn;
                        $customer_invoice->transfer_name=$request->transfer_name;
                        $customer_invoice->transfer_no_of_passenger=$request->transfer_no_of_passenger;
                        $customer_invoice->transfer_check_in=$request->transfer_check_in;

                        $customer_invoice->transfer_check_out=$request->transfer_check_out;
                        $customer_invoice->transfer_booking_date=$request->transfer_booking_date;
                        $customer_invoice->transfer_no_of_rooms=$request->transfer_no_of_rooms;
                        $customer_invoice->transfer_rooms_type=$request->transfer_rooms_type;
                        $customer_invoice->transfer_total_amount=$request->transfer_total_amount;
                        $customer_invoice->lead_first_name=$request->lead_first_name;
                        $customer_invoice->lead_last_name=$request->lead_last_name;
                        $customer_invoice->lead_email=$request->lead_email;
                        $customer_invoice->lead_phone_no=$request->lead_phone_no;
                        $customer_invoice->lead_gender=$request->lead_gender;
                        $customer_invoice->lead_date_of_birth=$request->lead_date_of_birth;
                        $customer_invoice->lead_nationality=$request->lead_nationality;
                        $customer_invoice->lead_passport_no=$request->lead_passport_no;
                        $customer_invoice->lead_passport_expiry_date=$request->lead_passport_expiry_date;
                        $customer_invoice->rasidence=$request->rasidence;
                        $customer_invoice->agent_company_name=$request->agent_company_name;

                        $customer_invoice->agent_title=$request->agent_title;
                        $customer_invoice->agent_first_name=$request->agent_first_name;
                        $customer_invoice->agent_last_name=$request->agent_last_name;
                        $customer_invoice->agent_email=$request->agent_email;
                        $customer_invoice->agent_phone_no=$request->agent_phone_no;
                        $customer_invoice->agent_country=$request->agent_country;
                        $customer_invoice->agent_city=$request->agent_city;
                        $customer_invoice->agent_passport_no=$request->agent_passport_no;
                        $customer_invoice->agent_commercial_register_number=$request->agent_commercial_register_number;
                        $customer_invoice->agent_license_number=$request->agent_license_number;
                        $customer_invoice->agent_license_number=$request->agent_license_number;
                        $customer_invoice->agent_iban=$request->agent_iban;
                        $customer_invoice->additional_visa_fee=$request->additional_visa_fee;
                        $customer_invoice->additional_ground_charges=$request->additional_ground_charges;
                        $customer_invoice->additional_charges=$request->additional_charges;
                        $customer_invoice->additional_commission=$request->additional_commission;

                        $customer_invoice->external_agent_company_name=$request->external_agent_company_name;
                        $customer_invoice->external_agent_first_name=$request->external_agent_first_name;
                        $customer_invoice->external_agent_last_name=$request->external_agent_last_name;
                        $customer_invoice->external_agent_email=$request->external_agent_email;
                        $customer_invoice->external_agent_phone_no=$request->external_agent_phone_no;
                        $customer_invoice->external_agent_country=$request->external_agent_country;
                        $customer_invoice->external_agent_city=$request->external_agent_city;

                        $customer_invoice->transfer_route=$request->transfer_route;
                        $customer_invoice->transfer_no_of_vihicle=$request->transfer_no_of_vihicle;
                        $customer_invoice->transfer_vihicle_type=$request->transfer_vihicle_type;
                        $customer_invoice->transfer_model_from=$request->transfer_model_from;
                        $customer_invoice->transfer_model_to=$request->transfer_model_to;


                        $customer_invoice->transfer_provider=$request->transfer_provider;
                        $customer_invoice->makkah_provider=$request->makkah_provider;
                        $customer_invoice->madina_provider=$request->madina_provider;




                        $h_makkah=$request->hotel_makkah_total_amount;
                        $h_madina=$request->hotel_madina_total_amount;
                        $transfer=$request->transfer_total_amount;

                        $additional_visa_fee=$request->additional_visa_fee;
                        $additional_ground_charges=$request->additional_ground_charges;
                        $additional_charges=$request->additional_charges;

                        $grand_total=$h_makkah + $h_madina + $transfer + $additional_visa_fee + $additional_ground_charges + $additional_charges;


                        $customer_invoice->grand_total_amount=$grand_total;

                        $customer_invoice->save();

                        return redirect()->back()->with('message','Customer Invoice Created Successful!');

        // print_r($customer_invoice);
        // die();

    }

    public function view_customer_invoice()
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
 $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

       $customer_invoice=CustomerInvoice::orderBy('id', 'DESC')->get();

       return view('template/frontend/userdashboard/pages/view_customer_invoice',compact('b2b_notification','login_agent','data_b2b','agent_active','customer_invoice'));

    }

    public function customer_invoice_id(Request $request,$id)
    {
       $customer_invoice=CustomerInvoice::find($id);
       return view('template/frontend/userdashboard/pages/customer_invoice_voucher',compact('customer_invoice'));
    }
      public function customer_invoice_withoutprice(Request $request,$id)
    {
       $customer_invoice=CustomerInvoice::find($id);
       return view('template/frontend/userdashboard/pages/customer_invoice_without_price',compact('customer_invoice'));
    }

    public function send_email_voucher(Request $request,$id)
    {

        $customer_invoice=CustomerInvoice::find($id);
        // print_r($customer_invoice->external_agent_email);
        $email=$customer_invoice->external_agent_email;
        // print_r($email);
        // die();
        
    $details = [
            'title' => 'Dow',
            'body' => $customer_invoice,
              
        ];

        // print_r( $details['body']);
        // die();

        \Mail::to($email)->send(new SendEmailInvoiceVoucher($details));

       return redirect()->back()->with('message','Email Sent Successfully');
       
       
    }
    public function send_email_invoice_without_price(Request $request,$id)
    {

        $customer_invoice=CustomerInvoice::find($id);
        // print_r($customer_invoice->external_agent_email);
        $email=$customer_invoice->external_agent_email;
        // print_r($email);
        // die();
        
    $details = [
            'title' => 'Dow',
            'body' => $customer_invoice,
              
        ];

        \Mail::to($email)->send(new SendEmailInvoiceWithOutPrice($details));

       return redirect()->back()->with('message','Email Sent Successfully');
       
       
    }

    public function send_email_lead_passenger(Request $request,$id)
    {
       $customer_invoice=CustomerInvoice::find($id);
        // print_r($customer_invoice->external_agent_email);
        $email=$customer_invoice->lead_email;
        // print_r($email);
        // die();
        
    $details = [
            'title' => 'Dow',
            'body' => $customer_invoice,
              
        ];

        \Mail::to($email)->send(new SendEmailInvoiceVoucher($details));

       return redirect()->back()->with('message','Email Sent Successfully');
    }
    public function send_email_lead_without_price(Request $request,$id)
    {
       $customer_invoice=CustomerInvoice::find($id);
        // print_r($customer_invoice->external_agent_email);
        $email=$customer_invoice->lead_email;
        // print_r($email);
        // die();
        
    $details = [
            'title' => 'Dow',
            'body' => $customer_invoice,
              
        ];

        \Mail::to($email)->send(new SendEmailInvoiceWithOutPrice($details));

       return redirect()->back()->with('message','Email Sent Successfully');
    }

    public function b2bbookings(){
	
        $login_agent=Auth::guard('agent')->user()->email;
        $login_agent_id=Auth::guard('agent')->user()->id;
        $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
        $get_agents_country = \DB::table('agents')->distinct()->get();
            $data = \DB::table('bookings')->orderBy('id', 'DESC')->where('agent_email',$login_agent)->get();

        $data = \DB::table('tasks')
        ->join('employees','tasks.employee_id','=','employees.id')
        ->join('agents','tasks.agent_id','=','agents.id')
        ->join('bookings','tasks.booking_id','=','bookings.id')
        ->select('agents.first_name as agent_fname','agents.last_name as agent_lname','agents.email as agent_email','employees.first_name','employees.last_name','employees.email','bookings.*')
        ->where('tasks.agent_id',$login_agent_id)->get();
       // dd($data);
        $markup=DB::table('settings')->first();
        // print_r($markup);
        // die;
        // print_r($markup->ota_makkah_markup);
        // print_r($markup->ota_madina_markup);
        // print_r($markup->ota_transfer_markup);
        // die();
        $status='';



        return view('template/frontend/userdashboard/pages/b2bbookings',compact('markup','data','get_agents_country','status','b2b_notification','data_b2b','agent_active'));
    }


public function update_markup(Request $request,$id)
    {
 
$this->validate($request,[
    'ota_makkah_markup' => 'min:1|max:100',
    'ota_madina_markup' => 'min:1|max:100',
    'ota_transfer_markup' => 'min:1|max:100',
]);

$get_emp_1=DB::table('settings')
            ->where('id', $id)
            ->update([
                'ota_makkah_markup' => $request->ota_makkah_markup,
                'ota_madina_markup' => $request->ota_madina_markup,
                'ota_transfer_markup' => $request->ota_transfer_markup,
            ]); 
        
        return redirect()->back()->with('message','Markup Updated Successful!');
       
       
        
      
    }



public function settings(){

$login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
// print_r($login_agent);
// die();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



    
    
    $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
		return view('template/frontend/userdashboard/pages/settings',compact('b2b_notification','data_b2b','agent_active'));
	}
    public function personal_information(Request $request)
    {
        $get_id=auth()->guard('agent')->user()->id;
        $get_email=Agent::find($get_id);
        if($get_email)
        {
            $get_email->company_name = $request->company_name;
            $get_email->title = $request->title;
            $get_email->country = $request->country;
            $get_email->city = $request->city;
 $get_email->created_at = $request->created_at;
  $get_email->updated_at = $request->updated_at;
  $get_email->iban = $request->iban;

            $get_email->first_name = $request->first_name;
            $get_email->last_name = $request->last_name;
           
            $get_email->phone_no = $request->phone_no;
            $get_email->passport_no = $request->passport_no;
            $get_email->commercial_register_number = $request->commercial_register_number;
            $get_email->license_number = $request->license_number;
            $get_email->update();
            return redirect()->back()->with('message','Updated Your Personal Information!!');
        }
    }
    public function change_password(Request $request)
    {
        $this->validate($request,
            [
                'password'=>'required',
                'new_password'=>'required',
                'verify_password'=>'required',

            ]);


        if($request->input('new_password')==$request->input('verify_password'))
        {
            if (Hash::check($request->input('password'), auth()->guard('agent')->user()->password) == false)
            {
                
                return redirect()->back()->with('message2','invalid current password');
            }

            $user = auth()->guard('agent')->user();
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            return redirect()->back()->with('message1','password updated successfully');

        }
        else
        {
            return redirect()->back()->with('message','confirm password password does not match!!');
        }
    }

public function logout()
	{
		Auth::guard('web')->logout();
		return redirect('index');


	}


    public function bookingDetail(Request $request)
    {


        $case = $request->get('case');
       $brn = $request->get('brn');
       $id = $request->get('id');

//        dd($request->all());
//        dd('called');
        $responseData = $this->getBookingReservation($case, $brn);

       // dd($responseData);
       // die();
    

        $booking_detail = json_decode($responseData);

       // dd($booking_detail);
       //   die();
        $transfer_companies = $this->getTransferCompanies();
        $uo_companies = $this->getGroundServicesCompanies();
//        dd($uo_companies);

//        $booking = $this->booking->select('id', 'hotel_makkah_total_amount', 'hotel_madina_total_amount', 'transfer_total_amount', 'booking_currency', 'lead_passenger_details')->find($id);
        if ($case == 'hotel_makkah_view_booking') {
$markup=DB::table('settings')->first();


            return view('template/frontend/userdashboard/partial/_hotel-makkah-booking-modal', compact('booking_detail','markup'));
        } elseif ($case == 'hotel_madina_view_booking') {
            $markup=DB::table('settings')->first();
            return view('template/frontend/userdashboard/partial/_hotel-madina-booking-modal', compact('booking_detail','markup'));
        } elseif ($case == 'transfers_view_booking') {
             $markup=DB::table('settings')->first();
            return view('template/frontend/userdashboard/partial/_transfer-booking-modal', compact('booking_detail', 'transfer_companies','markup'));
        }
        elseif ($case == 'ground_view_booking') {
            return view('template/frontend/userdashboard/partial/_ground-services-modal', compact('booking_detail', 'uo_companies'));
        }
    }


	public function bookingDetail2(Request $request)
    {
        $case = $request->get('case');
        $brn = $request->get('brn');
        $id = $request->get('id');
        $responseData = $this->getBookingReservation($case,$brn);
        // print_r($responseData); exit();
        $booking_detail = json_decode($responseData);
        $transfer_companies = $this->getTransferCompanies();
        // echo 'brn = '.$brn.'<br>';

        // echo '<pre>detail '; print_r($booking_detail);
//        $booking = $this->booking->select('id','hotel_makkah_total_amount','hotel_madina_total_amount','transfer_total_amount','booking_currency','lead_passenger_details')->find($id);
        if($case == 'hotel_makkah_view_booking')
        {
             $makkah_brn = $request->get('brn');
             $madina_brn = 'no_madina';
             $transfer_brn = 'no_transfer';
             $ground_brn = 'no_ground';
           return redirect('voucher/'.$makkah_brn.'/'.$madina_brn.'/'.$transfer_brn.'/'.$ground_brn);
        }
        elseif ($case == 'hotel_madina_view_booking')
        {
             $makkah_brn = 'no_makkah';
             $madina_brn = $request->get('brn');
             $transfer_brn = 'no_transfer';
             $ground_brn = 'no_ground';
           return redirect('voucher/'.$makkah_brn.'/'.$madina_brn.'/'.$transfer_brn.'/'.$ground_brn);
        }
        elseif($case == 'transfers_view_booking')
        {
            $transfer_brn = $request->get('brn');
             $makkah_brn = '';
             $madina_brn = 'no_madina';

             $ground_brn = 'no_ground';
           return redirect('voucher/'.$makkah_brn.'/'.$madina_brn.'/'.$transfer_brn.'/'.$ground_brn);
        }
        elseif($case == 'ground_view_booking')
        {
            $ground_brn = $request->get('brn');
             $makkah_brn = '';
             $madina_brn = 'no_madina';
             $transfer_brn = 'no_transfer';

           return redirect('voucher/'.$makkah_brn.'/'.$madina_brn.'/'.$transfer_brn.'/'.$ground_brn);
        }
    }




    public function getBookingReservation($case,$brn)
    {
//        echo 'case = '.$case.' brn = '.$brn;die;
        $url = "https://b2b.dow.sa/b2bdowapi.php";
        $data = array();
        $data['case'] = $case;
        if($case == 'hotel_makkah_view_booking')
        {
            $data['makkah_brn'] = $brn;
        }
        elseif($case == 'hotel_madina_view_booking')
        {
            $data['madina_brn'] = $brn;
        }
        elseif($case == 'transfers_view_booking')
        {
            $data['transfer_brn'] = $brn;
        }
        elseif($case == 'ground_view_booking')
        {
            $data['ground_brn'] = $brn;

        }

        /**
         * Call the API to get booking data with Booking Reference No. and case
         */

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'if called';
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }

    public function getTransferCompanies()
    {
        function request2()
        {

            $url = "https://b2b.dow.sa/b2bdowapi.php";
            $data = array('case' => 'transportcompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request2();
        $transportcompanies = json_decode($responseData2);

        return $transportcompanies;
//        echo '<pre>'; print_r($transportcompanies); exit();
    }


    public function getGroundServicesCompanies()
    {
        function request3()
        {
            $url = "https://b2b.dow.sa/b2bdowapi.php";
            $data = array('case' => 'uocompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request3();
        $transportcompanies = json_decode($responseData2);

        return $transportcompanies;
//        echo '<pre>'; print_r($transportcompanies); exit();
    }

   


    
    public function filter_datab2b(Request $request)
    {

    	$login_agent=Auth::guard('agent')->user()->email;
        $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->get();
        dd($data_b2b);



        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();

        $date_from = $request->input('date1');
        $date_to = $request->input('date2');
        $country = $request->input('country');
        $city = $request->input('city');
        $agent_id = $request->input('agent');
        $status = $request->input('status');

//      echo $date_from.' '.$date_to.'  '.$agent_id.' '.$status;die;

        if(!empty($date_from) && !empty($date_to) && !empty($agent_id) && !empty($status))
        {

            $data = \DB::table('bookings')->where('agent_id','=',$agent_id)->get();
            $data = \DB::table('bookings')->where('hotel_makkah_booking_status','=',$status)->orwhere('hotel_madina_booking_status','=',$status)->orwhere('transfer_booking_status','=',$status)->get();
            $data = \DB::table('bookings')->whereBetween('created_at',[$date_from,$date_to])->get();
        }
        elseif(!empty($date_from) && !empty($date_to) && empty($agent_id) && empty($status))
        {
            $data = \DB::table('bookings')->whereBetween('created_at',[$date_from,$date_to])->get();

        }
        elseif(!empty($agent_id) && empty($date_from) && empty($date_to) && empty($status))
        {
            $data = \DB::table('bookings')->where('agent_id','=',$agent_id)->get();

        }
        elseif(empty($agent_id) && empty($date_from) && empty($date_to) && !empty($status))
        {
            $data = \DB::table('bookings')->get();
//        print_r($data);
//        die();
        }
        elseif (!empty($agent_id) && !empty($date_from) && !empty($date_to) && empty($status))
        {
            $data = \DB::table('bookings')->where('agent_id','=',$agent_id)->get();
            $data = \DB::table('bookings')->whereBetween('created_at',[$date_from,$date_to])->get();

        }
        elseif (!empty($agent_id) && empty($date_from) && empty($date_to) && !empty($status))
        {
            $data = \DB::table('bookings')->where('agent_id','=',$agent_id)->get();
            $data = \DB::table('bookings')->where('hotel_makkah_booking_status','=',$status)->orwhere('hotel_madina_booking_status','=',$status)->orwhere('transfer_booking_status','=',$status)->get();

        }
        elseif (empty($agent_id) && !empty($date_from) && !empty($date_to) && !empty($status))
        {
            $data = \DB::table('bookings')->whereBetween('created_at',[$date_from,$date_to])->get();
            $data = \DB::table('bookings')->where('hotel_makkah_booking_status','=',$status)->orwhere('hotel_madina_booking_status','=',$status)->orwhere('transfer_booking_status','=',$status)->get();

        }

        $get_agents_country = \DB::table('agents')->get();

        return view('template/frontend/userdashboard/pages/b2bbookings',compact('data','get_agents_country','status','b2b_notification','data_b2b','agent_active'));

    }

    public function findCityName(Request $request)
    {
        $data = \DB::table('agents')->select('city', 'id')->where('country', $request->city)->get();

        return response()->json($data);//then sent this data to ajax success

    }
    public function getCategory($agent_id)
    {
        $data = \DB::table('agents')->select('first_name','id')->where('id',$agent_id)->get();
        return response()->json($data);
    }

    public function hotel_makkah()
    {
    	$email=Auth::guard('agent')->user()->email;
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        $b2b_hotel_makkah = \DB::table('bookings')->where('hotel_makkah_brn','!=','no_makkah')->where('agent_email',$email)->get();
       // print_r($b2b_hotel_makkah);die();
        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/b2b/hotel_makkah',compact('b2b_notification','b2b_hotel_makkah','data_b2b','agent_active'));
    }
    public function hotel_madina()
    {
         $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    $email=Auth::guard('agent')->user()->email;	
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        $b2b_hotel_madina = DB::table('bookings')->where('hotel_madina_brn','!=','no_madina')->where('agent_email',$email)->get();

  // print_r( $b2b_hotel_madina);
  //       die();


        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/b2b/hotel_madina',compact('b2b_notification','b2b_hotel_madina','data_b2b','agent_active'));
    }
    public function transfer_b2b()
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	$email=Auth::guard('agent')->user()->email;
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        $b2b_transfer = \DB::table('bookings')->where('transfer_brn','!=','no_transfer')->where('agent_email',$email)->get();



        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/b2b/transfer',compact('b2b_notification','b2b_transfer','data_b2b','agent_active'));
    }

    
    
   
    
    





    
    
    
    
    
    

    public function ledger()
    {
    	$login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/ledger',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function incomestatement()
    {
    	$login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/income_statement',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function notebook()
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/note_book',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function trailblance()
    {
     $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();	
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/trail_balance',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function blancesheet()
    {
    	$login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/balance_sheet',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function income()
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/income',compact('b2b_notification','data_b2b','agent_active'));
    }
    public function expense()
    {
         $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();



        return view('template/frontend/userdashboard/pages/accounts/expense',compact('b2b_notification','data_b2b','agent_active'));
    }


    public function b2b_arrival_details(Request $request)
    {
        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	$email=Auth::guard('agent')->user()->email;
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));

        // print_r($first_day_of_this_month);
        //    print_r($last_day_of_this_month);
        // die();
        $arrival_detail= \DB::table('bookings')->
        wherebetween('checkin', [$first_day_of_this_month,$last_day_of_this_month])->where('agent_email',$email)->orderBy('id', 'DESC')->get();
        //    print_r( $arrival_detail);
        // die();
        $current_week = $this->getCurrentWeek();
        $arrival_detail_week= \DB::table('bookings')->
        wherebetween('checkin', [$current_week['first_day'],$current_week['last_day']])->where('agent_email',$email)->orderBy('id', 'DESC')->get();

        $arrival_detail_today= \DB::table('bookings')->
        where('checkin','=',date('y-m-d'))->where('agent_email',$email)->orderBy('id', 'DESC')->get();

        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$email)->get();
        return view('template/frontend/userdashboard/pages/b2b/arrival_details',compact('arrival_detail_today','arrival_detail_week','arrival_detail','b2b_notification','data_b2b','agent_active'));
    }
    public function b2b_depature_details()
    {
         $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
    	$email=Auth::guard('agent')->user()->email;
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$email)->get();



        $first_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-01')));
        $last_day_of_this_month = date('Y-m-d',strtotime(date('Y-m-t')));
        $departure_detail= \DB::table('bookings')->
        wherebetween('checkout', [$first_day_of_this_month,$last_day_of_this_month])->where('agent_email',$email)->orderBy('id', 'DESC')->get();

        $current_week = $this->getCurrentWeek();
        $departure_detail_week= \DB::table('bookings')->
        wherebetween('checkout', [$current_week['first_day'],$current_week['last_day']])->where('agent_email',$email)->orderBy('id', 'DESC')->get();

        $departure_detail_today= \DB::table('bookings')->
        where('checkout','=',date('y-m-d'))->where('agent_email',$email)->orderBy('id', 'DESC')->get();


        
        
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->where('agent_email',$email)->get();
        return view('template/frontend/userdashboard/pages/b2b/depature_details',compact('departure_detail_today','departure_detail_week','departure_detail','b2b_notification','data_b2b','agent_active'));
    }
    

        public function lead_passenger_location()
            {
            	 $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
                $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        $location=Lead_Passenger_location::all();
        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/lead_passenger_location',compact('location','b2b_notification','data_b2b','agent_active'));

            }

public function addaccount()
            {
                $countries = DB::table('countries')->get();
                 $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
                $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


        
        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/subaccount/addaccount',compact('countries','b2b_notification','data_b2b','agent_active'));

            }

            public function submitaccount(Request $request)
            {
                // $this->validate($request,
            // ['name'=>'required',
    //          'email'=>'required',
    //          'phone'=>'required',
    //          'password'=>'required',
    //          'cpassword'=>'required',

            // ]);

      $this->validate($request,
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:agents|max:255',
                'phone_no' => 'required',
                'country_code' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'country' => 'required',
                'city' => 'required',
                'title' => 'required',
                'passport_no' => 'required',
                'commercial_register_number' => 'required',
                'license_number' => 'required',
                 'iban' => 'required|unique:agents'

            ]
        );


$login_id=Auth::guard('agent')->user()->id;

         $agent=new Agent();
         $agent->company_name=$request->input('company_name');
         $agent->title=$request->input('title');
         $agent->first_name=$request->input('first_name');
         $agent->last_name=$request->input('last_name');
         $agent->email=$request->input('email');
         $agent->country=$request->input('country');
         $agent->city=$request->input('city');
         $agent->phone_no=$request->input('country_code').' '.$request->input('phone_no');
         $agent->verification_code = rand();
         $agent->iban = $request->input('iban');
          $agent->passport_no = $request->input('passport_no');
          $agent->parent_id =$login_id;
         $agent->commercial_register_number = $request->input('commercial_register_number');
         $agent->license_number = $request->input('license_number');
         $agent->email_verified_at = 1;



         if($request->input('password')==$request->input('confirm_password'))
         {
         $agent->password=Hash::make ($request->input('password'));
         }
         else
         {
            return redirect()->back()->with('message','password does not match!!');
         }

          $save =  $agent->save();
           return redirect()->back()->with('message','Data Added');


            }
                  public function viewaccount()
            {
                 $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
                $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

$login_id=Auth::guard('agent')->user()->id;
        $viewaccount=Agent::orderBy('id', 'DESC')->where('parent_id',$login_id)->get();
        // print_r($viewaccount);
        // die();
        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/subaccount/viewaccount',compact('viewaccount','b2b_notification','data_b2b','agent_active'));

            }




public function loginaccount()
            {
                
        return view('template/frontend/userdashboard/pages/subaccount/login');

            }
            public function loginaccount_submit(Request $request)
            {
                
      $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required',

            ]);



        $login= $request->only('email','password');

//        $users = Agent::where('id','1')->get();
//        Notification::send($users, new TaskComplete($login));

        if(Auth::guard('agent')->attempt($login))
        {
            return redirect('agent_dashboard');
        }

        else
        {
            return redirect()->back()->with('error','Email or password is not correct!!');
        }

            }
            public function account_logout()
    {
        Auth::guard('agent')->logout();
        return redirect('index');


    }

    public function add_message(Request $request,$id)
    {
        $this->validate($request,
            [
                'messages' => 'required',
            ]
        );

        $agent_id=Auth::guard('agent')->user()->id;
         $agent_name=Auth::guard('agent')->user()->company_name;

        // $admin_id=Auth::guard('web')->user()->id;
        $date=date('Y-m-d');
         $dateTime = new DateTime('now', new DateTimeZone('Asia/Karachi'));
            $current_t =$dateTime->format("H:i A");
$agent_find_id=Agent::find($id);
            if($agent_find_id)
            {
                $agent=new Message();
                $agent->agent_id=$agent_id;
                $agent->agent_name=$agent_name;
                $agent->messages=$request->messages;
                $agent->date=$date;
                $agent->time=$current_t;
                $agent->save();
                 $request->session()->flash('success','Your Message Successful!');
                 return redirect('agent_dashboard/view_message');
            }
            

                
            
         
         
    }
    public function add_message_1(Request $request)
    {
        $this->validate($request,
            [
                'messages' => 'required',
            ]
        );

        $agent_id=Auth::guard('agent')->user()->id;
         $agent_name=Auth::guard('agent')->user()->company_name;

        // $admin_id=Auth::guard('web')->user()->id;
        $date=date('Y-m-d');
         $dateTime = new DateTime('now', new DateTimeZone('Asia/Karachi'));
            $current_t =$dateTime->format("H:i A");

                $agent=new Message();
                $agent->agent_id=$agent_id;
                $agent->agent_name=$agent_name;
                $agent->messages=$request->messages;
                $agent->date=$date;
                $agent->time=$current_t;
                $agent->save();
                 $request->session()->flash('success','Your Message Successful!');
                 return redirect('agent_dashboard/view_message');
           
            

                
            
         
         
    }

   public function view_message(Request $request)
   {
    $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
                $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

$message=Message::all();
        // print_r($viewaccount);
        // die();
        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/support_ticket/view_message',compact('message','b2b_notification','data_b2b','agent_active'));

   }

   public function agent_settings()
            {
                 $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
                $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

                $agent_id=Auth::guard('agent')->user()->id;
                $agent_parent_id=Auth::guard('agent')->user()->parent_id;
$get_markup = DB::table('agent_markups')->where('agent_id',$agent_id)->where('parent_id',$agent_parent_id)->first();


   if(isset($get_markup->id))
   {
    $get_id=$get_markup->id;
   }
   else
   {
    $get_id = '';
   }





// print_r($get_markup);
// die();
        
       
        $b2b_notification = \DB::table('bookings')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/markup/agent_markup',compact('get_id','get_markup','b2b_notification','data_b2b','agent_active'));

            }

            public function agent_markup_submit(Request $request)
            {
                $agent_markup=new AgentMarkup();
                $agent_markup->agent_id=$request->agent_id;
                $agent_markup->parent_id=$request->parent_id;
                $agent_markup->makkah_markup_type=$request->makkah_markup_type;
                $agent_markup->madina_markup_type=$request->madina_markup_type;
                $agent_markup->transfer_markup_type=$request->transfer_markup_type;
                $agent_markup->makkah_amount=$request->makkah_amount;
                $agent_markup->madina_amount=$request->madina_amount;
                $agent_markup->transfer_amount=$request->transfer_amount;
                 $agent_markup->makkah_markup_amount_vat=$request->makkah_markup_amount_vat;
                $agent_markup->madina_markup_amount_vat=$request->madina_markup_amount_vat;
                $agent_markup->transfer_markup_amount_vat=$request->transfer_markup_amount_vat;
                $agent_markup->save();
                return redirect()->back()->with('message','Agent Markup Added Successful!');

            }
            public function agent_markup_update(Request $request,$id)
            {
                // $id=Auth::guard('agent')->user()->id;
                $agent_markup=AgentMarkup::find($id);
                if($agent_markup)
                {
                     $agent_markup->agent_id=$request->agent_id;
                $agent_markup->parent_id=$request->parent_id;
                $agent_markup->makkah_markup_type=$request->makkah_markup_type;
                $agent_markup->madina_markup_type=$request->madina_markup_type;
                $agent_markup->transfer_markup_type=$request->transfer_markup_type;
                $agent_markup->makkah_amount=$request->makkah_amount;
                $agent_markup->madina_amount=$request->madina_amount;
                $agent_markup->transfer_amount=$request->transfer_amount;
                 $agent_markup->makkah_markup_amount_vat=$request->makkah_markup_amount_vat;
                $agent_markup->madina_markup_amount_vat=$request->madina_markup_amount_vat;
                $agent_markup->transfer_markup_amount_vat=$request->transfer_markup_amount_vat;
                $agent_markup->save();
               
                }
               
 return redirect()->back()->with('message','Agent Markup Updated Successful!');
            }




}
      