<?php 

namespace Kodventure\GoooTo;

class Client{

    protected $api_url  = "https://gooo.to/api";
    protected $client_key, $client_secret;
    protected $token;
    protected $error;
    
    public function __construct($client_key, $client_secret)
    {
        $this->client_key = $client_key;
        $this->client_secret = $client_secret;
        
        return $this->getToken();
    }

    private function getToken(){
 
        $this->request("POST", "/token", [
            'Accept: application/json',
            'ClientKey: '.$this->client_key,
            'ClientSecret: '.$this->client_secret            
        ], function($result){
            $this->token = $result->data; 
        });
  
        return $this;        
    }

    public function shorten($target)
    {
        return $this->request("POST",'/links?target='.$target); 
    }

    public function links($page = null){
        return $this->request("GET",'/links?page='.$page);
    }

    private function request($method, $url, $header = [], $callback = null)
    {
        if(!$header)
            $header = [
                'Accept: application/vnd.api+json',
                'Authorization: Bearer '.$this->token            
            ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_url.$url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header
        ]);

        $response = curl_exec($curl);        
       
        if(!$response)
            throw new \Exception("Connection Failure");

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = json_decode($response);

        curl_close($curl);

        if($httpCode != 200)
        { 
            $this->error = [
                "code"=>$httpCode,
                "message"=> $result->message ? $result->message : 'An error occured.'
            ];

            throw new \Exception($this->error['message'], $httpCode);  
        }  
        
        if($callback)
            $callback($result);

        return $result;
    }

    
}