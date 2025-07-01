<?php

namespace Devcbh\CheckoutWrapper;

class Checkout
{
    public function __construct()
    {
        $this->url = config('checkout-wrapper.api_endpoint');
        $this->version = config('checkout-wrapper.api_version');
        $this->creds = base64_encode(config('checkout-wrapper.api_username') . ":" . config('checkout-wrapper.api_password'));
    }

    public function sessionGenerate()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "443",
            CURLOPT_URL => "$this->url/api/$this->version/session",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic $this->creds",
                "Content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            $response = json_decode($response);
            if ($response->status != 0) {
                throw new \Exception("Cannot Generate Session");
            }
            return $response->data->session_id;
        }
    }

    /**
     * GenerateToken Function
     *
     * @param array $details Details of the transactions to be passed in
     * tokenization including item name, quantity and price
     * @param array $arrayData List of required details to be passed in API's
     *
     * @return bool|string
     * @author   Christian Villegas <cv@pisopay.com.ph>
     */
    public function generateToken(array $details, array $arrayData)
    {
        $details = json_encode(array(array(
            "payment" => $details,
            "name" => null, // company name if exists
        )));

        $arrayData["session_id"] = $this->sessionGenerate();

        $arrayData["details"] = $details;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "443",
            CURLOPT_URL => "$this->url/api/$this->version/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($arrayData),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Basic $this->creds",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }


    /**
     * GenerateReferenceNumber Function
     *
     * @param array  $arrayData
     * @param string $channelCode
     * @return bool|string
     * @author   Christian Villegas <cv@pisopay.com.ph>
     */
    public function generateReferenceNumber(array $arrayData, string $channelCode)
    {

        $time = time();
        $merchant_trace_no = $arrayData["merchant_trace_no"];

        $hd = $this->hashMaker($time, $merchant_trace_no, $channelCode);
        $hd2 = $this->hashMaker1($hd, $merchant_trace_no, $time);

        $arrayContent = [
            "merchant_trace_no" => $merchant_trace_no,
            "ip_address" => request()->ip(),
            "t" => $time,
            "sms" => "ON",
            "hd" => $hd,
            "hd2" => $hd2,
            "payment_channel_code" => $channelCode,
        ];


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "443",
            CURLOPT_URL => "$this->url/api/$this->version/transaction",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($arrayContent),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Authorization: Basic $this->creds",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    /**
     * HashMaker Function
     *
     * @param int $time
     * @param string merchant_trace_no
     * @param string $payment_channel_code
     * @return bool|string
     * @author   Christian Villegas <cv@pisopay.com.ph>
     */
    public function hashMaker(int $time, string $merchant_trace_no, string $payment_channel_code)
    {
        return hash("sha256", $time . $merchant_trace_no . $payment_channel_code);
    }

    /**
     * HashMaker1 Function
     *
     * @param string $y
     * @param string $merchant_trace_no
     * @param int $time
     * @return false|string
     * @author   Christian Villegas <cv@pisopay.com.ph>
     */
    public function hashMaker1(string $y, string $merchant_trace_no, int $time)
    {
        $auth = substr($y, strlen($y) - 30, strlen($y));
        return hash_hmac("sha256", $auth . $merchant_trace_no, $time);
    }
}
