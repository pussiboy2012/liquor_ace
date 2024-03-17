<?php
function getAccessToken($code) {
    $client_id = "51878140";
    $client_secret = "hSymJrOEdrvBOorhUWBP";
    $redirect_uri = "https://lalectute.ru"; // Обновленный redirect_uri без дополнительных параметров

    $url = "https://oauth.vk.com/access_token";
    $params = http_build_query([
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'code' => $code
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($httpCode !== 200) {
        echo "HTTP Error: " . $httpCode;
        return false;
    }

    curl_close($ch);

    $token_data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON Decode Error: " . json_last_error_msg();
        return false;
    }

    return $token_data['access_token'];
}


function getUserInfo($access_token) {
    $url = "https://api.vk.com/method/users.get?access_token={$access_token}&fields=nickname,screen_name";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        die('Error fetching user info');
    }
    $user_info = json_decode($response, true);
    if (!isset($user_info['response'][0])) {
        die('Error getting user info: ' . print_r($user_info, true));
    }
    return $user_info['response'][0];
}

function getUserEmail($access_token) {
    $url = "https://api.vk.com/method/account.getProfileInfo?access_token={$access_token}&v=5.131";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        die('Error fetching user email');
    }
    $profile_info = json_decode($response, true);
    if (!isset($profile_info['response']['email'])) {
        die('Error getting user email: ' . print_r($profile_info, true));
    }
    return $profile_info['response']['email'];
}

// Получаем код авторизации из параметров запроса
$code = "0db9124ecb852cc2c9";

// Обмениваем код авторизации на access_token
$access_token = getAccessToken($code);

// Получаем информацию о пользователе
//$user_info = getUserInfo($access_token);
$user_email = getUserEmail($access_token);

// Выводим полученные данные
//echo "ID пользователя: " . $user_info['id'] . "<br>";
//echo "ФИО: " . $user_info['first_name'] . " " . $user_info['last_name'] . "<br>";
//echo "Никнейм: " . $user_info['nickname'] . "<br>";
echo "Email: " . $user_email;
?>