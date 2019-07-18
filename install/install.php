<?php
/**
* @author hobrt.me
* @file install.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/
ob_start();
include_once 'config.php';

$dbWr = is_writable("../application/config/database.php");
$cnWr = is_writable("../application/config/config.php");
$caWr = is_writable("../application/cache");
$tmpConfig = is_writable("config.php");

if((!$dbWr || !$cnWr || !$tmpConfig || !$caWr) && isset($_GET['step']))
	header("Location: install.php");

function _hash($password)
	{
		$pass = "IttIhAdyHobrt";
		$pass2 = "hobrt-programming.com";
		return sha1($pass.$password.$pass2);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>تثبيث السكرب </title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 605px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
</head>
<body>
<div class="container">
<div class="form-signin">
<?php
//error_reporting(0);
if(isset($_GET['step']) && $_GET['step'] == 1)
{
	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$ar = explode('/', $url);
	array_pop($ar);
	array_pop($ar);
	$nurl = implode("/", $ar).'/';
	$fcn = file_get_contents("../application/config/config.php");
	$fcn = preg_replace_callback("|{url}|",function () { global $nurl; return $nurl; },$fcn);
	$f = fopen("../application/config/config.php", "w");
	fwrite($f, $fcn);
	fclose($f);
	?>
	<center><h4> معلومات قاعدة الباينات </h4></center>
	<form action="install.php?step=2" method="post">
		<label> هوست القاعدة : </label><input type="text" value="localhost" name="host" class="form-control"><br />
		<label> إسم المستخدم (user) : </label><input type="text" value="" name="user" class="form-control"><br />
		<label> كلمة السر </label><input type="text" value="" name="pass" class="form-control"><br />
		<label> إسم القاعدة </label><input type="text" value="" name="dbname" class="form-control">
		<input type="submit" name="s" value="إنشاء الجدول ←" class="btn btn-success">
		<center><p>هده المرحلة تأخد بعض الوقت الرجاء الإنتظار ,</p></center>
	</form>
	<?php

}elseif(isset($_GET['step']) && $_GET['step'] == 2)
{
	if(isset($_POST['s']))
	{
		$fc = file_get_contents("database_simple.php");
		$host = $_POST['host'];
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$dbname = $_POST['dbname'];
		$mysqli = new mysqli ($host, $user, $pass, $dbname) or die("الرجاء التاكد من بيانات قاعدة البيانات ");
		if ($mysqli->connect_error) {
		    die(' الرجاء التأكد من بيانات قاعدة البيانات');
		    exit();
		}
		$fc = preg_replace_callback("|{host}|",function () { global $host; return $host; },$fc);
		$fc = preg_replace_callback("|{user}|",function () { global $user; return $user; },$fc);
		$fc = preg_replace_callback("|{pass}|",function () { global $pass; return $pass; },$fc);
		$fc = preg_replace_callback("|{dbname}|",function () { global $dbname; return $dbname; },$fc);
		$f = fopen("../application/config/database.php", "w");
		fwrite($f, $fc);
		fclose($f);
		$sql = file_get_contents("sql.sql");
		$arr = explode(';', $sql);
		foreach ($arr as $key) {
			$mysqli->query($key);
		}
		$con = file_get_contents("tmp_simple.php");
		$con = preg_replace_callback("|{host}|",function () { global $host; return $host; },$con);
		$con = preg_replace_callback("|{user}|",function () { global $user; return $user; },$con);
		$con = preg_replace_callback("|{pass}|",function () { global $pass; return $pass; },$con);
		$con = preg_replace_callback("|{dbname}|",function () { global $dbname; return $dbname; },$con);
		$f = fopen("config.php", "w");
		fwrite($f, $con);
		fclose($f);

		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

		$newurl = explode("/", $url);

		array_pop($newurl);
		array_pop($newurl);

		$url = implode("/", $newurl);

		$con1 = file_get_contents("config_simple.php");
		$con1 = preg_replace_callback("|{url}|",function () { global $url; return $url."/"; },$con1);
		$f = fopen("../application/config/config.php", "w");
		fwrite($f, $con1);
		fclose($f);
		header("Location: install.php?step=3");
	}
}elseif(isset($_GET['step']) && $_GET['step'] == 3){
	if(isset($_POST['add']))
	{
		$user = $_POST['username'];
		$email = $_POST['email'];
		$password = _hash($_POST['password']);
		$mysqli = new mysqli ($host1, $user1, $pass1, $dbname1);
		$mysqli -> set_charset("utf8");
		$mysqli -> query("INSERT INTO admins (username,email,password) VALUES ('$user','$email','$password')") or die($mysqli->error);
		header("Location: install.php?step=4");
	}else{
	?>
	<center><h4> إدخال بيانات المدير </h4></center>
	<form action="install.php?step=3" method="post">
		<label> إسم المستخدم : </label><input name="username" type="text" class="form-control"><br />
		<label> البريد الإلكتروني : </label><input name="email" type="email" class="form-control"><br />
		<label> كلمة السر : </label><input name="password" type="password" class="form-control"><br />
		<input type="submit" class="btn btn-success" value="إنشاء الحساب ←" name="add">
	</form>
	<?php
	}
}elseif(isset($_GET['step']) && $_GET['step'] == 4){
	if(isset($_POST['add']))
	{
		$user = $_POST['username'];
		$mysqli = new mysqli ($host1, $user1, $pass1, $dbname1);
		$mysqli -> set_charset("utf8");
		$mysqli -> query("
INSERT INTO `settings` (`title`, `googlea`, `fbpixel`, `color`, `descr`, `header`, `teles`, `whs`, `messangers`, `logo`) VALUES
('$user', '', '', '', '', '212771736870 - contact@hobrt.me', '0771736870', '0771736870', 'hobrt', '4ba6814e26a47e6e8e349de75eaace85.png');") or die($mysqli->error);
		echo "تم التثبيث بنجاح الرجاء حدف مجلد install .";
	}else{
	?>
	<center><h4> إعدادات الموقع </h4></center>
	<form action="install.php?step=4" method="post">
		<label> عنوان الموقع : </label><input name="username" type="text" class="form-control"><br />
		<input type="submit" class="btn btn-success" value="إدخال الإعدادات ←" name="add">
	</form>
	<?php
	}
}else{


	?>
<center>
	<ul class="list-group">
		<li style="margin-bottom: 5px;text-align: right;" class="list-group-item list-group-item-<?php echo $dbWr ? "success" : "danger"; ?>">الملف application/config/database.php <?php echo $dbWr ? "" : "غير"; ?> قابل للكتابة .</li>
		<li style="margin-bottom: 5px;text-align: right;" class="list-group-item list-group-item-<?php echo $cnWr ? "success" : "danger"; ?>">الملف application/config/config.php <?php echo $cnWr ? "" : "غير"; ?> قابل للكتابة .</li>
		<li style="margin-bottom: 5px;text-align: right;" class="list-group-item list-group-item-<?php echo $tmpConfig ? "success" : "danger"; ?>">الملف install/config.php <?php echo $tmpConfig ? "" : "غير"; ?> قابل للكتابة .</li>
		<li style="margin-bottom: 5px;text-align: right;" class="list-group-item list-group-item-<?php echo $caWr ? "success" : "danger"; ?>">المجلد application/cache <?php echo $caWr ? "" : "غير"; ?> قابل للكتابة .</li>
	</ul>
	<?php if($dbWr && $cnWr && $tmpConfig && $caWr) { ?>
		<a href="install.php?step=1" class="btn btn-success">بدء التنصيب ←</a>
	<?php }else { ?>
		<a href="install.php?step=1" class="btn btn-info">اعد الفحص ←</a>
	<?php } ?>
</center>
	<?php
}


?>

<div style="text-align: center;margin-top: 20px;">
	by <a href="https://hobrt.me">hobrt</a>
</div>

</div>
</div>
</body>
</html>