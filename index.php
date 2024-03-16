<?php
// Проверяем наличие куки
if(isset($_COOKIE['user'])) {
    // Кука с именем 'user' существует, перенаправляем на index.html
    header('Location: main.html');
    exit();
} else {
    // Кука не установлена, перенаправляем на auth.html
    header('Location: auth.html');
    exit();
}
?>