<?php

// Подключение к базе данных PostgreSQL с использованием PDO

$config = parse_ini_file('parameters 1.ini');
    
        try {
            $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
        } catch (PDOException $exception) {
            echo "Ошибка подключения к БД:" . $exception->getMessage();
            die();
        }
    
    // SQL запрос для выборки данных из таблицы "faculty"
    $sql = "SELECT * FROM faculty";
    $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $folderName = $row['faculty_name'];
        $folderPath = 'uploads/' . $folderName .'/';
        echo''. $folderPath.'<br>';
        // Проверяем, существует ли папка
        if (!file_exists($folderPath)) {
            // Создаем папку
            mkdir($folderPath, 0777, true);
            echo "Папка $folderName создана.\n";
        } else {
            echo "Папка $folderName уже существует.\n";
        }
        $stmt = $pdo->prepare("SELECT * FROM department 
        where faculty_id = :id");
        $stmt->bindParam(":id", $row['faculty_id']);
  $stmt->execute();
  $rows1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows1 as $row1) {
        $folderName = $row1['department_name'];
        $folderPathDep = $folderPath . $folderName.'/';
        echo''. $folderPath.'<br>';
        // Проверяем, существует ли папка
        if (!file_exists($folderPathDep)) {
            // Создаем папку
            mkdir($folderPathDep, 0777, true);
            echo "Папка $folderName создана.\n";
        } else {
            echo "Папка $folderName уже существует.\n";
        }
        $stm = $pdo->prepare("SELECT * FROM teacher 
        where department_id = :id");
        $stm->bindParam(":id", $row1['department_id']);
  $stm->execute();
  $rows2 = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows2 as $row2) {
        $folderName = $row2['teacher_lastname'].' '.$row2['teacher_firstname'].' '.$row2['teacher_midlename'];
        $folderPathT = $folderPathDep . $folderName.'/';
        echo''. $folderPathT.'<br>';
        // Проверяем, существует ли папка
        if (!file_exists($folderPathT)) {
            // Создаем папку
            mkdir($folderPathT, 0777, true);
            echo "Папка $folderName создана.\n";
        } else {
            echo "Папка $folderName уже существует.\n";
        }
        $st = $pdo->prepare("SELECT * FROM discipline 
        where teacher_id = :id");
        $st->bindParam(":id", $row2['teacher_id']);
  $st->execute();
  $rows3 = $st->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows3 as $row3) {
        $folderName = $row3['discipline_name'];
        $folderPathD = $folderPathT . $folderName.'/';
        echo''. $folderPathD.'<br>';
        // Проверяем, существует ли папка
        if (!file_exists($folderPathD)) {
            // Создаем папку
            mkdir($folderPathD, 0777, true);
            echo "Папка $folderName создана.\n";
        } else {
            echo "Папка $folderName уже существует.\n";
        }
        for ($i = 1; $i < 9; $i++) {
        $folderPathS = $folderPathD.''.$i.'/';
        if (!file_exists($folderPathS)) {
            // Создаем папку
            mkdir($folderPathS, 0777, true);
            echo "Папка $i создана.\n";
        } else {
            echo "Папка $i уже существует.\n";
        }
        }
    }
    }
        
    }
    }


$conn = null;
?>