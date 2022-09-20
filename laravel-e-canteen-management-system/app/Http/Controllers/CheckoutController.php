<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentDetail2c2p;
use App\Models\PaymentType;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('checkout.index', compact('order'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment' => 'required',
        ]);

        $order = Order::find($request->order_id);

        if ($request->payment == '2c2p') {

            echo '<center>
            <h3>Please wait while we redirect you to 2C2P secure site.</h3>
            <p>Don\'t refresh until the page is redirected.</p>
            </center>';

            if (config('payment.2c2p-sandbox.status') == true) {
                $url = config('payment.2c2p-sandbox.url') . 'paymentToken';
                $info2c2p = [
                    'merchantID' => config('payment.2c2p-sandbox.merchantID'),
                    'currencyCode' => config('payment.2c2p-sandbox.currencyCode'),
                    'secretCode' => config('payment.2c2p-sandbox.secretCode'),
                    'localeCode' => config('payment.2c2p-sandbox.localeCode'),
                ];
            } else {
                $url = config('payment.2c2p.url') . 'paymentToken';
                $info2c2p = [
                    'merchantID' => config('payment.2c2p.merchantID'),
                    'currencyCode' => config('payment.2c2p.currencyCode'),
                    'secretCode' => config('payment.2c2p.secretCode'),
                    'localeCode' => config('payment.2c2p.localeCode'),
                ];
            }

            $invoiceCount = PaymentDetail2c2p::whereDate('created_at', Carbon::today())->count() == 0 ? 1 : PaymentDetail2c2p::whereDate('created_at', Carbon::today())->count() + 1;
            $payload = CheckoutController::getTokenRequestPayload($info2c2p, Carbon::now()->format('Ymd') . str_pad($invoiceCount, 4, 0, STR_PAD_LEFT), $order);
            $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
            $requestData = '{"payload": "' . $jwt . '"}';

            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', $url, [
                'body' => $requestData,
                'headers' => [
                    'Accept' => 'text/plain',
                    'Content-Type' => 'application/*+json',
                ],
            ]);

            $decode = (array) json_decode($response->getBody(), true);

            if(!array_key_exists('payload', $decode)){
                if ($decode['respCode'] == '9015') {
                    //dd('invoice exist');

                    while ($decode['respCode'] == '9015') {
                        $invoiceCount++;
                        $payload = CheckoutController::getTokenRequestPayload($info2c2p, Carbon::now()->format('Ymd') . str_pad($invoiceCount, 4, 0, STR_PAD_LEFT), $order);
                        $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
                        $requestData = '{"payload": "' . $jwt . '"}';
    
                        $response = $client->request('POST', $url, [
                            'body' => $requestData,
                            'headers' => [
                                'Accept' => 'text/plain',
                                'Content-Type' => 'application/*+json',
                            ],
                        ]);
    
                        $decode = json_decode($response->getBody(), true);

                        if(array_key_exists('payload', $decode)){
                            break;
                        }
                    }
                } else {
                    // error
                    return redirect()->route('student.checkout.failure');
                }
            }

            $decodedPayload = (array) JWT::decode($decode['payload'], new Key($info2c2p['secretCode'], config('payment.2c2p-algorithm')));

            if ($decodedPayload['respCode'] !== '0000') {
                // error
                return redirect()->route('student.checkout.failure');
            }

            $payment2c2p = PaymentDetail2c2p::create([
                'invoice_no' => $payload['invoiceNo'],
                'amount' => $payload['amount'],
                'currency_code' => $payload['currencyCode'],
                'status' => PaymentDetail2c2p::STATUS_PENDING,
            ]);

            $payment = $order->payments()->create([
                'payment_type_id' => PaymentType::PAYMENT_2C2P,
                'payment_detail_2c2p_id' => $payment2c2p->id,
                'amount' => $order->total_price,
                'status' => Payment::STATUS_IN_TRANSACTION,
            ]);

            return redirect()->to($decodedPayload['webPaymentUrl']);
        } else if ($request->payment == 'stripe') {
        }

        //dd($request, $order, Carbon::now()->format('Ymd'), $payload, $jwt, $url, config('payment.2c2p-algorithm'));

    }

    public function receivePaymentInfo(Request $request)
    {

        $request->validate([
            'paymentResponse' => 'required',
        ]);

        echo '<center>
        <h3>Please wait while we receiving your payment result.</h3>
        <p>Don\'t refresh until the page is redirected.</p>
        </center>';

        $decode = (array) json_decode(base64_decode($request->paymentResponse));

        if (config('payment.2c2p-sandbox.status') == true) {
            $url = config('payment.2c2p-sandbox.url') . 'paymentInquiry';
            $info2c2p = [
                'merchantID' => config('payment.2c2p-sandbox.merchantID'),
                'currencyCode' => config('payment.2c2p-sandbox.currencyCode'),
                'secretCode' => config('payment.2c2p-sandbox.secretCode'),
                'localeCode' => config('payment.2c2p-sandbox.localeCode'),
            ];
        } else {
            $url = config('payment.2c2p.url') . 'paymentInquiry';
            $info2c2p = [
                'merchantID' => config('payment.2c2p.merchantID'),
                'currencyCode' => config('payment.2c2p.currencyCode'),
                'secretCode' => config('payment.2c2p.secretCode'),
                'localeCode' => config('payment.2c2p.localeCode'),
            ];
        }

        $payload = CheckoutController::getPaymentInquiryPayload($info2c2p, $decode['invoiceNo']);
        $jwt = JWT::encode($payload, $info2c2p['secretCode'], config('payment.2c2p-algorithm'));
        $requestData = '{"payload": "' . $jwt . '"}';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', $url, [
            'body' => $requestData,
            'headers' => [
                'Accept' => 'text/plain',
                'Content-Type' => 'application/*+json',
            ],
        ]);

        echo '<br>' . $response->getBody() . '<br>';

        $inquiryJson = json_decode($response->getBody(), true);
        $inquiryPayload = (array) JWT::decode($inquiryJson['payload'], new Key($info2c2p['secretCode'], config('payment.2c2p-algorithm')));

        foreach ($inquiryPayload as $key => $value) {
            echo $key;
            echo " => ";
            echo $value;
            echo "<br>";
        }

        $detail2c2p = PaymentDetail2c2p::where('invoice_no', $decode['invoiceNo'])->first();

        $detail2c2p->update([
            'transaction_time' => Carbon::createFromFormat('YmdHis', $inquiryPayload['transactionDateTime'])->getTimestamp(),
            'agent_code' => $inquiryPayload['agentCode'],
            'channel_code' => $inquiryPayload['channelCode'],
            'approval_code' => $inquiryPayload['approvalCode'],
            'reference_no' => $inquiryPayload['referenceNo'],
            'tran_ref' => $inquiryPayload['tranRef'],
            'resp_code' => $inquiryPayload['respCode'],
            'status' => $inquiryPayload['respCode'] == '0000' ? PaymentDetail2c2p::STATUS_SUCCESS : PaymentDetail2c2p::STATUS_FAILURE,
        ]);

        $detail2c2p->payment->update([
            'status' => $inquiryPayload['respCode'] == '0000' ? Payment::STATUS_PENDING : Payment::STATUS_FAILURE,
        ]);

        $detail2c2p->payment->order->update([
            'status' => $inquiryPayload['respCode'] == '0000' ? Order::PAYMENT_SUCCESS : Order::PAYMENT_FAILURE,
        ]);

        if ($inquiryPayload['respCode'] == '0000') {
            return redirect()->route('student.checkout.success', ['order_id' => $detail2c2p->payment->order->id]);
        } else {
            return redirect()->route('student.checkout.failure', ['order_id' => $detail2c2p->payment->order->id]);
        }
    }

    public function paymentSuccess(Request $request)
    {
        dd('payment success', $request);
    }

    public function paymentFailure(Request $request)
    {
        dd('payment fail', $request);
    }

    function getTokenRequestPayload(array $info2c2p, string $invoiceNo, Order $order)
    {
        return [
            'merchantID' => $info2c2p['merchantID'],
            'invoiceNo' => $invoiceNo,
            'description' => 'Order id: ' . $order->id,
            'amount' => $order->total_price,
            'currencyCode' => $info2c2p['currencyCode'],
            'paymentChannel' => [],
            'frontendReturnUrl' => route('student.checkout.receive_payment_info', ['order_id' => $order->id]),
            'locale' => $info2c2p['localeCode'],
        ];
    }

    function getPaymentInquiryPayload(array $info2c2p, string $invoiceNo)
    {
        return [
            'merchantID' => $info2c2p['merchantID'],
            'invoiceNo' => $invoiceNo,
            'locale' => $info2c2p['localeCode'],
        ];
    }
}
