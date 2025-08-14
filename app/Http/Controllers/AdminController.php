<?php

namespace App\Http\Controllers;
use App\User;
use App\Wallet;
use App\Transaction;
use App\Train;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function pending()
    {
        DB::table('users')
        ->where('activated', '=', 'no')
        ->where('created_at', '<', DB::raw('NOW() - INTERVAL 3 DAY'))
        ->delete();

        DB::table('users')
        ->where('activated', '=', 'pending')
        ->where('created_at', '<', DB::raw('NOW() - INTERVAL 5 DAY'))
        ->delete();

        $data['users'] = DB::table('users')
                ->where('activated', '=', 'no')
                ->get();

        $data['allusers'] = User::all()->count();
   
        $data['activated'] = User::where('activated', 'yes')->count();

               
        return view('pending')->with($data);
    }
    public function checkUser(Request $request) 
    {
        $username = $request->input('username');

        $user = DB::table('users')->where('username', $username)->first();

        if(empty($user)) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($user, 200);

    }
    public function staff()
    {
        $users = DB::table('users')
        ->where('role', '=', 'staff')
        ->get();
        return view('staff')->with(['users' => $users]);
    }

    public function makeStaff(Request $request) {

        $user = DB::table('users')->where('username', $request->username)->exists();

        if($user) {
            DB::table('users')
            ->where('username', $request->username)
            ->update(['role' => 'staff']);

            return redirect()->back();
        }
        return back();
    }
    public function fund(Request $request) 
    {
        $user = DB::table('users')->where('username', $request->username)->first();

        if($wallet = Wallet::where('user_id',  $user->id)->first()) {
            $amount =  $wallet->amount + intval($request->amount);
            $wallet->amount = $amount;
            $wallet->save();
            $type = "Funded";
            
            Transaction::create(['user_id' => $user->id,
            'amount' => intval($request->amount), 'type'=> $type, 'status' => 'successful']);

            $request->session()->flash('success', 'You just funded ' .$request->username . '\'s Wallet' ); 

            return back();
        }else {

        $amount =  intval($request->amount);
        $type = "Funded";

        Wallet::create(['user_id' =>  $user->id, 'amount' => $amount]);
        
        Transaction::create(['user_id' => $user->id,
            'amount' => $amount, 'type'=> $type, 'status' => 'successful']);

        $request->session()->flash('success', 'You just funded ' .$request->username . '\'s Wallet' ); 

        return back();
        }

        $request->session()->flash('success', 'Opps! Something went wrong!' ); 

        return back();

        
    }

    public function payment()
    {
       $users = DB::table('transactions')
       ->select(DB::raw('transactions.amount, transactions.id as trans_id, users.*, wallets.amount as balance, user_accounts.bank_name, user_accounts.account_name, user_accounts.account_no'))
       ->where('status', '=', 'pending')
       ->join('users', 'users.id', '=', 'transactions.user_id')
       ->join('wallets', 'wallets.user_id', '=', 'transactions.user_id')
       ->leftJoin('user_accounts', 'user_accounts.user_id', '=', 'transactions.user_id')
        ->get();
            
        //return response()->json($users);
        return view('payment')->with(['users' => $users]);
    }
    public function transactions(){
       
        $trans = DB::table('transactions')
        ->select(DB::raw('transactions.*, users.name, users.username,users.level, users.phone')) 
        ->join('users', 'users.id', '=', 'transactions.user_id')->limit(1000)
         ->get();
             
         //return response()->json($users);
         return view('transactions')->with(['trans' => $trans]);
    }
    public function paymentDone(Transaction $transaction, Request $request)
    {
        $transaction->status = 'successful';
        $transaction->paid_by = Auth::id();
        $transaction->save();

        $request->session()->flash('success', 'You just confirmed that you have paid ' .$request->username );
        return back();
    }
    
    //Todo Get parent
    public function getParentId($username){

        // $user = DB::table('users')->where('username', $username)->first();

        $parent = DB::table('users')->where('direct_downlines', '<', 2)
        ->where('activated', '=', 'yes')
        ->oldest('activated_at')->first();

        return $parent->id;

        // if($user->direct_downlines < 2) {
        //     return $user->id;
        // }else {
        //     $parent = DB::table('users')
        //     ->select(DB::raw('users.*, users_tree.*'))
        //     ->where('users_tree.ancestor', '=', $user->id)
        //     ->where('users_tree.depth', '>', 0)
        //     ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
        //     ->where('users.direct_downlines', '<', 2)
        //     ->where('activated', '=', 'yes')
        //     ->first();
        // }
        
    }
    //Todo Get parent
    public function getWhoToPay($id, $level){
        if($level == 2){
            $col = 'users.two';
            $count = 4;
        }else if($level == 3){
            $col = 'users.three';
            $count = 8;
        }else if($level == 4){
            $col = 'users.four';
            $count = 16;
        }else if($level == 5){
            $col = 'users.five';
            $count = 32;
        }else if($level == 6){
            $col = 'users.six';
            $count = 64;
        }

            $parent = DB::table('users')
            ->select(DB::raw('users.*, users_tree.*'))
            ->where('users_tree.descendant', '=', $id)
            ->where('users_tree.depth', '=', ($level-1))
            ->join('users_tree', 'users.id', '=', 'users_tree.ancestor')
            ->where('users.level', '>=', $level)
            ->where($col, '<', $count)
            ->first();

            

            if(!$parent) {

                $parent = DB::table('users')
                ->select(DB::raw('users.*, users_tree.*'))
                ->where('users_tree.descendant', '=', $id)
                ->where('users_tree.depth', '>', ($level-1))
                ->join('users_tree', 'users.id', '=', 'users_tree.ancestor')
                ->where('users.level', '>=', $level)
                ->where($col, '<', $count)
                ->latest('activated_at')
                ->first();
                
                if(!$parent) {
                    $parent = DB::table('users')->where('id', 1)->first();
                    return $parent;        

                }
                
                return $parent;

                
            }

            return $parent;
        
        
    }

    public function upgrade(Request $request) {

        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->first();
        $level = $user->level + 1;

        try {
            $amountNeeded = $this->getPaymentForLevel($level);
        } catch (\InvalidArgumentException $e) {
            $request->session()->flash('error', 'Invalid level to upgrade to.');
            return redirect()->back();
        }

        if (!$wallet || $wallet->amount < $amountNeeded)
        {
            $request->session()->flash('error', 'Insuficient funds!');
            return redirect()->back();
        }

        DB::beginTransaction();
        try{
            $this->_performUpgrade($user, $level, $amountNeeded);

            $type = "Level {$level} Upgrade Fee";
            $this->unpay($user->id, $amountNeeded, $type);

            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        $request->session()->flash('success', 'upgrade level '. $level . ' was successful!');
        return back();
    }

    public function upgradeOnlinePayment( $paid_amount) {
        $user = Auth::user();
        $level = $user->level + 1;

        try {
            $amountNeeded = $this->getPaymentForLevel($level);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false], 422);
        }

        if($paid_amount < $amountNeeded)
        {
            return response()->json([
                'message' => 'Insuficient fund',
                'success' => false
            ], 422);
        }

        DB::beginTransaction();
        try{
            $this->_performUpgrade($user, $level, $amountNeeded);

            $type = "Level {$level} Upgrade Fee (Card)";
            $this->record($user->id, $amountNeeded, $type);

            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage(), 'success' => false], 422);
        }

        return response()->json([
            'message' => 'Upgrade was successful!',
            'success' => true
        ], 200);
    }

    private function _performUpgrade(User $user, int $level, int $amount)
    {
        $levelColumns = [2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six'];

        if (!array_key_exists($level, $levelColumns)) {
            throw new \Exception("Invalid upgrade level: {$level}");
        }

        $parent = $this->getWhoToPay($user->id, $level);
        if (!$parent) {
            throw new \Exception("Could not find an eligible upline for level {$level}.");
        }

        // Pay parent
        $this->pay($parent, $amount, "Level {$level} Benefits");

        // Increment parent's counter
        DB::table('users')->where('id', $parent->id)->increment($levelColumns[$level]);

        // Increment user's level
        $user->increment('level');
    }
  

    //count
    public function countDownlines($parent_id, $level) {
        $count = DB::table('users')
        ->select(DB::raw('users.*, users_tree.*'))
        ->where('users_tree.ancestor', '=', $parent_id)
        ->where('users_tree.depth', '=', $level)
        ->join('users_tree', 'users.id', '=', 'users_tree.descendant')
        ->count();

        return $count;
    }
    public function unpay($id, $amount, $type) {

            $wallet = Wallet::where('user_id',  $id)->first();
            $newAmount =  $wallet->amount - $amount;
            $wallet->amount = $newAmount;
            $wallet->save();
            
            Transaction::create(['user_id' => $id,
            'amount' => $amount, 'type'=> $type, 'status' => 'successful']);
    
    }

    public function record($id, $amount, $type) {


        Transaction::create(['user_id' => $id,
        'amount' => $amount, 'type'=> $type, 'status' => 'successful']);

    }

    public function pay($parent, $levelPayment, $type ) {
        
        if($wallet = Wallet::where('user_id',  $parent->id)->first()) {
            $amount =  $wallet->amount + $levelPayment;
            $wallet->amount = $amount;
            $wallet->save();
            
            Transaction::create(['user_id' => $parent->id,
            'amount' => $levelPayment, 'type'=> $type, 'status' => 'successful']);
        }else {

        $amount =  $levelPayment;
        Wallet::create(['user_id' =>  $parent->id, 'amount' => $levelPayment]);

        Transaction::create(['user_id' => $parent->id,
            'amount' => $amount, 'type'=> $type, 'status' => 'successful']);
        }
    }
    //this function also adds users to tree //old
    public function activateUser(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            $request->session()->flash('error', 'User not found!');
            return back();
        }

        DB::beginTransaction();
        try {
            $this->_performActivation($user, $request->by);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

        $request->session()->flash('success', $user->username . ' activation was successful!');
        return back();
    }

    public function onlinePaymentActivate( $paid_amount)
    {
        if($paid_amount < $this->activationFee)
        {
            return response()->json([
                'message' => 'Insuficient fund',
                'success' => false
            ], 422);
        }

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $this->_performActivation($user, $user->referrer);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false
            ], 422);
        }

        return response()->json([
            'message' => 'Your account activation was successful!',
            'success' => true
        ], 200);
    }

    private function _performActivation(User $user, ?string $referrerUsername)
    {
        $node_id = $user->id;

        if ($node_id == 1 || is_null($referrerUsername)) {
            $parent_id = 0;
        } else {
            $referrer = User::where('username', $referrerUsername)->first();
            if (!$referrer) {
                throw new \Exception("Referrer '{$referrerUsername}' not found.");
            }
            $this->pay($referrer, $this->referralBonus, "Referral Bonus");
            $parent_id = $this->getParentId($referrer->username);
        }

        $query = "
                INSERT INTO users_tree (ancestor,descendant,depth)
                SELECT ancestor, {$node_id}, depth+1
                FROM users_tree
                WHERE descendant = {$parent_id}
                UNION ALL SELECT {$node_id}, {$node_id}, 0";

        DB::statement($query);

        $user->update(['parent_id' => $parent_id]);
        $user->increment('level');

        if($parent_id != 0) {
            $realParent = User::find($parent_id);
            $realParent->increment('direct_downlines');
            $this->pay($realParent, $this->level1Payment, "Level 1 Benefits");
        }

        $ghost = User::find(1);
        $this->pay($ghost, $this->adminPayment, "Registration Fee");

       $user->update([
            'activated' => 'yes',
            'activated_by' => Auth::id(), 
            'activated_at' => DB::raw('now()')
        ]);
    }


    public function verify($reference, Request $request) {

        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/'. $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
        $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. env('PAYSTACK_SECRET_KEY')]
        );
        $request = curl_exec($ch);
        if(curl_error($ch)){
        echo 'error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($request) {
        $result = json_decode($request, true);
        }

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {

            $paid_amount = $result['data']['amount'] / 100;
            // return response()->json($result['data']);
            if(Auth::user()->level < 1) {
                // return response()->json($result['data']);
               return $this->onlinePaymentActivate($paid_amount);
            }else {
                return $this->upgradeOnlinePayment($paid_amount);
            }
           
        }else{
            return response()->json([
                'message' => 'Transaction was unsuccessful',
                'success' => false
            ], 401);
        }

    }

    
}
