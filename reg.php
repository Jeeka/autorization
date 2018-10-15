<?php header('Content-Type: text/html; charset=utf-8');
session_start();
require_once 'db.php';
$db = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
if(isset($_POST['submit'])){
 $username = mysqli_real_escape_string($db,trim($_POST['username']));
 $email = mysqli_real_escape_string($db,trim($_POST['email']));
 $password = mysqli_real_escape_string($db,trim($_POST['password']));
 $password2 = mysqli_real_escape_string($db,trim($_POST['password2']));
 if(!empty($username) && !empty($password) && !empty($password2) && !empty($email) && (
   $password == $password2)) {
     $query = "SELECT * FROM `users` WHERE username = '$username'";
     $data = mysqli_query($db, $query);
     if(mysqli_num_rows($data) == 0){
    $query ="INSERT INTO `users` (username, email, password) VALUES ('$username',
    '$email', ('$password2'))";
    mysqli_query($db,$query);
    echo 'Все отлично, можете авторизоваться';
    mysqli_close($db);
    exit();
     }
     else{
       echo 'Логин уже существует';
     }
     
}
}
?>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/font-awesome.css" type="text/css">
<title> Регистрация </title>
</head>
<body>
<div class="container1">
  <img src="img/3.png">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="dws-input1">
<input type="text" name ="username" placeholder ="Введите ваш логин">
</div>

<div class="dws-input1">
<input type="email" name ="email" placeholder ="Введите email"><br>
</div>

<div class="dws-input1">
<input type="password" name ="password" placeholder ="Введите пароль"><br>
</div>

<div class="dws-input1">
<input type="password" name ="password2" placeholder ="Подтвердите пароль"><br>
</div>

<input class="dws-submit" type="submit" name ="submit" value ="Зарегистрироваться">
<?php 
session_destroy();
?>
<div class="social">
</div>
</div>
</form>
</div>
</body>