<?php

namespace App\Http\Controllers\frontend\user_dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api;
use DB;
use Session;
use App\Models\Booking;
use \App\Mail\SendMail;
use \App\Mail\SendMailVisa;
use \App\Mail\SendMailInvoice;
use Illuminate\Support\Facades\Crypt;

use Hash;

use App\User;


class BookingController extends Controller
{

    // public $url = 'https://umrahtech.com/api_b2c/3p_WL_Dashboard/api.php';
    public function __construct()
    {


    }


    public function booking_get(){




        $makkah_brn='no_makkah';
        $madina_brn='no_madina';

        $transfer_brn='no_transfer';

        $ground_brn='no_ground';


        $hotel_makkah_info_token='';
        $hotel_madina_info_token='';
        $transfer_info_token='';
        $ground_service_info_token='';


        $hotel_makkah_booking_status='';
        $hotel_madina_booking_status='';
        $transfer_booking_status='';
        $ground_service_booking_status='';


        $hotel_makkah_checkavailability='';
        $hotel_madinah_checkavailability='';
        $transfer_checkavailability='';
        $ground_service_checkavailability='';










        $routeCode = Session::get('routeCode');



        $totalPassengers = Session::get('totalPassengers');
        $noOfVehicles = Session::get('noOfVehicles');
        $model_from = Session::get('model_from');
        $model_to = Session::get('model_to');



// print_r($routeCode);
// echo "<br>";
// print_r($totalPassengers);
// echo "<br>";
// print_r($noOfVehicles);
// echo "<br>";
// print_r($model_from);
// echo "<br>";
// print_r($model_to);

// die;




//              print_r($firstname);
//              echo "<br>";

//              print_r($lastname);
//              echo "<br>";

//              print_r($email);
//              echo "<br>";

//              print_r($nationality);
//              echo "<br>";

//              print_r($residence);
//              echo "<br>";

//              print_r($gender);
//              echo "<br>";

//              print_r($phone_no);
//              echo "<br>";

//              print_r($date_of_birth);
//              echo "<br>";

//              print_r($passport_no);
//              echo "<br>";

//              print_r($passport_expiry);
//              echo "<br>";




// die;



        $invoice_no=Session::get('invoice_no');
        $ref_no=Session::get('invoice_no');


        $booking = DB::table('passenger_details')->where('invoice_no', $invoice_no)->first();

        // print_r($booking);die;
        $other_passenger_details=json_decode($booking->other_passengers);

        $lead_passenger_details=json_decode($booking->lead_passenger);

//






        $firstname = $lead_passenger_details->firstname;
        $lastname = $lead_passenger_details->lastname;
        $lead_passenger_email =$lead_passenger_details->email;
        $lead_passenger_nationality ='EG';
        $lead_passenger_residence ='EG';
        $lead_passenger_gender =$lead_passenger_details->genders;
        $lead_passenger_contact =$lead_passenger_details->phone_no;
        $lead_passenger_date_of_birth =$lead_passenger_details->dateofbirths;
        $lead_passenger_passport_no =$lead_passenger_details->passportnos;


        $lead_passenger_passport_expiry =$lead_passenger_details->PASSPORT_EXPIRY_DATE;








// print_r(json_encode($lead_passenger_details));die;
        $lead_passenger_details=json_encode($lead_passenger_details);




// $lead_passenger_details=json_encode($lead_passenger_details);





//  if(!Session::has('passengerdetails')){



//       $other_passenger_details =array(

//      0  =>  array('dateofbirths' => '1990-01-01','passportnos'=>'987654321','genders' => 'M', 'PASSPORT_EXPIRY_DATE' => '2023-04-13','mehrampassport' => '','firstname' => 'ar', 'lastname' => 'khan', 'email' => 'ar@umrahtech.com', 'phone_no' => '11223344', 'nationality_id' => 20, 'country_id' => 20)
//  );

//  }else{


// $other_passenger_details=Session::get('passengerdetails');

// }


        $other_passenger_details=json_encode($other_passenger_details);







        $hotel_makkah_total_amount = '';
        $hotel_madina_total_amount = '';
        $transfer_total_amount = '';
        $ground_service_total_amount = '';



// echo $hotel_makkah_total_amount.'<br>';
// echo $hotel_madina_total_amount.'<br>';
// echo $transfer_total_amount.'<br>';
// echo $ground_service_total_amount.'<br>';

// die;

        $persons=Session::get('totalPassengers');

        $total_visa_fee=$persons * 300;

        $total_visa_fee = $total_visa_fee;


//   print_r($persons);
// echo "<br>";
//   print_r($total_visa_fee);

        // die;
        // $total_visa_fee = Session::get('total_visa_fee');
        $booking_grand_total = Session::get('grand_total');

// $total_visa_fee=000;
// $booking_grand_total=0000;

// print_r($total_visa_fee);
// echo "<br>";
// print_r($booking_grand_total);
// echo "<br>";
// die;
        if(Session::has('hotel_makkah_checkavailability')){

            $hotel_makkah_checkavailability=Session::get('hotel_makkah_checkavailability');

            function requesthudx($hotel_makkah_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_makkah_booking','obj'=>$hotel_makkah_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx($hotel_makkah_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $makkah_brn=$result->response->bookingReferenceNo;
                    $hotel_makkah_info_token=$result->info->token;

                    $hotel_makkah_booking_status='confirmed';

                }
                else{


                    $hotel_makkah_booking_status=$result->response->bookingStatus;

                }
            }else{


                $hotel_makkah_booking_status='failed';

            }


        }

