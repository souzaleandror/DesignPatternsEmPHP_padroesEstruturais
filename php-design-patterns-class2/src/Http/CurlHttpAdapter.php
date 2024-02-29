<?php

namespace Alura\DesignPattern\Http;

class CurlHttpAdapter implements HttpAdapter 
{
    public function post(stirng $url, array $data = []): void
    {
        $curl = curl_init($url);
        curl_steopt($curl, CURLOPT_POST, $data);
        curl_exec($curl);
    }
}