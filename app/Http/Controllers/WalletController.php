<?php

namespace App\Http\Controllers;
use App\Transaction;
use App\Wallet;
use App\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();

        $transaction = Transaction::where('user_id', Auth::id())->latest()->limit(50)->get();

        $account = UserAccount::where('user_id', Auth::id())->first();


       
        return view('wallet')->with(['wallet'=> $wallet,
         'trans' => $transaction, 'account' => $account]);
    }

    public function sendPaymentRequest(Request $request)
    {
        // Use the UserAccount model for better readability and maintainability
        if (!UserAccount::where('user_id', Auth::id())->where('default', 1)->exists()) {
            return redirect()->back()->with('error', 'Please set a default User Account first!');
        }

        $wallet = Wallet::where('user_id', Auth::id())->first();
        if (!$wallet) {
            return redirect()->back()->with('error', 'Not Eligible! Wallet not found.');
        }

        $amount = filter_var($request->amount, FILTER_VALIDATE_INT);
        if ($amount === false || $amount <= 0) {
            return redirect()->back()->with('error', 'Invalid amount provided.');
        }

        if ($amount < 1000) {
            return redirect()->back()->with('error', 'Minimum withdrawal amount is 1000.');
        }

        if ($wallet->amount < $amount) {
            return redirect()->back()->with('error', 'Insufficient Funds!');
        }

        // Use a database transaction to ensure data integrity
        DB::transaction(function () use ($wallet, $amount) {
            $wallet->decrement('amount', $amount);

            Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'type' => 'Withdrawal',
                'status' => 'pending'
            ]);
        });

        return redirect()->back()->with('success', 'Payment Request sent successfully!');
    }
}