        if(Session::has('hotel_madina_checkavailability')){

            $hotel_madina_checkavailability=Session::get('hotel_madina_checkavailability');

            function requesthudx1($hotel_madina_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_madina_booking','obj'=>$hotel_madina_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx1($hotel_madina_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){


                    $madina_brn=$result->response->bookingReferenceNo;
                    $hotel_madina_info_token=$result->info->token;

                    $hotel_madina_booking_status='confirmed';

                }else{
                    $hotel_madina_booking_status='confirmed';
                }
            }
            else{
                $hotel_madina_booking_status='failed';
            }



        }





        if(Session::has('transfer_checkavailability')){

            $transfer_checkavailability=Session::get('transfer_checkavailability');

            function requestrans($transfer_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'transfer_booking','obj'=>$transfer_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requestrans($transfer_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $transfer_brn=$result->response->bookingReferenceNo;
                    $transfer_info_token=$result->info->token;

                    $transfer_booking_status='confirmed';

                }else{

                    $transfer_booking_status='confirmed';
                }
            }else{

                $transfer_booking_status='failed';
            }





        }

        if(Session::has('groundcheckavailability')){




            $groundcheckavailability=Session::get('groundcheckavailability');
            $ground_service_checkavailability=$groundcheckavailability;

            function requestground($groundcheckavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'ground_booking','obj'=>$groundcheckavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requestground($groundcheckavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $ground_brn=$result->response->bookingReferenceNo;
                    $ground_service_info_token=$result->info->token;

                    $ground_service_booking_status='confirmed';


                }else{


                    $ground_service_booking_status='confirmed';

                }
            }else{


                $ground_service_booking_status='failed';

            }





        }




        $hotel_makkah_total_amount=Session::get('makkah_rate');
        $hotel_madina_total_amount=Session::get('madina_rate');
        $transfer_total_amount=Session::get('transfer_rate');
        $ground_service_total_amount=Session::get('ground_service_rate');


        $rooms_array=Session::get('passengers');






        $routeCode = Session::get('routeCode');



        $totalPassengers = Session::get('totalPassengers');
        $noOfVehicles = Session::get('noOfVehicles');
        $model_from = Session::get('model_from');
        $model_to = Session::get('model_to');





        function refference_no( $length ) {
            $chars = "01234567898765456092";
            $password = substr( str_shuffle( $chars ), 0, $length );
            return $password;
        }

        $invoice_no = refference_no(12);
        $platform='b2c';

        $total_passengers=Session::get('totalPassengers');
        $lead_passenger_name=$firstname.' '.$lastname;


        $ground_service_checkavailability=$groundcheckavailability;
        $checkin=Session::get('check_in_1');
        $checkout=Session::get('check_out_1');

        $booking_currency='SAR';
        $hotel_makkah_total_amount=$hotel_makkah_total_amount;
        $hotel_madina_total_amount=$hotel_madina_total_amount;
        $transfer_total_amount=$transfer_total_amount;
        $ground_service_total_amount=$ground_service_total_amount;


        $hotel_makkah_brn=$makkah_brn;
        $hotel_madina_brn=$madina_brn;
        $transfer_brn=$transfer_brn;
        $ground_service_brn=$ground_brn;




        $booking=new Booking();




        $booking->invoice_no=$invoice_no;
        $booking->platform=$platform;
        $booking->total_passengers=$total_passengers;
        $booking->lead_passenger_name=$lead_passenger_name;
        $booking->lead_passenger_email=$lead_passenger_email;
        $booking->lead_passenger_contact=$lead_passenger_contact;
        $booking->lead_passenger_nationality=$lead_passenger_nationality;
        $booking->lead_passenger_residence=$lead_passenger_residence;
        $booking->lead_passenger_gender=$lead_passenger_gender;
        $booking->lead_passenger_date_of_birth=$lead_passenger_date_of_birth;
        $booking->lead_passenger_passport_no=$lead_passenger_passport_no;
        $booking->lead_passenger_passport_expiry=$lead_passenger_passport_expiry;


        $booking->hotel_makkah_checkavailability=$hotel_makkah_checkavailability;
        $booking->hotel_madinah_checkavailability=$hotel_madinah_checkavailability;
        $booking->transfer_checkavailability=$transfer_checkavailability;
        $booking->ground_service_checkavailability=$ground_service_checkavailability;

        $booking->checkin=$checkin;
        $booking->checkout=$checkout;
        $booking->rooms_array=$rooms_array;


        $booking->routeCode=$routeCode;
        $booking->model_from=$model_from;
        $booking->model_to=$model_to;
        $booking->no_of_vehicles=$noOfVehicles;




        $booking->booking_currency=$booking_currency;
        $booking->hotel_makkah_total_amount=$hotel_makkah_total_amount;
        $booking->hotel_madina_total_amount=$hotel_madina_total_amount;
        $booking->transfer_total_amount=$transfer_total_amount;
        $booking->ground_service_total_amount=$ground_service_total_amount;

        $booking->hotel_makkah_brn=$hotel_makkah_brn;
        $booking->hotel_madina_brn=$hotel_madina_brn;
        $booking->transfer_brn=$transfer_brn;
        $booking->ground_service_brn=$ground_service_brn;

        $booking->hotel_makkah_info_token=$hotel_makkah_info_token;
        $booking->hotel_madina_info_token=$hotel_madina_info_token;
        $booking->transfer_info_token=$transfer_info_token;
        $booking->ground_service_info_token=$ground_service_info_token;

        $booking->hotel_makkah_booking_status=$hotel_makkah_booking_status;
        $booking->hotel_madina_booking_status=$hotel_madina_booking_status;
        $booking->transfer_booking_status=$transfer_booking_status;
        $booking->ground_service_booking_status=$ground_service_booking_status;



        $booking->lead_passenger_details=$lead_passenger_details;
        $booking->other_passenger_details=$other_passenger_details;

        $booking->total_visa_fee=$total_visa_fee;
        $booking->booking_grand_total=$booking_grand_total;


        // print_r($booking);

        $booking->save();




        Session::forget('passengerdetails');
        Session::forget('lead_passenger_details');
        Session::forget('select_madina');
        Session::forget('hotel_makkah_checkavailability');
        Session::forget('hotel_madina_checkavailability');
        Session::forget('transfer_checkavailability');
        Session::forget('groundcheckavailability');
        Session::forget('passengers');
        Session::forget('location');
        Session::forget('chech_in_1');
        Session::forget('chech_in_2');
        Session::forget('chech_out_1');
        Session::forget('chech_out_2');
        Session::forget('hotel_makkah_details');
        Session::forget('routeCode');
        Session::forget('noOfVehicles');
        Session::forget('nationality');
        Session::forget('residence');

        Session::forget('makkah_rooms_array');
        Session::forget('totalPassengers');
        Session::forget('noAdults');
        Session::forget('noChild');
        Session::forget('added_addional_services');
        Session::forget('invoice_no');







        return redirect('sendbookingmail/'.$invoice_no);




    }





    public function iframe_refresh(){


        $total = $_GET['telr_price'];

        $id = 'UmrahTech' . rand(1,100) . rand(1,1000);

        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '22696',
            'ivp_authkey' => 'dWv4-8WC77@5g4C5',
            'ivp_cart' => $id,
            'ivp_test' => '1',
            'ivp_framed' => '2',
            'ivp_amount' => $total,
            'ivp_currency' => 'SAR',
            'ivp_desc' => 'Umrah Tech Booking',
            'return_auth' => 'https://umrahtech.com/booking',
            'return_can' => 'https://umrahtech.com/booking',
            'return_decl' => 'https://umrahtech.com/booking'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        //curl_setopt($ch, CURLOPT_PORT , 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $results = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($results,true);
        $url= trim($results['order']['url']);
        if($url){
            echo $url;
        }else{
            echo 'error';
        }

    }










    public function booking_summary(){
        // Session::forget('passengerdetails');

//      $person_session=Session::get('passengerdetails');
//     print_r($person_session);

//     echo "<br>";

//     $lead_passenger_details=Session::get('lead_passenger_details');
//     print_r($lead_passenger_details);

// die;



        //   function request17() {
        //   $url ="https://umrahtech.com/umrahtechapi.php";
        //   $data = array('case' => 'authorized_hotels');
        //   $ch = curl_init();
        //   curl_setopt($ch, CURLOPT_URL, $url);
        //   curl_setopt($ch, CURLOPT_POST, true);
        //   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //   $responseData = curl_exec($ch);
        //   if(curl_errno($ch)) {
        //     return curl_error($ch);
        //   }
        //   curl_close($ch);
        //   return $responseData;
        //   }

        // $responseData2 = request17();
        //   $result2 = json_decode($responseData2);

        //  print_r($result2);die;






        function request2() {
// $url ="https://umrahtech.com/classes/apitransmoh.php";
            $url = "https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transportcompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request2();
        $transfer_company = json_decode($responseData2);
// print_r($transportcompanies);die;






        function requestuocompanies() {

            $url = "https://umrahtech.com/umrahtechapi.php";
// $url = "https://umrahtech.com/api_b2c/3p_third_party/third_party/uocompanies";
            $data = array('case' => 'uocompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
//var_dump($responseData);
//exit();
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;


        }
        $requocompanies = requestuocompanies();
// print_r($requocompanies);die;
        $ground_company = json_decode($requocompanies);
// print_r($uocompanies);die;














        return view('template/frontend/pages/booking_summary',compact('transfer_company','ground_company'));

    }




    public function checkout(){




        return view('template/frontend/pages/checkout');

    }


    public function booking(Request $request){



        $makkah_brn='no_makkah';
        $madina_brn='no_madina';

        $transfer_brn='no_transfer';

        $ground_brn='no_ground';


        $hotel_makkah_info_token='';
        $hotel_madina_info_token='';
        $transfer_info_token='';
        $ground_service_info_token='';


        $hotel_makkah_booking_status='';
        $hotel_madina_booking_status='';
        $transfer_booking_status='';
        $ground_service_booking_status='';


        $hotel_makkah_checkavailability='';
        $hotel_madinah_checkavailability='';
        $transfer_checkavailability='';
        $ground_service_checkavailability='';




        $firstname = $request->input('fname');
        $lastname = $request->input('lname');
        $lead_passenger_email = $request->input('email');
        $lead_passenger_nationality = $request->input('nationality');
        $lead_passenger_residence = $request->input('residence');
        $lead_passenger_gender = $request->input('gender');
        $lead_passenger_contact = $request->input('phone_no');
        $lead_passenger_date_of_birth = $request->input('date_of_birth');
        $lead_passenger_passport_no = $request->input('passport_no');


        $lead_passenger_passport_expiry = $request->input('passport_expiry');





        $date=$lead_passenger_date_of_birth;

        $change_format_date = explode("/",$date);
        $changed_date = $change_format_date[2].'/' .$change_format_date[0]. '/' .$change_format_date[1];
        $date =  str_replace("/", "-", $changed_date);
        // print_r($date);

        $lead_passenger_date_of_birth=$date;
// print_r($lead_passenger_date_of_birth);


// echo "<br>";




        $date=$lead_passenger_passport_expiry;

        $change_format_date = explode("/",$date);
        $changed_date = $change_format_date[2].'/' .$change_format_date[0]. '/' .$change_format_date[1];
        $date =  str_replace("/", "-", $changed_date);
        // print_r($date);

        $lead_passenger_passport_expiry=$date;
// print_r($lead_passenger_passport_expiry);
// die;








//              print_r($firstname);
//              echo "<br>";

//              print_r($lastname);
//              echo "<br>";

//              print_r($email);
//              echo "<br>";

//              print_r($nationality);
//              echo "<br>";

//              print_r($residence);
//              echo "<br>";

//              print_r($gender);
//              echo "<br>";

//              print_r($phone_no);
//              echo "<br>";

//              print_r($date_of_birth);
//              echo "<br>";

//              print_r($passport_no);
//              echo "<br>";

//              print_r($passport_expiry);
//              echo "<br>";




// die;


        $lead_passenger_details = array('firstname' => $firstname, 'lastname' => $lastname,'email'=>$lead_passenger_email,'nationality'=>$lead_passenger_nationality,'residence'=>$lead_passenger_residence,'gender' => $lead_passenger_gender,'phone_no'=>$lead_passenger_contact,'date_of_birth' => $lead_passenger_date_of_birth,'passport_no'=>$lead_passenger_passport_no, 'passport_expiry' => $lead_passenger_passport_expiry);

// print_r(json_encode($lead_passenger_details));die;
        $lead_passenger_details=json_encode($lead_passenger_details);

        $other_passenger_details=Session::get('passengerdetails');


        $other_passenger_details=json_encode($other_passenger_details);

        $hotel_makkah_total_amount = $request->input('hotel_makkah_total_amount');
        $hotel_madina_total_amount = $request->input('hotel_madina_total_amount');
        $transfer_total_amount = $request->input('transfer_total_amount');
        $ground_service_total_amount = $request->input('ground_service_total_amount');



// echo $hotel_makkah_total_amount.'<br>';
// echo $hotel_madina_total_amount.'<br>';
// echo $transfer_total_amount.'<br>';
// echo $ground_service_total_amount.'<br>';

// die;
        $total_visa_fee = $request->input('input_visa_fee');
        $booking_grand_total = $request->input('input_total_price');

// $total_visa_fee=000;
// $booking_grand_total=0000;



        if(Session::has('hotel_makkah_checkavailability')){

            $hotel_makkah_checkavailability=Session::get('hotel_makkah_checkavailability');

            function requesthudx($hotel_makkah_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_makkah_booking','obj'=>$hotel_makkah_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx($hotel_makkah_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $makkah_brn=$result->response->bookingReferenceNo;
                    $hotel_makkah_info_token=$result->info->token;

                    $hotel_makkah_booking_status='confirmed';

                }
                else{


                    $hotel_makkah_booking_status=$result->response->bookingStatus;

                }
            }else{


                $hotel_makkah_booking_status='failed';

            }


        }

        if(Session::has('hotel_madina_checkavailability')){

            $hotel_madina_checkavailability=Session::get('hotel_madina_checkavailability');

            function requesthudx1($hotel_madina_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_madina_booking','obj'=>$hotel_madina_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx1($hotel_madina_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){


                    $madina_brn=$result->response->bookingReferenceNo;
                    $hotel_madina_info_token=$result->info->token;

                    $hotel_madina_booking_status='confirmed';

                }else{
                    $hotel_madina_booking_status='confirmed';
                }
            }
            else{
                $hotel_madina_booking_status='failed';
            }



        }





        if(Session::has('transfer_checkavailability')){

            $transfer_checkavailability=Session::get('transfer_checkavailability');

            function requestrans($transfer_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'transfer_booking','obj'=>$transfer_checkavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requestrans($transfer_checkavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $transfer_brn=$result->response->bookingReferenceNo;
                    $transfer_info_token=$result->info->token;

                    $transfer_booking_status='confirmed';

                }else{

                    $transfer_booking_status='confirmed';
                }
            }else{

                $transfer_booking_status='failed';
            }





        }

        if(Session::has('groundcheckavailability')){




            $groundcheckavailability=Session::get('groundcheckavailability');
            $ground_service_checkavailability=$groundcheckavailability;

            function requestground($groundcheckavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'ground_booking','obj'=>$groundcheckavailability,'firstname'=>$firstname,'lastname'=>$lastname,'lead_passenger_email'=>$lead_passenger_email,'lead_passenger_gender'=>$lead_passenger_gender,'lead_passenger_contact'=>$lead_passenger_contact,'lead_passenger_date_of_birth'=>$lead_passenger_date_of_birth,'lead_passenger_passport_no'=>$lead_passenger_passport_no,'lead_passenger_nationality'=>$lead_passenger_nationality);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requestground($groundcheckavailability,$firstname,$lastname,$lead_passenger_email,$lead_passenger_gender,$lead_passenger_contact,$lead_passenger_date_of_birth,$lead_passenger_passport_no,$lead_passenger_nationality);
            $result = json_decode($responseData2);

            // print_r($responseData2);die;

            if(isset($result->response->bookingStatus)){
                if($result->response->bookingStatus == 'Confirmed'){

                    $ground_brn=$result->response->bookingReferenceNo;
                    $ground_service_info_token=$result->info->token;

                    $ground_service_booking_status='confirmed';


                }else{


                    $ground_service_booking_status='confirmed';

                }
            }else{


                $ground_service_booking_status='failed';

            }





        }








        function refference_no( $length ) {
            $chars = "01234567898764572807";
            $password = substr( str_shuffle( $chars ), 0, $length );
            return $password;
        }

        $invoice_no = refference_no(20);
        $platform='b2c';

        $total_passengers=Session::get('totalPassengers');
        $lead_passenger_name=$firstname.' '.$lastname;


        $ground_service_checkavailability=$groundcheckavailability;
        $checkin=Session::get('check_in_1');
        $checkout=Session::get('check_out_1');

        $booking_currency='SAR';
        $hotel_makkah_total_amount=$hotel_makkah_total_amount;
        $hotel_madina_total_amount=$hotel_madina_total_amount;
        $transfer_total_amount=$transfer_total_amount;
        $ground_service_total_amount=$ground_service_total_amount;


        $hotel_makkah_brn=$makkah_brn;
        $hotel_madina_brn=$madina_brn;
        $transfer_brn=$transfer_brn;
        $ground_service_brn=$ground_brn;




        $booking=new Booking();




        $booking->invoice_no=$invoice_no;
        $booking->platform=$platform;
        $booking->total_passengers=$total_passengers;
        $booking->lead_passenger_name=$lead_passenger_name;
        $booking->lead_passenger_email=$lead_passenger_email;
        $booking->lead_passenger_contact=$lead_passenger_contact;
        $booking->lead_passenger_nationality=$lead_passenger_nationality;
        $booking->lead_passenger_residence=$lead_passenger_residence;
        $booking->lead_passenger_gender=$lead_passenger_gender;
        $booking->lead_passenger_date_of_birth=$lead_passenger_date_of_birth;
        $booking->lead_passenger_passport_no=$lead_passenger_passport_no;
        $booking->lead_passenger_passport_expiry=$lead_passenger_passport_expiry;


        $booking->hotel_makkah_checkavailability=$hotel_makkah_checkavailability;
        $booking->hotel_madinah_checkavailability=$hotel_madinah_checkavailability;
        $booking->transfer_checkavailability=$transfer_checkavailability;
        $booking->ground_service_checkavailability=$ground_service_checkavailability;

        $booking->checkin=$checkin;
        $booking->checkout=$checkout;


        $booking->booking_currency=$booking_currency;
        $booking->hotel_makkah_total_amount=$hotel_makkah_total_amount;
        $booking->hotel_madina_total_amount=$hotel_madina_total_amount;
        $booking->transfer_total_amount=$transfer_total_amount;
        $booking->ground_service_total_amount=$ground_service_total_amount;

        $booking->hotel_makkah_brn=$hotel_makkah_brn;
        $booking->hotel_madina_brn=$hotel_madina_brn;
        $booking->transfer_brn=$transfer_brn;
        $booking->ground_service_brn=$ground_service_brn;

        $booking->hotel_makkah_info_token=$hotel_makkah_info_token;
        $booking->hotel_madina_info_token=$hotel_madina_info_token;
        $booking->transfer_info_token=$transfer_info_token;
        $booking->ground_service_info_token=$ground_service_info_token;

        $booking->hotel_makkah_booking_status=$hotel_makkah_booking_status;
        $booking->hotel_madina_booking_status=$hotel_madina_booking_status;
        $booking->transfer_booking_status=$transfer_booking_status;
        $booking->ground_service_booking_status=$ground_service_booking_status;



        $booking->lead_passenger_details=$lead_passenger_details;
        $booking->other_passenger_details=$other_passenger_details;

        $booking->total_visa_fee=$total_visa_fee;
        $booking->booking_grand_total=$booking_grand_total;


        // print_r($booking);

        $booking->save();




        Session::forget('passengerdetails');
        Session::forget('lead_passenger_details');
        Session::forget('select_madina');
        Session::forget('hotel_makkah_checkavailability');
        Session::forget('hotel_madina_checkavailability');
        Session::forget('transfer_checkavailability');
        Session::forget('groundcheckavailability');
        Session::forget('passengers');
        Session::forget('location');
        Session::forget('chech_in_1');
        Session::forget('chech_in_2');
        Session::forget('chech_out_1');
        Session::forget('chech_out_2');
        Session::forget('hotel_makkah_details');
        Session::forget('routeCode');
        Session::forget('noOfVehicles');
        Session::forget('nationality');
        Session::forget('residence');

        Session::forget('makkah_rooms_array');
        Session::forget('totalPassengers');
        Session::forget('noAdults');
        Session::forget('noChild');
        Session::forget('added_addional_services');







        return redirect('sendbookingmail/'.$invoice_no);





// return view('template/frontend/pages/checkout');

    }




    public function sendbookingmail($id){






        $this->bookings= Booking::orderBy('id', 'DESC')->where('invoice_no',$id)->get();

        $data=(array)$this;



        // print_r($data['bookings'][0]->total_visa_fee);die;$data['bookings'][0]->

        $makkah_brn=$data['bookings'][0]->hotel_makkah_brn;
        $madina_brn=$data['bookings'][0]->hotel_madina_brn;
        $transfer_brn=$data['bookings'][0]->transfer_brn;
        $ground_brn=$data['bookings'][0]->ground_service_brn;


        $hotel_company='';
        $transfer_company='';
        $ground_company='';




        if($madina_brn == 'no_madina'){


            $hotel_madina='';
        }else{





            function requesthudx1($madina_brn) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_madina_view_booking','madina_brn'=>$madina_brn);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx1($madina_brn);
            $hotel_madina = json_decode($responseData2);

            // print_r($responseData2);die;

// echo "yes madina";

        }



        function requesthudx($makkah_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'hotel_makkah_view_booking','makkah_brn'=>$makkah_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesthudx($makkah_brn);
        $hotel_makkah = json_decode($responseData2);

        // print_r($responseData2);die;




        function requesttransfers($transfer_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transfers_view_booking','transfer_brn'=>$transfer_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesttransfers($transfer_brn);
        $transfer = json_decode($responseData2);

        // print_r($responseData2);die;







        function requestground($ground_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'ground_view_booking','ground_brn'=>$ground_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requestground($ground_brn);
        $ground_services = json_decode($responseData2);

        // print_r($responseData2);die;


        $this->bookings= Booking::orderBy('id', 'DESC')->where('hotel_makkah_brn',$makkah_brn)->get();

        $data=(array)$this;



        Session::forget('new_user');




        $email=$data['bookings'][0]->lead_passenger_email;



        function refference_no( $length ) {
            $chars = "473abc29um";
            $password = substr( str_shuffle( $chars ), 0, $length );
            return $password;
        }

        $password = refference_no(10);


        $olduser = DB::table('users')->where('email', $email)->first();

// print_r($olduser);die;




        $users = User::where('email', '=', $email)->first();
        if ($users === null) {


            $user=new User();
            $user->name=$data['bookings'][0]->lead_passenger_name;
            $user->email=$data['bookings'][0]->lead_passenger_email;
            $user->phone=00000000;


            $user->password=Hash::make ($password);

            $user->save();



            Session::put('new_user','new_user');
            Session::save();




        }










// foreach ($data['bookings'] as $data) {

//  print_r($data->total_visa_fee);
//  die;
// }
        if(isset($hotel_makkah->errors)){
            echo $hotel_makkah->errors[0]->message . ' Please Contact UmrahTech Team';
            die;
        }

        if(isset($hotel_makkah->response->bookingReferenceNo)){
            $brn_makkah = $hotel_makkah->response->bookingReferenceNo;
        }else{
            $brn_makkah = 'no_makkah';
        }
        if(isset($hotel_madina->response->bookingReferenceNo)){
            $brn_madina = $hotel_madina->response->bookingReferenceNo;
        }else{
            $brn_madina = 'no_madina';
        }
        if(isset($transfer->response->reservationNo)){
            $brn_transfer = $transfer->response->reservationNo;
        }else{
            $brn_transfer = 'no_transfer';
        }
        if(isset($ground_services->response->reservationNo)){
            $brn_ground_service = $ground_services->response->reservationNo;
        }else{
            $brn_ground_service = 'no_ground';
        }
        $email = $data['bookings'][0]->lead_passenger_email;
        $details = [
            'title' => 'Booking Confirmation from Umrah Tech',
            'html' => 'emails.sendmail',
            'hotel_reference' => $hotel_makkah->response->bookingReferenceNo ?? '',
            'first_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->firstName ?? '',
            'last_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->lastName ?? '',
            'gender' =>  $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->gender ?? '',
            'phone' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->contactInformation->phoneNumber ?? '',
            'nationality' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->location->countryCode ?? '',
            'dob' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->birthDate ?? '',
            'hotel_makkah_title' => $hotel_makkah->response->hotelDetails->name ?? '',
            'checkin_makkah' => $hotel_makkah->response->hotelDetails->checkInTime ?? '',
            'checkout_makkah' => $hotel_makkah->response->hotelDetails->checkOutTime ?? '',
            'vendor_makkah' =>  $hotel_makkah->response->hotelDetails->vendor ?? '',
            'provider_makkah' => $hotel_makkah->response->hotelDetails->provider ?? '',
            'roomGroups_makkah' => $hotel_makkah->response->hotelDetails->roomGroups ?? '',
            'hotel_reference_madina' => $hotel_madina->response->bookingReferenceNo ?? '',
            'first_name_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->firstName ?? '',
            'last_name_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->lastName ?? '',
            'gender_madina' =>  $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->gender ?? '',
            'phone_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->contactInformation->phoneNumber ?? '',
            'nationality_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->location->countryCode ?? '',
            'dob_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->birthDate ?? '',
            'hotel_madina_title' => $hotel_madina->response->hotelDetails->name ?? '',
            'checkin_madina' => $hotel_madina->response->hotelDetails->checkInTime ?? '',
            'checkout_madina' => $hotel_madina->response->hotelDetails->checkOutTime ?? '',
            'vendor_madina' =>  $hotel_madina->response->hotelDetails->vendor ?? '',
            'provider_madina' => $hotel_madina->response->hotelDetails->provider ?? '',
            'roomGroups_madina' => $hotel_madina->response->hotelDetails->roomGroups ?? '',
            'transfer' => $transfer ?? '',
            'ground_service' => $ground_services ?? '',
            'visa_fee' => $data['bookings'][0]->total_visa_fee ?? '',
            'link' => 'https://umrahtech.com/voucher/'. $id,
            'password' => $password,
            'email_login' => $email,

        ];


        $details_invoice = [
            'title' => 'Booking Confirmation from Umrah Tech',
            'html' => 'emails.sendmailinvoice',
            'hotel_reference' => $hotel_makkah->response->bookingReferenceNo ?? '',
            'first_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->firstName ?? '',
            'last_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->lastName ?? '',
            'gender' =>  $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->gender ?? '',
            'phone' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->contactInformation->phoneNumber ?? '',
            'nationality' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->location->countryCode ?? '',
            'dob' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->birthDate ?? '',
            'hotel_makkah_title' => $hotel_makkah->response->hotelDetails->name ?? '',
            'checkin_makkah' => $hotel_makkah->response->hotelDetails->checkInTime ?? '',
            'checkout_makkah' => $hotel_makkah->response->hotelDetails->checkOutTime ?? '',
            'vendor_makkah' =>  $hotel_makkah->response->hotelDetails->vendor ?? '',
            'provider_makkah' => $hotel_makkah->response->hotelDetails->provider ?? '',
            'roomGroups_makkah' => $hotel_makkah->response->hotelDetails->roomGroups ?? '',
            'hotel_reference_madina' => $hotel_madina->response->bookingReferenceNo ?? '',
            'first_name_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->firstName ?? '',
            'last_name_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->lastName ?? '',
            'gender_madina' =>  $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->gender ?? '',
            'phone_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->contactInformation->phoneNumber ?? '',
            'nationality_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->location->countryCode ?? '',
            'dob_madina' => $hotel_madina->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->birthDate ?? '',
            'hotel_madina_title' => $hotel_madina->response->hotelDetails->name ?? '',
            'checkin_madina' => $hotel_madina->response->hotelDetails->checkInTime ?? '',
            'checkout_madina' => $hotel_madina->response->hotelDetails->checkOutTime ?? '',
            'vendor_madina' =>  $hotel_madina->response->hotelDetails->vendor ?? '',
            'provider_madina' => $hotel_madina->response->hotelDetails->provider ?? '',
            'roomGroups_madina' => $hotel_madina->response->hotelDetails->roomGroups ?? '',
            'hotel_madina' => $hotel_madina,
            'transfer' => $transfer ?? '',
            'ground_service' => $ground_services ?? '',
            'visa_fee' => $data['bookings'][0]->total_visa_fee ?? '',
            'link' => 'https://umrahtech.com/invoice/'. $id

        ];
        $details_visa = [
            'title' => 'Booking Confirmation from Umrah Tech',
            'html' => 'emails.sendmailvisa',
            'hotel_reference' => $hotel_makkah->response->bookingReferenceNo ?? '',
            'first_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->firstName ?? '',
            'last_name' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->lastName ?? '',
            'gender' =>  $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->gender ?? '',
            'phone' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->contactInformation->phoneNumber ?? '',
            'nationality' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->location->countryCode ?? '',
            'dob' => $hotel_makkah->response->hotelDetails->roomGroups[0]->rooms[0]->travellerDetails[0]->details->birthDate ?? '',
            'hotel_makkah_title' => $hotel_makkah->response->hotelDetails->name ?? '',
            'checkin_makkah' => $hotel_makkah->response->hotelDetails->checkInTime ?? '',
            'checkout_makkah' => $hotel_makkah->response->hotelDetails->checkOutTime ?? '',
            'vendor_makkah' =>  $hotel_makkah->response->hotelDetails->vendor ?? '',
            'provider_makkah' => $hotel_makkah->response->hotelDetails->provider ?? '',
            'roomGroups_makkah' => $hotel_makkah->response->hotelDetails->roomGroups ?? '',
            'transfer' => $transfer ?? '',
            'ground_service' => $ground_services ?? '',
            'visa_fee' => $data['bookings'][0]->total_visa_fee ?? '',
            'link' => 'https://umrahtech.com/visa_form/'. $id

        ];



//     if(isset($details['roomGroups_madina']) && $details['roomGroups_madina'] != ''){

//       echo "madina set ha ";die;

//     }else{

//       echo "madina set nai ha";die;
//     }

// print_r($details['roomGroups_madina']);die;





        \Mail::to($email)->send(new SendMail($details));
        \Mail::to($email)->send(new SendMailInvoice($details_invoice));
        \Mail::to($email)->send(new SendMailVisa($details_visa));















        function request2() {
// $url ="https://umrahtech.com/classes/apitransmoh.php";
            $url = "https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transportcompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request2();
        $transfer_company = json_decode($responseData2);
// print_r($transportcompanies);die;






        function requestuocompanies() {

            $url = "https://umrahtech.com/umrahtechapi.php";
// $url = "https://umrahtech.com/api_b2c/3p_third_party/third_party/uocompanies";
            $data = array('case' => 'uocompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
//var_dump($responseData);
//exit();
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;


        }
        $requocompanies = requestuocompanies();
// print_r($requocompanies);die;
        $ground_company = json_decode($requocompanies);
// print_r($uocompanies);die;







        return redirect('voucher/'.$id);



// return view('template/frontend/pages/voucher',compact('hotel_makkah','hotel_madina','transfer','ground_services','data','transfer_company','ground_company'));

    }





    public function voucher($id){

//dd($id);




        $this->bookings= Booking::orderBy('id', 'DESC')->where('invoice_no',$id)->get();

        $data=(array)$this;

//        print_r($data);die;

        // print_r($data['bookings'][0]->total_visa_fee);die;$data['bookings'][0]->

        $makkah_brn=$data['bookings'][0]->hotel_makkah_brn;
        //dd($makkah_brn);
        $madina_brn=$data['bookings'][0]->hotel_madina_brn;
        //dd($madina_brn);
        $transfer_brn=$data['bookings'][0]->transfer_brn;
        $ground_brn=$data['bookings'][0]->ground_service_brn;



// $array=array(

// 'makkah_brn' => $makkah_brn,
// 'madina_brn' => 'no_madina',
// 'transfer_brn' => $transfer_brn,
// 'ground_brn' => $ground_brn,

// );

// print_r($array);die;

// $json=json_encode($array);


// echo $json.'json before encryption';

// echo "<br>";
// echo "<br>";


// $encrypted = Crypt::encryptString($json);
//         print_r($encrypted);
// echo 'json after encryption';


// echo "<br>";
// echo "<br>";




// $decrypt= Crypt::decryptString($encrypted);
//          print_r($decrypt);
// echo 'json after decryption';

// echo "<br>";
// echo "<br>";

// $all=json_decode($decrypt);

// echo $all->makkah_brn;

// print_r($all);

// die;

        $hotel_company='';
        $transfer_company='';
        $ground_company='';




        if($madina_brn == 'no_madina'){


            $hotel_madina='';
        }else{





            function requesthudx1($madina_brn) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case3' => 'hotel_madina_view_booking','madina_brn'=>$madina_brn);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx1($madina_brn);
            $hotel_madina = json_decode($responseData2);

            // print_r($responseData2);die;

// echo "yes madina";

        }



        function requesthudx($makkah_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'hotel_makkah_view_booking','makkah_brn'=>$makkah_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesthudx($makkah_brn);
        $hotel_makkah = json_decode($responseData2);

        // print_r($responseData2);die;




        function requesttransfers($transfer_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transfers_view_booking','transfer_brn'=>$transfer_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesttransfers($transfer_brn);
        $transfer = json_decode($responseData2);

        // print_r($responseData2);die;







        function requestground($ground_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'ground_view_booking','ground_brn'=>$ground_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requestground($ground_brn);
        $ground_services = json_decode($responseData2);

        // print_r($responseData2);die;


// $this->bookings= Booking::orderBy('id', 'DESC')->where('hotel_makkah_brn',$makkah_brn)->get();

//     $data=(array)$this;



// foreach ($data['bookings'] as $data) {

//  print_r($data->total_visa_fee);
//  die;
// }











        function request2() {
// $url ="https://umrahtech.com/classes/apitransmoh.php";
            $url = "https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transportcompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request2();
        $transfer_company = json_decode($responseData2);
// print_r($transportcompanies);die;






        function requestuocompanies() {

            $url = "https://umrahtech.com/umrahtechapi.php";
// $url = "https://umrahtech.com/api_b2c/3p_third_party/third_party/uocompanies";
            $data = array('case' => 'uocompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
//var_dump($responseData);
//exit();
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;


        }
        $requocompanies = requestuocompanies();
// print_r($requocompanies);die;
        $ground_company = json_decode($requocompanies);
// print_r($uocompanies);die;









        return view('template/frontend/userdashboard/pages/voucher_b2b',compact('hotel_makkah','hotel_madina','transfer','ground_services','data','transfer_company','ground_company'));


//        return view('template/frontend/pages/voucher',compact('hotel_makkah','hotel_madina','transfer','ground_services','data','transfer_company','ground_company'));

    }




// transfer functions ends




    public function invoice($id){



        $this->bookings= Booking::orderBy('id', 'DESC')->where('invoice_no',$id)->get();

        $data=(array)$this;



        // print_r($data['bookings'][0]->total_visa_fee);die;$data['bookings'][0]->

        $makkah_brn=$data['bookings'][0]->hotel_makkah_brn;
        $madina_brn=$data['bookings'][0]->hotel_madina_brn;
        $transfer_brn=$data['bookings'][0]->transfer_brn;
        $ground_brn=$data['bookings'][0]->ground_service_brn;



        $hotel_company='';
        $transfer_company='';
        $ground_company='';




        if($madina_brn == 'no_madina'){


            $hotel_madina='';
        }else{





            function requesthudx1($madina_brn) {
                $url ="https://umrahtech.com/umrahtechapi.php";
                $data = array('case' => 'hotel_madina_view_booking','madina_brn'=>$madina_brn);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseData = curl_exec($ch);
                if(curl_errno($ch)) {
                    return curl_error($ch);
                }
                curl_close($ch);
                return $responseData;
            }

            $responseData2 = requesthudx1($madina_brn);
            $hotel_madina = json_decode($responseData2);

            // print_r($responseData2);die;

// echo "yes madina";

        }



        function requesthudx($makkah_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'hotel_makkah_view_booking','makkah_brn'=>$makkah_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesthudx($makkah_brn);
        $hotel_makkah = json_decode($responseData2);

        // print_r($responseData2);die;




        function requesttransfers($transfer_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transfers_view_booking','transfer_brn'=>$transfer_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requesttransfers($transfer_brn);
        $transfer = json_decode($responseData2);

        // print_r($responseData2);die;







        function requestground($ground_brn) {
            $url ="https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'ground_view_booking','ground_brn'=>$ground_brn);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = requestground($ground_brn);
        $ground_services = json_decode($responseData2);

        // print_r($responseData2);die;


        $this->bookings= Booking::orderBy('id', 'DESC')->where('hotel_makkah_brn',$makkah_brn)->get();

        $data=(array)$this;

//     print_r($data['bookings'][0]->total_visa_fee);
//  die;

// foreach ($data['bookings'] as $data) {

//  print_r($data->total_visa_fee);
//  die;
// }




        function request2() {
// $url ="https://umrahtech.com/classes/apitransmoh.php";
            $url = "https://umrahtech.com/umrahtechapi.php";
            $data = array('case' => 'transportcompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }

        $responseData2 = request2();
        $transfer_company = json_decode($responseData2);
// print_r($transportcompanies);die;






        function requestuocompanies() {

            $url = "https://umrahtech.com/umrahtechapi.php";
// $url = "https://umrahtech.com/api_b2c/3p_third_party/third_party/uocompanies";
            $data = array('case' => 'uocompanies');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
//var_dump($responseData);
//exit();
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;


        }
        $requocompanies = requestuocompanies();
// print_r($requocompanies);die;
        $ground_company = json_decode($requocompanies);
// print_r($uocompanies);die;













        return view('template/frontend/pages/invoice',compact('hotel_makkah','hotel_madina','transfer','ground_services','data','transfer_company','ground_company'));

    }














// controller ending bracket
}


