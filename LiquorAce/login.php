<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
    <title>Вход</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
  </head>
  <body>
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
        
        $stmt = $pdo->prepare("SELECT * FROM client WHERE fio_client = '$username'");
        $stmt->execute();
        $row = $stmt->fetch();
        if ($username == $row['fio_client'] && $password == $row['password_client']) {
          // Верные логин и пароль
          session_start();
          $_SESSION['id_client'] = $row['id_client'];
          $_SESSION['authenticated'] = true;
          $_SESSION['username'] = $username;

          // Авторизация успешна, перенаправляем на личный кабинет
          header('Location: index.php');
          exit;
      } else {
          // Неверные логин или пароль
          echo 'Неверный логин или пароль.';
      }
    }
    ?>
    <header>
        <div class="menu">
          <img src="img/logo.png" alt="">
        </div>
      </header>
      <div class="auth">
        <form class="form-signin" method="post">
          <h1>Вход</h1>
          <input type="text" name="username" class="formcontrol" placeholder="Логин" required>
          <input type="password" name="password" class="formcontrol" placeholder="Пароль" required>
          <button class="auth" type="submit">войти</button>
          <h2>Нет аккаунта?</h2>
          <a class="reg" href="./registration.php">Зарегистрироваться</a>
        </form>
        </div>
        <footer>
          <div class="foot">
            <p class="f"> ©Copyright </p>
            <p class="f">Photostudio LUXURY</p> 
            <p class="f">г. Липецк 2022г.</p>
          </div>
        </footer>
  </body>
</html>