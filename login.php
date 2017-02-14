<?php
date_default_timezone_set('PRC');
$conn_hostname = 'localhost';
$conn_database = 'blog';
$conn_username = 'root';
$conn_password = '';
try {
	$pdo = new PDO('mysql:host='.$conn_hostname.';dbname='.$conn_database, $conn_username, $conn_password);
	$pdo->exec('SET NAMES UTF8');
}
catch(Exception $e) {
    echo '<h1>数据库链接错误！</h1>';
    return;
}
if(isset($_POST['action'])){
    if($_POST['action'] === 'login'){
        $username=$_POST['username'];
        $password=$_POST['password'];
        if($username == ""||$password == ""){
            echo "<script>alert('请输入用户名和密码');location.href='login.html';</script>";
        }
        else{
            $test = $pdo->query('select * from user where username ="'.$username.'" and password = "'.$password.'"')->fetchAll(PDO::FETCH_ASSOC);//int用''char用"''"
            $result = count($test);
            if($result == 0){
                echo "<script>alert('用户名或密码错误');location.href='login.html'</script>";
            }
            else{
                session_start();
                $_SESSION['username'] = $username;
                echo $_SESSION['username'];
                echo "<script>alert('登录成功，即将跳往主页');location.href='index.php'</script>";
            }
        } 
        


    }
}
?>