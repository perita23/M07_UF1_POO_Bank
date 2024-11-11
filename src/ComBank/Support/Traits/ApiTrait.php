<?php
namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

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

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        if ($response->format && $response->alias && $response->dns) {
            return true;
        } else {
            return false;
        }
    }
    function convertBalance(float $amount): float
    {

        return $amount * 1.1;
    }

    function detectFraud(BankTransactionInterface $interface): bool
    {
        return true;
    }
}