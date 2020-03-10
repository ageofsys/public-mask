<?php


namespace App\Clients;


use Illuminate\Support\Facades\Http;

class SimpleClient
{
    public function send($url, $method = "get")
    {
        $response = Http::get($url);

        if ($method == "post") {
            $response = Http::post($url);
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
