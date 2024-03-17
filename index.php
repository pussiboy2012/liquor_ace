<?php
// Проверяем наличие куки
if(isset($_COOKIE['user'])) {
    // Кука с именем 'user' существует, перенаправляем на index.html
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if(isset($_GET['vk_auth']) && $_GET['vk_auth'] === 'true') {
            
            //при удачной авторизации
            
        } else {

            $code = $_GET['code'];
            $username = $_COOKIE['user'];
        
            $config = parse_ini_file('parameters 1.ini');
            try {
                $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
            } catch (PDOException $exception) {
                echo "Ошибка подключения к БД:" . $exception->getMessage();
                die();
            }
            echo $code.'<br>';
            $stmt = $pdo->prepare('SELECT user_id
                      FROM public."User" AS u 
                      WHERE u.user_login LIKE :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $userId = $id[0]['user_id'];

            $stmt = $pdo->prepare('UPDATE public."User" as u
            SET user_vk_code = :code
            WHERE user_id = :id;');
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            // твой код
        }
    }    
        
    header('Location: main.html');
    exit();
} else {
    // Кука не установлена, перенаправляем на auth.html
    header('Location: auth.html');
    exit();
}
?>