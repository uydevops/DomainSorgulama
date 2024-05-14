<?php
class WhoisService {
    private $apiKey;
    
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    public function fetchWhoisData($domain) {
        $url = "https://api.whoapi.com/?domain=$domain&r=whois&apikey=" . $this->apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $output;
    }
}
?>
