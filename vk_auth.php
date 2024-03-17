<?php
function getAuthorizationUrl() {
    $client_id = "51878140";
    $redirect_uri = "https://lalectute.ru?vk_auth=true";
    $display = "page";
    $url = "https://oauth.vk.com/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&display={$display}&response_type=code";
    return $url;
}

// Вызов функции для перенаправления на страницу авторизации VK
// Получаем значение параметра source из GET запроса
$source = isset($_GET['source']) ? $_GET['source'] : "";

// Вызов функции для получения URL для авторизации VK
$authorizationUrl = getAuthorizationUrl($source);
echo $authorizationUrl;

?>