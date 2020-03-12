<?php


namespace App\PublicMask\Api\Clients;


use Illuminate\Support\Facades\Http;

class SimpleClient
{
    public function send($url, $method = "get")
    {
        $response = Http::retry(3, 60);

        $response = $response->get($url);

        if ($method == "post") {
            $response = $response->post($url);
        }

        if ($response->clientError() || $response->serverError()) {
            var_dump("네트워킹 오류 발생");
        }

        return $response->json();
    }

    public function get($url)
    {
        return $this->send($url, "get");
    }

    public function post($url)
    {
        return $this->send($url, "post");
    }

}
