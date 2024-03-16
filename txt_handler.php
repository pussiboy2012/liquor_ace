<?php
// Разрешаем доступ к ресурсам с любого источника
header("Access-Control-Allow-Origin: *");

// Разрешаем использование методов POST, OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Разрешаем отправку заголовков Access-Control-Allow-Headers
header("Access-Control-Allow-Headers: Content-Type");

// Проверяем, был ли отправлен запрос методом OPTIONS, и если да, завершаем скрипт
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// Обработка POST-запроса
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из тела POST-запроса
    $file = $_FILES['file']; 
    // Получение других полей 
    $inputSemester = $_POST['inputSemester']; 
    $inputTeacher = $_POST['inputTeacher']; 
    $inputDischipline = $_POST['inputDischipline']; 
    $inputInstitute = $_POST['inputInstitute'];
    
    $targetDirectory = 'uploads/'; 

    // Полное имя файла на сервере 
    $targetFile = $targetDirectory . basename($file['name']); 
 
    // Перемещаем файл из временной директории в целевую директорию 
    if (move_uploaded_file($file['tmp_name'], $targetFile)) { 
        echo "Файл успешно сохранен на сервере."; 
    } else {
        echo "Произошла ошибка при сохранении файла.";
    }
} else {
    // Если был отправлен недопустимый запрос
    echo "Недопустимый запрос.";
}



if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Проверяем, если параметр "get_lectures" установлен в true
    if(isset($_GET['get_lectures']) && $_GET['get_lectures'] === 'true') {
        try {
            $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
        } catch (PDOException $exception) {
            echo "Ошибка подключения к БД:" . $exception->getMessage();
            die();
        }
    
        $stmt = $pdo->prepare('SELECT file_name, file_type, file_path_to_source, file_path_to_notes FROM file');
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = array();
foreach ($files as $file) {
    $output[] = array(
        'name' => $file['file_name'],
        'type_file' => $file['file_type'],
        'path_to_source' => $file['file_path_to_source'],
        'path_to_notes' => $file['file_path_to_notes']
    );
}

echo json_encode($output);
    } else {
        // Если параметр не установлен или имеет неправильное значение
        echo "Invalid request.";
    }
} else {
    // Если был отправлен недопустимый запрос
    echo "Недопустимый запрос.";
}
?>
