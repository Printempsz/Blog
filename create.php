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
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
        <h2 align="center">写一篇新的Blog<br><br></h2>
        <title>新建一个博客</title>
    </head>
    <body>
        <div class="container">
            <form action="index.php" method="post">
                <table class="table">
                    <div>
                        <input class="form-control" palceholder="在此处输入标题" type="text" name="title">
                    </div>
                    <div>
                        <textarea class="form-control" placeholder="在此输入详情" name="content"> </textarea>   
                    </div>
                    <div>
                        <input type="submit" value="save" name="action" class="btn btn-success">
                    </div>

                </table>
        </div>
    </body>
</html>
