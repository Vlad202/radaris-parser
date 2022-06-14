<?php

function get_request($url, $params = null, $headers = null) {
    if ($params) $url = $url . '?' . http_build_query($params);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}
function post_request($url, $params = null, $headers = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [];
    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        }
    );
    if ($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close ($ch);
    return ['data' => $server_output, 'headers' => $headers];
}

?>