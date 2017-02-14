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
$id=$_GET['id'];
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
$sql = $pdo->prepare('SELECT * FROM comment WHERE `title_id` = :id;');
$sql->bindValue(':id', $id);
$sql->execute();
$comment = $sql->fetchall(PDO::FETCH_ASSOC);
$sql = $pdo->prepare('SELECT * FROM article WHERE `id` = :id;');
$sql->bindValue(':id', $id);
$sql->execute();
$article = $sql->fetch(PDO::FETCH_ASSOC);

if(@isset($_POST['action'])){
    if($_POST['action'] === 'ADD'){
        $sql = $pdo->prepare('INSERT INTO comment (`title_id`, `content`, `created_time`, `created_user`)
            VALUES (:title_id, :content, :created_time, :created_user)');
        $sql->bindValue(':title_id', $id);
        $sql->bindValue(':content', $_POST['content']);
        $sql->bindValue(':created_time', date('Y-m-d H:i:s', time()));
        $sql->bindValue(':created_user', $_SESSION['username']);
        $sql->execute();
        header('Location: glance.php?id='.$_POST['id']);
}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>查看博客</title>
    </head>
    <body>
        <div class="container">
            <h2><?php echo $article['title'] ?></h2>
            <p>作者：<?php echo $article['created_user'] ?></p>
            <p>创建时间：<?php echo $article['created_time'] ?></p>
            <p>最后修改时间：<?php echo $article['edit_time'] ?></p>
            <pre><?php echo $article['content'] ?></pre>
        </div>
        <div class="container">
            <?php foreach ($comment as $things) { ?>
            <tr>
                <td>
                    <p><?php echo $things['created_user']; ?></p>
                    <p><?php echo $things['created_time']; ?></p>
                    <pre><?php echo $things['content']; ?></pre>
                </td>
            </tr>
            <?php } ?>
                <div>
                    <h2>评论区：</h2>
                    <form action="glance.php?id=<?php echo $id ?>" method="POST">
                        <input style="display:none;" name="id" value="<?php echo $id; ?>">
                        <textarea class="form-control" placeholder="在此输入您的评论" name="content"></textarea>
                        <input type="submit" value="ADD" name="action">
                    </form>
                </div>
        </div>
    </body>
</html>