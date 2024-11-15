<?php
namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;
use stdClass;

trait ApiTrait
{
    function validateEmail(string $email): bool
    {
        $curl = curl_init();

        $data = [
            'email' => $email
        ];

        $post_data = http_build_query($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://disify.com/api/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        if ($response["format"] && $response["dns"]) {
            return true;
        } else {
            return false;
        }
    }
    function convertBalance(float $amount): float
    {
        $url = "https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_2hxNSYwmLFBrM9bDEiesdxMeE4HnAe37U7WNe1uZ&currencies=USD&base_currency=EUR";

        $curl = curl_init($url);
        curl_setopt(
            $curl,
            CURLOPT_RETURNTRANSFER,
            true
        );
        $resp = json_decode(curl_exec($curl), true);
        return floatval(number_format($resp["data"]["USD"], 4, "."));
    }

    function detectFraud(BankTransactionInterface $interface): array
    {
        $curl = curl_init();

        $data = [
            'movementType' => $interface->getTransactionInfo(),
            'amount' => $interface->getAmount()
        ];

        $post_data = http_build_query($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://frauddetectorapi.onrender.com",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}