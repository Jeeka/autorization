<?php
    $id_app     = '6688034';                             //Айди приложения
    $url_script = 'http://localhost/testirovanie/vk.php'; //ссылка на скрипт auth_vk.php
    ?>

<?php
session_start ();
$url='https://oauth.vk.com/authorize?client_id='.$id_app.'&redirect_uri='.$url_script.'&response_type=code';
header("Location: $url");
if  (!empty($_GET ['code']))  {
 $id_app     =     '6688034' ;                      //Айди приложения
 $secret_app =    'Y0sYQUJpCB510z3xCGS6';         // Защищённый ключ. Можно узнать там же где и айди
 $url_script   =    'http://localhost/testirovanie/vk.php'; //ссылка на этот скрипт
 $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.$id_app.'&client_secret='.$secret_app.'&code='.$_GET['code'].'&redirect_uri='.$url_script), true);
 $fields       = 'first_name,last_name';
 $uinf = json_decode(file_get_contents('https://api.vk.com/method/users.get?uids='.$token['user_id'].'&fields='.$fields.'&access_token='.$token['access_token'].'&v=5.80'), true); 
 //$_SESSION['name']         = $uinf['response'][0]['first_name'];
 //$_SESSION['name_family']  = $uinf['response'][0]['last_name'];
 //$_SESSION['uid']          = $token['user_id'];
 //$_SESSION['access_token'] = $token['access_token'];
$_SESSION['session_username']= $uinf['response'][0]['first_name'] . " " . $uinf['response'][0]['last_name'];
require_once 'db.php';
$db = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка" . mysqli_error($link));
    mysqli_query($db, "SET NAMES utf8");
    $vk_id=mysqli_real_escape_string($db, trim($token['user_id']));
    $token=mysqli_real_escape_string($db, trim($token['access_token']));
    $username = mysqli_real_escape_string($db, trim($uinf['response'][0]['first_name'] . " ". $uinf['response'][0]['last_name'] ));
            $query = "SELECT * FROM `users` WHERE vk_id = '$vk_id'";
            $data = mysqli_query($db, $query);
            if(mysqli_num_rows($data) == 0) {
                $query ="INSERT INTO `users` (vk_id,token, username) VALUES ('$vk_id','$token', '$username')";
                mysqli_query($db,$query);
                mysqli_close($db);
                header("Location: mypage.php");
            }
            if(mysqli_num_rows($data) == 1) {
                $query="UPDATE `users` SET token='$token', username='$username'";
                mysqli_query($db, $query);
                mysqli_close($db);
                header("Location: /testirovanie/mypage.php");
            }
    }
?>