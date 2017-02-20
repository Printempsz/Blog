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
session_start();
if(!isset($_SESSION['username'])){
        echo "<script>alert('你好,游客，请先登录!');location.href='login.html'</script>";
}
else{
    echo 'Hallo,'.$_SESSION['username'];
}
if(@$_GET['action'] == "logout"){//@后语句有错不报错
    unset($_SESSION['username']);
    echo "<script>alert('已注销，即将跳往登录页面');location.href='login.html'</script>";
}

if(@$_POST['action'] == "save"){
    $sql = $pdo->prepare('INSERT INTO article (`created_time`, `title`, `content`, `edit_time`, `created_user`) 
        VALUES (:created_time, :title, :content, :edit_time, :created_user);');
    $sql->bindValue(':created_time',date('Y-m-d H:i:s',time()));
    $sql->bindValue(':title',$_POST['title']);
    $sql->bindValue(':content',$_POST['content']);
    $sql->bindValue(':edit_time', '');
    $sql->bindValue(':created_user',$_SESSION['username']);
    $sql->execute();
    echo "<script>alert('上传成功！');</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <title>MY blog</title>
    <h1 align="center">欢迎使用MY blog</h1>
</head>
<body>
    <form action="index.php" method="GET">
        <table>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="logout" name="action" class="btn btn-danger">
            </td>
        </tr>
        </table>
    </form>
    <div class="container align="center">
        <a href="detail.php"><button class="btn btn-default">查看您的博客</button></a>
        <a href="create.php"><button class="btn btn-default">写一篇新博客</button></a>
        <a href="all.php"><button class="btn btn-default">浏览全部的博客</button></a>
    </div>

</body>