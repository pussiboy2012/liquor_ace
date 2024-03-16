<?php
function authorizeWithVK() {
    $client_id = "51878140";
    $redirect_uri = urlencode("http://h9966908.beget.tech/temp.html");
    $scope = "email";
    $url = "https://oauth.vk.com/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}";
    header("Location: " . $url);
    exit();
}

// Вызов функции для перенаправления на страницу авторизации VK
authorizeWithVK();
?>
