<?php

require_once 'Global.php';

/**
 * Validate hCaptcha response
 * @param string $response The hCaptcha response token
 * @return bool True if captcha is valid, false otherwise
 */
function validateHCaptcha($response)
{
    if (empty($response)) {
        return false;
    }

    $data = array(
        'secret' => HCAPTCHA_SECRET,
        'response' => $response
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($verify);
    $httpCode = curl_getinfo($verify, CURLINFO_HTTP_CODE);
    curl_close($verify);

    if ($httpCode !== 200) {
        return false;
    }

    $responseData = json_decode($response, true);
    return isset($responseData['success']) && $responseData['success'] === true;
}

?>