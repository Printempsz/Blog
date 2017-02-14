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
$sql = $pdo->prepare('SELECT * FROM article WHERE `id` = :id;');
$sql->bindValue(':id', $_GET['id']);
$sql->execute();
$article = $sql->fetch(PDO::FETCH_ASSOC);

if(@isset($_POST['action'])){
    if($_POST['action'] === 'SAVE'){
        $sql = $pdo->prepare('UPDATE article SET `title` = :title, `content` = :content, `edit_time` = :edit_time WHERE `id` = :id; ');
        $sql->bindValue(':title', $_POST['title']);
        $sql->bindValue(':content', $_POST['content']);
        $sql->bindValue(':edit_time', date('Y-m-d H:i:s', time()));
        $sql->bindValue(':id', $_GET['id']);//GET能通过url传值
        $sql->execute();
        header('Location: edit.php?id='.$_POST['id']);
    }
}

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>修改您的博客</title>
    </head>
    <body>
        <div>
            <form action="edit.php?id=<?php echo $article['id']; ?>" method="post"> 
                <input style="display:none;" name="id" value="<?php echo $article['id']; ?>">
                <input class="form-control" type="text" placeholder="在此输入标题" value="<?php echo $article['title']; ?>" name="title">
                <div>
                    <a href="index.php"><button type="button">返回主页</button></a>
                    <a href="detail.php"><button type="button">返回总览</button></a>
                </div>
                <div>
                    <textarea class="form-control" placeholder="在此输入内容" name="content"><?php echo $article['content']; ?></textarea>
                </div>
                <div>
                    <input type="submit" value="SAVE" name="action">
                </div>
            </form>
        </div>
    </body>

</html>