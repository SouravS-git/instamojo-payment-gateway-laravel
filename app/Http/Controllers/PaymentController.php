<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $api;

    function __construct(){
        $this->api = new \Instamojo\Instamojo(
            env('IM_API_KEY'),
            env('IM_AUTH_TOKEN'),
            env('IM_URL')
        );
    }

    public function makePayment(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'amount' => 'required',
        ]);

        try {
            $response = $this->api->paymentRequestCreate(array(
                'purpose' => 'Demo Purpose',
                'amount' => $request->amount,
                'buyer_name'=> $request->name,
                'phone'=> $request->phone,
                'email'=> $request->email,
                'send_sms' => true,
                'send_email' => true,
                'redirect_url' => env('APP_URL').'/public/getPaymentRequestStatus'
            ));
            
            header('Location: ' . $response['longurl']);
            exit();

        }catch (\Exception $e) {
            $errors = json_decode($e->getMessage(), true);
            return redirect()->back()->withInput()->withErrors($errors);
        }
    }
 
    public function getPaymentRequestStatus(Request $request){
        try {
            $response = $this->api->paymentRequestStatus(request('payment_request_id'));
            if(request('payment_status') == 'Credit')
                return $this->getPaymentStatus($request);
            else
                return redirect()->back()->with('errorMessage', 'Transaction Failed!');

        }catch (\Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }

    public function getPaymentStatus(Request $request){
        try {
            $response = $this->api->paymentRequestPaymentStatus(request('payment_request_id'), request('payment_id'));
            if($response['payment']['status'] == 'Credit')
                return redirect()->back()->with(['successMessage' => 'Transaction Successful!', 'responseData' => $response['payment']]);
            else
                return redirect()->back()->with('errorMessage', 'Transaction Failed!');
        }
        catch (Exception $e) {
            return redirect()->back()->with('errorMessage', $e->getMessage());
        }
    }
}
