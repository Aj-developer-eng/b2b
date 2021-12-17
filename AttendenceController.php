<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Booking;
use App\Mail\SendMailPassword;
use App\Mail\SendMailmandoob;
use App\Models\Employee;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\LeadPassenger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;


class AttendenceController extends Controller
{
    public function attendence()
    {
         $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();

       $employer_id = Auth::guard('agent')->user()->id;
       $attendance= Attendance::where('employer_id',$employer_id)->get();
 $employees = Employee::where('employer_id',$employer_id)->get();
 $employees_1 = Employee::where('employer_id',$employer_id)->get();

        
        $b2b_notification = \DB::table('bookings')->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
$data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();



        return view('template/frontend/userdashboard/pages/attendence/view_attendence',compact('employees','employees_1','attendance','b2b_notification','data_b2b','agent_active'));
    }
    public function store(Request $request)
    {
        
       
        $attendance = new Attendance();
        $attendance->employee_id = $request->employee_id;
        $attendance->employee_name = $request->employee_name;
        $attendance->employee_date = $request->employee_date;
        $attendance->time_in = $request->time_in;
        $attendance->time_out = $request->time_out;
          
 $attendance->employer_id = $request->employer_id;
        $attendance->save();
        $request->session()->flash('success','Successful Add Attendance!');
        return redirect('agent_dashboard/attendance');
    }
    public function edit($id)
    {
         $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $attendance=Attendance::find($id);
        $employees= Employee::all();
        $employees_1= Employee::all();
       
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();


       
        $b2b_notification = \DB::table('bookings')->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
        return view('template/frontend/userdashboard/pages/attendence/edit_attendance',compact('attendance','employees','employees_1','b2b_notification','data_b2b','agent_active'));
    }
    public function update(Request $request,$id)
    {
        $attendance=Attendance::find($id);
        if($attendance)
        {
            $attendance->employee_id = $request->employee_id;
            $attendance->employee_name = $request->employee_name;
            $attendance->employee_date = $request->employee_date;
            $attendance->time_in = $request->time_in;
            $attendance->time_out = $request->time_out;
            $attendance->save();
            $request->session()->flash('success','Successful update Attendance!');
            return redirect('agent_dashboard/attendance');
        }

    }
    public function delete(Request $request,$id)
    {
        $attendance=Attendance::find($id);
        $attendance->delete();
        $request->session()->flash('success','Successful delete Attendance!');
        return redirect('agent_dashboard/attendance');
    }
    public function assign_mandob(Request $request,$id)
    {
        // print_r($id);
        // die();
        $login_agent = Auth::guard('agent')->user()->email;
        $agent_active = DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();
        $employer_id = Auth::guard('agent')->user()->id;
        $employees = Employee::where('employer_id', $employer_id)->get();
        $bookings = Employee::find($id);
        $employees_1 = Employee::where('employer_id', $employer_id)->get();
          //dd($employees_1);
        $book = Booking::find($id);
        $book_2 = Booking::find($id);
        $book_3 = Booking::find($id);
          // print_r($book);
          // die();
        $employees_2 = Employee::where('employer_id',$employer_id)->get();

        $employees_3 = Employee::where('employer_id',$employer_id)->get();

        $employees1 = Employee::where('employer_id',$employer_id)->get();
        $get_address = DB::table('mondoob__save__locations')->get();
       
        $clientIP = request()->ip();
        $position = Location::get($clientIP);
        $b2b_notification = \DB::table('bookings')->orderBy('id', 'DESC')->limit('5')->where('agent_email',$login_agent)->get();
        $all_UO = Employee::all();
        //dd($all_UO);
        return view('template/frontend/userdashboard/pages/assign_task/mandob_list',compact('book','bookings','position','get_address','employees_1','employees_2','employees_3','employees1','employees','b2b_notification','data_b2b','agent_active','book_2','book_3','all_UO'));
    }
    public function employees_task(Request $request)
    {

        $login_agent=Auth::guard('agent')->user()->email;
    $agent_active=DB::table('active__agents')->where('agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        $data_b2b = \DB::table('bookings')->where('hotel_makkah_booking_status','=','cancelled')->orwhere('hotel_madina_booking_status','=','cancelled')->orwhere('transfer_booking_status','=','cancelled')->where('id','DESC')->limit('5')->where('agent_email',$login_agent)->get();

$employer_id = Auth::guard('agent')->user()->id;

        $employees_1 =\DB::table('tasks')
            ->join('bookings','tasks.booking_id', '=', 'bookings.id')
            ->select('tasks.*','bookings.*')->where('bookings.agent_id',$employer_id)
            ->get();
            
// print_r($employer_id);
//         die();
        
        $b2b_notification = \DB::table('bookings')->where('bookings.agent_email',$login_agent)->orderBy('id', 'DESC')->limit('5')->get();
        return view('template/frontend/userdashboard/pages/assign_task/view_task',compact('employees_1','b2b_notification','data_b2b','agent_active'));
    }
    public function view_task(Request $request,$id,$booking_id)
    {
    // print_r($request);
    //     die();

        $employer_id = Auth::guard('agent')->user()->id;
        $date = date('Y-m-d');
        $employees = Employee::find($id);

        $bookings = Booking::find($booking_id);

        
        $checkin = $bookings->checkin;
        $checkout = $bookings->checkout;
        $b_id = $bookings->id;
        // print_r($checkin);
        // print_r($checkout);
        // die();
        $task_detail=new TaskDetail();
        
        $task_detail->lead_p_name=$request->lead_p_name;
        $task_detail->email=$request->email;
        $task_detail->contact=$request->contact;
        $task_detail->note=$request->note;
        $task_detail->employee_id=$employees->id;
        $task_detail->save();
        if($bookings || $employees)
        {
            $tasks=new Task();

            // $tasks->lead_passenger_email=$bookings->lead_passenger_email;
            $tasks->employee_name =$employees->first_name.' '.$employees->last_name;
            $tasks->employee_id=$employees->id;
            $tasks->assign_date=$date;
            $tasks->task_date=$date;
            $tasks->arrival_time=$checkin;
            $tasks->pickup_time=$checkin;
            $tasks->drop_time=$checkout;
            $tasks->booking_number=$bookings->invoice_no;
            $tasks->emp_position=$employees->position;
            $tasks->email=$task_detail->email;
            $tasks->task_status='pending';
            $tasks->task_address=$employees->address;
            $tasks->agent_id=$employer_id;
            $tasks->booking_id=$b_id;
            $tasks->save();

        }


        \DB::table('employees')->where('id','=',$tasks->employee_id)->
        update([
            'req_status' => '0',
        ]);
        


if ($employees->position == 'Jeddah')
{

    $request->session()->flash('success','Successful Assign task');

//print_r($task_detail->email);
    return redirect('agent_dashboard/employees_task');
}
elseif ($employees->position == 'Makkah')
{

    $request->session()->flash('success','Successful Assign task');

    return redirect('agent_dashboard/employees_task');
}
elseif ($employees->position == 'Madina')
{
    $details = [
        'title' => 'Title: Mahatat Al Alam',
        'body' => 'Body:Mail From Mahatat Al Alam'
    ];
    $lead_details = [
        'title' => 'Title: lead passenger proposal',
        'body' => 'mandoob'
    ];

 \Mail::to($employees->email)->send(new SendMailmandoob($lead_details));
    $request->session()->flash('success','Successful Assign task And Check Your Email From Sent To Link Create Password!');

    \Mail::to($task_detail->email)->send(new SendMailPassword($details));
    $request->session()->flash('success','Successful Assign task And Check Your Email From Sent To Link Create Password!');
  return redirect('agent_dashboard/employees_task');
}





    }
    public function create_password()
    {

        return view('template/frontend/userdashboard/pages/email/create-password');
    }
    public function create_password_lead(Request $request)
    {
        $this->validate($request,
            [
                'user_password'=>'required',


            ]);
        $get_email=\DB::table('task_details')->orderBy('id', 'DESC')->first('email');
       $get_email_1=$get_email->email;
        $mail=$request->input('lead_passenger_email');
        $vi=$mail ==$get_email_1;
        if($vi)
        {

            $lead_passengers=new LeadPassenger();
            $lead_passengers->email=$get_email_1;
            $lead_passengers->password=Hash::make($request->input('user_password'));
            $lead_passengers->save();
            return redirect()->back()->with('message','password Created successfully');
        }
        else
        {
            return redirect()->back()->with('message','password Not Created successfully!!');
        }
    }


}
