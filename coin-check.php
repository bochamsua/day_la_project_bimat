<?php
chdir(dirname(__FILE__));
$access_token='EAATs8Kv1ELoBAHCCMBiLAX3gxvsMrfRVLZA03o1lup6MmHeZAhaiOw0GdWZCtFTMpiojnKfbeG3RTnucHKQZCHP7Mksx3nBvfKZCOHZCLXZC6tElZCo51RfEzaSfvqr7EZBj9haSPlg5TjBjcVQsJZArgOCZAFU3ZBxEhgeOcPPw1odUeQZDZD';

$api = 'https://api.coinmarketcap.com/v1/ticker/?limit=15';

$focus = [//we use btc price
    //'bitcoin' => [2500,3000],
    //'litecoin' => [35, 60],
    'ethereum' => [0, 0.25],
    'iota' => [0, 0.001],
    'ripple' => [0,0.0005],
    'nem' => [0,0.0002],
    'dash' => [0,0.1],
    'bytecoin-bcn' => [0, 0.000005]
];

$data = getSSLPage($api);
$data = json_decode($data);

$keys = array_keys($focus);

if($data){
    $result = [];
    foreach ($data as $datum) {
        if(in_array($datum->id, $keys)){
            $price = floatval($datum->price_btc);
            if($price <= $focus[$datum->id][0] || $price >= $focus[$datum->id][1]){
                $result[] = $datum->symbol.'-'.$datum->price_btc;
            }

        }
    }
    if(count($result)){
        $reply = implode("||", $result);
        $responseJSON = '{
        "recipient":{
          "id":"1609899199021922"
        },
        "message": {
                "text":"'. $reply .'"
            }
      }';


        //Graph API URL

        $url = 'https://graph.facebook.com/v2.7/me/messages?access_token='.$access_token;
        // Using cURL to send a JSON POST data
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $responseJSON);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
    }

}


function getSSLPage($base){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $base);
    curl_setopt($curl, CURLOPT_REFERER, $base);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $str = curl_exec($curl);
    curl_close($curl);

    return $str;
}
