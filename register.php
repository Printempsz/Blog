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
if(isset($_POST['action'])) {
    if($_POST['action'] === 'register') {
        $sql = $pdo->prepare('INSERT INTO user (`created_time`, `username`, `password`, `secure_code`)
            VALUES (:created_time, :username, :password, :secure_code);');
        $sql->bindValue(':created_time', date('Y-m-d H:m:s', time()));
        $sql->bindValue(':username', $_POST['username']);
        $sql->bindValue(':password', $_POST['password']);
        $sql->bindValue(':secure_code', $_POST['secure_code']);
        $sql->execute(); 
        echo "<script>alert('注册成功！');location.href='login.html'</script>";
    }
    else{
        echo "<script>alert('错误访问！');location.href='register.html';</script>";
    }
}
?>