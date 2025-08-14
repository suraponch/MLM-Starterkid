<?php

namespace App\Http\Controllers;

//
use App\User;
use App\Transaction;
use App\Train;
use App\AppAccount;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public $details;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('mail');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function mail(Request $request) {
        
        try{
  
            $d = new SendMail();
          $d->name = $request->name;
          $d->email = $request->email;
          $d->subject = "Contact Email From  ". $request->name;
          $d->message = $request->message;
      
  
         Mail::to('info@e-earners.com')->send($d);
  
         $request->session()->flash('success', "Success!! We will be in touch!");
          
          return back();
        }catch(\Exception $e) {
  
            $request->session()->flash('error', "Failed!! Please try again!". $e->getMessage());
  
            return back();
        }
  
         
      }
  
      public function profile()
      {
          return view('profile');
      }
      public function update(User $user, Request $request)
      {
          $request->validate([
              'name' => 'string|max:255',
              'phone' => 'string|max:255',
              'address' => 'string|max:255',
              'state' => 'string|max:255',
              'country' => 'string|max:255',
          ]);
  
          $user->name = $request->name;
          $user->phone = $request->phone;
          $user->address = $request->address;
          $user->state = $request->state;
          $user->country = $request->country;
          $user->save();
          $request->session()->flash('success', "Success!! Profile updated!" );
          return back();
      }
  
      public function index()
      {
          $data['upline'] = User::find(Auth::user()->parent_id);

          $data['allusers'] = User::all()->count();
        //   $data['pending'] = User::where('activated', 'pending')->count();
          $data['activated'] = User::where('activated', 'yes')->count();
        //   $data['notActivated'] = User::where('activated', 'no')->count();
          $data['transOut'] = Transaction::where('type', 'Withdrawal')
                                ->where('user_id', '=', Auth::id())
                                ->where('status', 'successful')->sum('amount');

          $data['transIn'] = Transaction::where('type', 'like', '%Benefits')
                            ->where('user_id', '=', Auth::id())
                            ->sum('amount');
        // $data['upgrade'] = Transaction::where('type', 'like', '%Upgrade')
        //                     ->where('user_id', '=', Auth::id())
        //                     ->sum('amount');
        //   $data['referrals'] = User::where('referred_by', Auth::user()->username)->count();
          $data['accs'] = AppAccount::all();  // $data['upgrade'] = Transaction::where('type', 'like', '%Upgrade')
        //                     ->where('user_id', '=', Auth::id())
        //                     ->sum('amount');

        $data['paystack_key'] = env('PAYSTACK_PUBLIC_KEY');
        $levelTo = Auth::user()->level + 1;
        $data['pay_amount'] = $this->getPaymentForLevel($levelTo);
          
          
          return view('home2')->with($data);
      }
      public function notActivated() 
      {
        $data['users'] =User::where('activated', 'no')
                        ->where('referrer', '=', Auth::user()->username)
                        ->get();

        // return response()->json($data['users']);

        return view('not_activated')->with($data);
      }
  
      public function getDownlines($level) {
          $theLevel = DB::table('users')
          ->select(DB::raw('users.*, users_tree.*'))
          ->where('users_tree.ancestor', '=', Auth::id())
          ->where('users_tree.depth', '=', $level)
          ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
          ->get();
  
          return $theLevel;
      }
  
      public function matrix() {
  
          $level_one = $this->getDownlines(1);
  
          $level_two = $this->getDownlines(2);
  
          $level_three = $this->getDownlines(3);
  
          $level_four = $this->getDownlines(4);
  
          $level_five = $this->getDownlines(5);

          $level_six = $this->getDownlines(6);
  
          return view('matrix')->with([
              'ones' => $level_one,
              'twos' => $level_two,
              'threes' => $level_three,
              'fours' => $level_four,
              'fives' => $level_five,
              'sixs' => $level_six,
              ]);
      }
  
      public function activationRequest(Request $request) {
  
            if(Auth::user()->activated != 'no') {
                $request->session()->flash('error', 'Already activated!');
                return redirect()->back();
            }

              DB::table('users')
              ->where('id', Auth::id())
              ->update(['activated' => 'pending']);

              $request->session()->flash('success', 'We are reviewing your request!');
              return redirect()->back();
        
      }
}
