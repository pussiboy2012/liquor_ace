<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $field = $_GET['field'];
  $query = $_GET['query'];
// Подключение к базе данных
$config = parse_ini_file('parameters 1.ini');
    
try {
    $pdo = new PDO('pgsql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['login'], $config['password']);
} catch (PDOException $exception) {
    echo "Ошибка подключения к БД:" . $exception->getMessage();
    die();
}
// Выполнение запроса к базе данных
if ($field == 'input-semester'){
  $sql = ('SELECT semesther_num FROM semesther');
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  $options = [];
  foreach ($rows as $row) {
    $options[] = $row['semesther_num'];
}
  
  // Отправка JSON результата
  header('Content-Type: application/json');
  echo json_encode($options);


}else if ($field == 'input-teacher'){
  $sql = ('SELECT teacher_lastname,teacher_firstname,teacher_midlename FROM teacher');
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  $options = [];
  foreach ($rows as $row) {
    $fio = $row['teacher_lastname'].' '.$row['teacher_firstname'].' '.$row['teacher_midlename'];
    $options[] = $fio;
}
  
  // Отправка JSON результата
  header('Content-Type: application/json');
  echo json_encode($options);


}else if ($field == 'input-discipline'){
$sql = ('SELECT discipline_name FROM discipline');
$result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  $options = [];
  foreach ($rows as $row) {
    $options[] = $row['discipline_name'];
}
  
  // Отправка JSON результата
  header('Content-Type: application/json');
  echo json_encode($options);


}else if ($field == 'input-institute'){
  $sql = ('SELECT department_name FROM department');
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  $options = [];
  foreach ($rows as $row) {
    $options[] = $row['department_name'];
}
  
  // Отправка JSON результата
  header('Content-Type: application/json');
  echo json_encode($options);

}
else if ($field == 'input-search'){
  $sql = ('SELECT file_name FROM "file"');
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  $options = [];
  foreach ($rows as $row) {
    $options[] = $row['file_name'];
  }
  
  // Отправка JSON результата
  header('Content-Type: application/json');
  echo json_encode($options);
}
}
?>