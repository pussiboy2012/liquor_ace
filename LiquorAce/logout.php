<!DOCTYPE html>
<html>
<head>
    <title>Выход</title>
</head>
<body>
    <?php
    // Уничтожаем сессию и перенаправляем на страницу авторизации
    session_start();
    session_destroy();
    header('Location: index.php');
    exit;
    ?>
</body>
</html>