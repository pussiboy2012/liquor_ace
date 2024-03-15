<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="css/reset.css" rel="stylesheet" type="text/css" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="width: 1920px; height: 1080px; position: relative">
  <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: linear-gradient(253deg, #F2C561 0%, #B47826 100%); border: 1px black solid"></div>
  <div style="width: 730px; height: 470px; left: 595px; top: 203px; position: absolute">
    <div style="width: 730px; height: 470px; left: 0px; top: 0px; position: absolute; background: rgba(45.90, 45.90, 45.90, 0.80); border-radius: 10px"></div>
    <div class="VkId" style="width: 320px; height: 86px; left: 358px; top: 335px; position: absolute">
      <div class="Rectangle123" style="width: 320px; height: 86px; left: 0px; top: 0px; position: absolute; background: #0077FF; border-radius: 10px"></div>
      <div class="Group2" style="width: 50px; height: 50px; left: 20px; top: 19px; position: absolute">
        <div class="Vector" style="width: 50px; height: 50px; left: 0px; top: 0px; position: absolute; background: white"></div>
        <div class="Vector" style="width: 33.35px; height: 20.81px; left: 8.44px; top: 15.21px; position: absolute; background: #0077FF"></div>
      </div>
      <div class="VkId" style="left: 87px; top: 29px; position: absolute; color: white; font-size: 25px; font-family: Ubuntu; font-weight: 700; word-wrap: break-word">Войти через VK ID </div>
    </div>
    <div style="width: 320px; height: 86px; left: 28px; top: 335px; position: absolute">
      <div class="Rectangle122" style="width: 320px; height: 86px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 10px"></div>
      <div class="Group" style="width: 50.01px; height: 52.66px; left: 54px; top: 67.67px; position: absolute">
        <div class="Vector" style="width: 28.47px; height: 28.52px; left: 10.77px; top: -24.15px; position: absolute; background: #0077FF"></div>
        <div class="Vector" style="width: 50.01px; height: 20.16px; left: 0px; top: 0px; position: absolute; background: #0077FF"></div>
      </div>
      <div style="left: 110px; top: 12px; position: absolute; color: #0077FF; font-size: 50px; font-family: Ubuntu; font-weight: 500; word-wrap: break-word">войти</div>
    </div>
    <div style="width: 650px; height: 90px; left: 28px; top: 230px; position: absolute">
      <div class="Rectangle121" style="width: 650px; height: 90px; left: 0px; top: 0px; position: absolute; background: #333333; border-radius: 10px"></div>
      <div style="left: 21px; top: 14px; position: absolute; color: #828282; font-size: 50px; font-family: Ubuntu; font-weight: 500; word-wrap: break-word">пароль</div>
    </div>
    <div style="width: 650px; height: 90px; left: 28px; top: 130px; position: absolute">
      <div class="Rectangle120" style="width: 650px; height: 90px; left: 0px; top: 0px; position: absolute; background: #333333; border-radius: 10px"></div>
      <div style="left: 21px; top: 14px; position: absolute; color: #828282; font-size: 50px; font-family: Ubuntu; font-weight: 500; word-wrap: break-word">логин</div>
    </div>
    <div class="Vector" style="width: 48.74px; height: 87.72px; left: 328.63px; top: 15.19px; position: absolute; background: white; border-radius: 2px"></div>
  </div>
</div>
</body>
</html>
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         <?php
    // Проверяем, была ли авторизация
    session_start();

    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
      $clientId = null;  
        ?>
      <li><a class="head in" href="login.php">Войти</a></li>
      <?php
    }
    else {
      ?>
      <li><a class="head in" href="personal.php"><?php echo $_SESSION['username']; ?></a></li> 
      <?php
    $clientId = $_SESSION['id_client'];
    }
    ?>
        </ul>
      </div>
    </header>
      <div>
        <div class="container">
          <h1>каталог</h1>
          <div class="col">
          <?php
  $config = parse_ini_file('parameters 1.ini');

  try {
    $pdo = new PDO('pgsql:host='. $config['host'] . ';port=' . $config['port'] .
    ';dbname=' . $config['dbname'] . ';user=' . $config['login'] . ';password=' . $config['password']);
  } catch (PDOException $exception){
    echo "Ошибка подключения к БД:" . $exception->getMessage();
    die();
  }

  $sql = 'SELECT * FROM "public"."User"';
  $result = $pdo->prepare($sql);
  $result->execute();
  $users = $result->fetchAll(PDO::FETCH_ASSOC);
  $i = 0;
  ?>
        <table>
        <tr>
        <?php foreach ($users as $user): $i++; ?>
            <td>
            <div class="prdct">
                <a href="product.php?id=<?= $product['id_product']; ?>" class="product">
                    <img class="product" src="" alt="">
                    <h3><?= $user['user_login'] ?></h3>
                </a>
                <div class="buyinf">
                    <span class="price"><?= $product['price_product'] ?>₽</span>
                    <?php if ($clientId): ?>
                    <form method="post" action="">
                        <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                        <input type="hidden" name="id_client" value="<?php echo $clientId; ?>">
                    <button type="submit" class="add-to-cart"><ion-icon name="cart-outline"></ion-icon></button>
                    </form>
                <?php endif; ?>
                </div>
            </div>
            </td>
		<?php if($i==5):$i=0;?>
            <tr>
                <?php endif;?>
        <?php endforeach; ?>
        </tr>
        </table>
    </div>
    <?php
    // Обработка отправки формы
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $productId = $_POST['id_product'];
        if ($clientId) {
          $sql = "SELECT COUNT(*)
          FROM productcopy
          WHERE id_product = '$productId' and id_client is null and id_request is null";
  $result = $pdo->prepare($sql);
  $result->execute();
  $products = $result->fetchAll(PDO::FETCH_ASSOC);
  foreach ($products as $product):
    if ($product['count']==0){
      echo "Товара нет в наличии";
    }else{
            $sql = "UPDATE productcopy
            SET id_client = '$clientId'
            WHERE id_product = '$productId'
            AND serial_product = (
                SELECT MIN(serial_product) 
            FROM productcopy
            WHERE id_client is null
            );";
            $result = $pdo->prepare($sql);
            $result->execute();
            echo "<p>Товар добавлен в корзину!</p>";
        } 
      endforeach;
      }
       else {
            echo "<p>Пользователь не авторизован!</p>";
        }
    }
    ?>