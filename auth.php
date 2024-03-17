<?php
    // Проверяем, был ли отправлен запрос на авторизацию
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $config = parse_ini_file('parameters 1.ini');

        try {
          $pdo = new PDO('pgsql:host='. $config['host'] . ';port=' . $config['port'] .
          ';dbname=' . $config['dbname'] . ';user=' . $config['login'] . ';password=' . $config['password']);
        } catch (PDOException $exception){
          echo "Ошибка подключения к БД:" . $exception->getMessage();
          die();
        }
        
        $stmt = $pdo->prepare('SELECT * FROM public."User" WHERE user_login = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($username === $row['user_login'] && $password === $row['user_pass_hash']) {
          // Верные логин и пароль
          session_start();
          $_SESSION['id_client'] = $row['id_client'];
          $_SESSION['authenticated'] = true;
          $_SESSION['username'] = $username;
          setcookie("user",$_SESSION['username'] , time() + 3600, "/");

          // Авторизация успешна, перенаправляем на личный кабинет
          header('Location: main.html');
          exit;
      } else {
          // Неверные логин или пароль
          echo 'Неверный логин или пароль.';
      }
    }
    
?>