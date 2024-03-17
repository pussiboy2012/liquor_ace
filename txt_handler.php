<meta charset="UTF-8">
<?php
// Разрешаем доступ к ресурсам с любого источника
header("Access-Control-Allow-Origin: *");

// Разрешаем использование методов POST, OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Разрешаем отправку заголовков Access-Control-Allow-Headers
header("Access-Control-Allow-Headers: Content-Type");

$browser = $_SERVER['HTTP_USER_AGENT'];
#echo "Ваш браузер: $browser\n";

// Проверяем, был ли отправлен запрос методом OPTIONS, и если да, завершаем скрипт
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

// Обработка POST-запроса

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $config = parse_ini_file('parameters 1.ini');
    
    // Получаем данные из тела POST-запроса
    $file = $_FILES['file']; 
    // Получение других полей 
    $inputSemester = $_POST['inputSemester']; 
    $inputTeacher = $_POST['inputTeacher']; 
    $inputDischipline = $_POST['inputDischipline']; 
    $inputInstitute = $_POST['inputInstitute'];
    $inputName = $_POST['FileName'];
    
    try {
        $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
    } catch (PDOException $exception) {
        echo "Ошибка подключения к БД:" . $exception->getMessage();
        die();
    }

    $stmt = $pdo->prepare('SELECT faculty_name FROM faculty as f
    join department as dep on f.faculty_id = dep.faculty_id
    where dep.department_name = :dep');
    $stmt->bindParam(':dep', $inputInstitute);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stm = $pdo->prepare('SELECT discipline_id FROM discipline
    where discipline.discipline_name = :disc');
    $stmt->bindParam(':disc', $inputDischipline);
    $stmt->execute();
    $discId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $targetDirectory = 'uploads/'.$files[0]['faculty_name'].'/'.$inputInstitute.'/'.$inputTeacher.'/'.$inputDischipline.'/'.$inputSemester.'/'; 

    // Изменение имени файла на сервере
    $targetFile = $targetDirectory . $inputName; // Изменение имени файла
    list($part1, $part2) = explode(".", $inputName, 2);
    $part ='.'.$part2;
    // Получение discipline_id из предыдущего запроса
$disciplineId = $discId[0]['discipline_id'];

// Генерация уникального идентификатора для файла - можно использовать текущую метку времени
$fileId = time();

// Определение типа файла
$fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

// Пути к исходному файлу и к файлу с заметками
$pathToSource = $targetFile; // просто предположим, что исходный файл хранится по адресу $targetFile
$pathToNotes = ''; // предположим, что заметок пока нет

// Подготовка SQL запроса для вставки данных в таблицу file
$stmt = $pdo->prepare('INSERT INTO file (file_id, discipline_id, user_id, file_name, file_type, file_path_to_source, file_path_to_notes) VALUES (:file_id, :discipline_id, :user_id, :file_name, :file_type, :path_to_source, :path_to_notes)');
$stmt->bindParam(':file_id', $fileId);
$stmt->bindParam(':discipline_id', $disciplineId);
$stmt->bindParam(':discipline_id', 1);
$stmt->bindParam(':file_name', $inputName);
$stmt->bindParam(':file_type', $fileType);
$stmt->bindParam(':path_to_source', $pathToSource);
$stmt->bindParam(':path_to_notes', $pathToNotes);

    
    // Перемещаем файл из временной директории в целевую директорию 
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {  
        header('Content-Type: application/json');
        echo json_encode(['statusresponse' => 'File successfully saved']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['statusresponse' => 'File successfully failed']);
    }
} else {
    // Если был отправлен недопустимый запрос
}



if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Проверяем, если параметр "get_lectures" установлен в true
    if(isset($_GET['get_lectures']) && $_GET['get_lectures'] === 'true') {
        $config = parse_ini_file('parameters 1.ini');

        try {
            $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
        } catch (PDOException $exception) {
            echo "Ошибка подключения к БД:" . $exception->getMessage();
            die();
        }
    
        $stmt = $pdo->prepare('SELECT file_name, file_type, file_path_to_source, file_path_to_notes FROM file');
        $stmt->execute();
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

        #$output = array();
        $response = array();
        $n = 0;
        foreach ($files as $file) {
            $review = [
                'name' => $file['file_name'],
                'type_file' => $file['file_type'],
                'path_to_source' => $file['file_path_to_source'],
                'path_to_notes' => $file['file_path_to_notes']
            ];
            $response[$n] = $review;
            ++$n;
        }
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если параметр не установлен или имеет неправильное значение
    echo "Invalid request.";
}
} else {
}


$browser = $_SERVER['HTTP_USER_AGENT'];
#echo "Ваш браузер: $browser";
?>
