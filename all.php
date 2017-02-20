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
$sql = $pdo->prepare('SELECT * FROM article');
$sql->execute();
$article = $sql->fetchall(PDO::FETCH_ASSOC);

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
        <title>所有博客</title>
    </head>
    <body>
        <div class="container">
            <?php foreach ($article as $things) { ?>
            <tr>
                <td>
                    <h2><?php echo $things['title']; ?></h2>
                </td>
                <div>
                        <a href="glance.php?id=<?php echo $things['id'];?>"><button class="btn btn-default">查看详情</button></a>
                        <p>作者：<?php echo $things['created_user'] ?></p>
                </div>
                <td></td>
            </tr>
          <?php } ?>
        </div>
    </body>
</html>