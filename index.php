<?php header('Content-Type: text/html; charset=utf-8');
session_start();
?>
<?php
require_once 'db.php';
$db = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка" . mysqli_error($link));
    if(isset($_SESSION["session_username"])){
      header("Location: mypage.php");
      }
      
      if(isset($_POST['submit'])) {
        if(!empty($_POST['username']) && !empty($_POST['password'])) {
	        $username=mysqli_real_escape_string($db, trim($_POST['username']));
	        $password=mysqli_real_escape_string($db, trim($_POST['password']));
            $query = "SELECT * FROM `users` WHERE username = '$username' AND password = ('$password')";
            $data=mysqli_query($db,$query);
	            if(mysqli_num_rows($data)==1){
                    while($row=mysqli_fetch_assoc($data)){
	                    $dbusername=$row['username'];
                        $dbpassword=$row['password'];
                        
                    }              
                    if($username == $dbusername && $password == $dbpassword){

	                    $_SESSION['session_username']=$username;	 
                        /* Перенаправление браузера */
                        header('Location: mypage.php');
	                }
                } 
                else {
	             $message = "Вы ввели не правильный логин или пароль!";
                }
    } 
    else {
        $message = "Заполните все поля!";
	}
    }
?>
<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} 
?>
<html lang="ru">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/font-awesome.css" type="text/css">
<title> Авторизация </title>
</head>
<body>
<div class="container">
  <img src="img/2.png">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="dws-input">
<input type="text" name ="username" placeholder ="Введите логин">
</div>
<div class="dws-input">
<input type="password" name ="password" placeholder ="Введите пароль"><br>
</div>
<input class="dws-submit" type="submit" name ="submit" value ="Войти">
<a href="reg.php">Регистрация</a><br>
<div class="social">
<i class="fa fa-facebook-square" aria-hidden="true"><a href="vk.php"></i>
<i class="fa fa-vk" aria-hidden="true"></i>
</div>
</div>
</form>
</div>
</body>