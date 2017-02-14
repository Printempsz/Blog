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
if(@$_GET['action'] == "logout"){
    unset($_SESSION['username']);
    echo "<script>alert('已注销，即将跳往登录页面');location.href='login.html'</script>";
}
$sql = $pdo->prepare('SELECT * FROM article WHERE `created_user` = :user;');
$sql->bindValue(':user', $_SESSION['username']);
$sql->execute();
$article = $sql->fetchall(PDO::FETCH_ASSOC);
if(@substr($_POST['action'], 0, 3) === 'DEL'){
    $sql = $pdo->prepare('DELETE FROM article WHERE `id` = :id;');
    $id = substr($_POST['action'], 4);
    $sql->bindValue(':id', $id);
    $sql->execute();
    header('Location: detail.php');
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>查看您的blog</title>
    </head>
    <body>
        <div class="container">
          <?php foreach ($article as $things) { ?>
            <tr>
                <td>
                    <h2><?php echo $things['title']; ?></h2>
                </td>
                <div>
                        <a href="edit.php?id=<?php echo $things['id'];?>"><button>编辑</button></a>
                </div>
                <td>
                    <form action="detail.php" method="POST">
                        <input type="submit" value="DEL-<?php echo $things['id'];?>" name="action">
                    </form>
                </td>

                    <pre><?php echo $things['content']; ?></pre>
                </td>
                <td></td>
            </tr>
          <?php } ?>
        </div>
        <div>
            <a href="index.php"><button>返回主页</button></a>
        </div>

        
    </body>
</html>