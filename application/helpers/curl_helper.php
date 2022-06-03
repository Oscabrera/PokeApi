<?PHP
function curlGet($url){
    $curl = curl_init();
    set_time_limit(3000);
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        CURLOPT_POST => 0
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}

function curlpost($url,$data){
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $data));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>
