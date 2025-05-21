<?php

namespace App\Http\Controllers;

use App\Models\deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('member.deposit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('member.depositcreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'amount' => 'required|numeric'
            ]);
            $amount = $request->input('amount');
            $reference = "INV-" . time();
            $timestamp = date('Y-m-d H:i:s');

            $merchantCode = env('DUITKU_MERCHANT_CODE');
            $apiKey = env('DUITKU_API_KEY');

            $deposit = Deposit::create([
                'user_id' => auth()->id(),
                'payment_ref' => $reference,
                'amount' => $amount,
                'status' => 'pending',
                'cashback' => 0,
            ]);

            $signature = hash('sha256',$merchantCode . $amount . $timestamp . $apiKey);

            $params = array(
                'merchantcode' => $merchantCode,
                'amount' => $amount,
                'datetime' => $timestamp,
                'signature' => $signature
            );
        
            $params_string = json_encode($params);
        
            $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod'; 
        
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($params_string))                                                                       
            );   
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
            //execute post
            $request = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            if($httpCode == 200)
            {
                $paymentMethods = json_decode($request, true);
                // print_r($paymentMethods);

                return view('member.choose_method', [
                    'deposit' => $deposit,
                    'paymentMethods' => $paymentMethods['paymentFee'],
                ]);
            }
            else{
                $request = json_decode($request);
                $error_message = "Server Error " . $httpCode ." ". $request->Message;
                echo $error_message;
            }


            // return redirect($result['paymentUrl']);

        } catch (\Exception $e) {
            // dd($e->getMessage());

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }

    public function proceed(Request $request)
    {
        try {
            $request->validate([
                'deposit_id' => 'required|exists:deposits,id',
                'paymentMethod' => 'required'
            ]);

            $merchantOrderId = "INV-" . time();            

            $deposit = Deposit::findOrFail($request->deposit_id);
            $user = User::findOrFail(auth()->id());
        
            $merchantCode = env('DUITKU_MERCHANT_CODE');
            $apiKey = env('DUITKU_API_KEY');
            $timestamp = time() . '';

            $signature =  md5($merchantCode . $merchantOrderId . $deposit->amount . $apiKey);

            $productDetails = 'Tes pembayaran menggunakan Duitku';
            $additionalParam = '';
            $merchantUserInfo = '';
            $firstName = $user->firstName;
            $lastName = $user->lastName;
            $phoneNumber = $user->phone;
            $email = $user->email;
        
            // Detail Alamat
            $alamat = $user->address;
            $city = $user->city;
            $postalCode = $user->postal_code;
            $countryCode = $user->countryCode;
            if ($countryCode == null) {
                $countryCode = 'ID';
            }
            if ($postalCode == null) {
                $postalCode = '12345';
            }
            if ($city == null) {
                $city = 'Jakarta';
            }

            $address = array(
                'firstName' => $firstName,
                'lastName' => $lastName,
                'address' => $alamat,
                'city' => $city,
                'postalCode' => $postalCode,
                'phone' => $phoneNumber,
                'countryCode' => $countryCode
            );

            $customerDetail = array(
                'firstName' => $firstName, //Wajib untuk transaksi subscription kartu kredit
                'lastName' => $lastName, //Wajib untuk transaksi subscription kartu kredit
                'email' => $email, //Wajib untuk transaksi subscription kartu kredit
                'phoneNumber' => $phoneNumber,
                'billingAddress' => $address,
                'shippingAddress' => $address
            );

            $itemDetails = array(
                array(
                    'id' => 1,
                    'price' => $deposit->amount,
                    'quantity' => 1,
                    'name' => $productDetails
                )
            );

            $params = array(
                'merchantCode' => $merchantCode,
                'paymentAmount' => $deposit->amount,
                'paymentMethod' => $request->paymentMethod,
                'merchantOrderId' => $merchantOrderId,
                'productDetails' => $productDetails,
                'additionalParam' => $additionalParam,
                'merchantUserInfo' => $merchantUserInfo,
                'customerVaName' => auth()->user()->name,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                //'accountLink' => $accountLink,
                //'creditCardDetail' => $creditCardDetail,
                //'isSubscription' => $isSubscription,
                //'subscriptionDetail' => $subscriptionDetail,
                'itemDetails' => $itemDetails,
                'customerDetail' => $customerDetail,
                'callbackUrl' => route('member.deposit.callback'),
                'returnUrl' => route('dashboard.index'),
                'signature' => $signature,
                'expiryPeriod' => 60
            );

            $params_string = json_encode($params);

            $url = "https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            ));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            $result = json_decode($response, true);
            dd($result);
            if (isset($result['paymentUrl'])) {
                return redirect($result['paymentUrl']);
            } else {
                return back()->with('error', 'Gagal membuat pembayaran: ' . $response);
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function callback(Request $request)
    {
        $data = $request->all();

        $reference = $data['merchantOrderId'] ?? null;
        $statusCode = $data['resultCode'] ?? null;

        if ($reference && $statusCode == '00') {
            $deposit = Deposit::where('reference', $reference)->first();

            if ($deposit && $deposit->status !== 'paid') {

                $cashback = 0;
                $amount = $deposit->amount;
    
                if ($amount >= 15000000) {
                    $cashback = (int)($amount * 0.20);
                } elseif ($amount >= 10000000) {
                    $cashback = (int)($amount * 0.12);
                } elseif ($amount >= 5000000) {
                    $cashback = (int)($amount * 0.05);
                }
    
                $deposit->update([
                    'status' => 'paid',
                    'cashback' => $cashback,
                ]);
    
                $user = $deposit->user;
                $user->increment('balance', $amount + $cashback);
            }
        }

        return response()->json(['message' => 'callback received'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deposit $deposit)
    {
        //
    }
}
