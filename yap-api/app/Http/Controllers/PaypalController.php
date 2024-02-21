<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        // Retrieve the current exchange rate for MAD to USD from your preferred source
        $exchangeRate = 0.09922666666666666666666666666667; // Example exchange rate (1 MAD = 0.10959 USD)

        // Convert MAD to USD
        $amountUSD = $request->TotalPrice * $exchangeRate;
        // Format $amountUSD to have only two digits after the decimal point
        $amountUSD = number_format($amountUSD, 2);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                'return_url' => url('http://localhost:3000/catalogue?success=1'), // Your success URL
                'cancel_url' => url('http://localhost:3000/catalogue?success=0'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amountUSD, //MAD
                    ]
                ]
            ]
        ]);
        //dd($response);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->json(["link" => $link['href']]);
                }
            }
        } else {
            return response()->json(['error' => $amountUSD], 500);
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return "Payment is successful";
        } else {
            return "Payment is cancel";
        }
    }

    // public function createPayment(Request $request)
    // {
    //     $data  = [];
    //     $data['items'] = [
    //         [
    //             'name' > 'Product 1',
    //             'price' => 180,
    //             'desc' => 'Description for product 1',
    //             'qty' => 1
    //         ],
    //         [
    //             'name' > 'Product 2',
    //             'price' => 200,
    //             'desc' => 'Description for product 2',
    //             'qty' => 2
    //         ],
    //     ];
    //     $data['invoice_id'] = 1;
    //     $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
    //     $data['return_url'] = 'http://localhost:3000/catalogue';
    //     $data['cancel_url'] = 'http://localhost:3000/catalogue';
    //     $data['total'] = 1090;

    //     $provider = new ExpressCheckout;
    //     $response = $provider->setExpressCheckout($data, true);

    //     return redirect($response['paypal_link']);
    // }
}
