<?php
/**
 * Created by PhpStorm.
 * User: mst82
 * Date: 2016/11/5
 * Time: 16:42
 */
//数据库连接
$servername = "localhost";
$username = "root";
$password = "85668029";
$dbname = "demo";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
//设置编码
mysqli_set_charset($conn, "utf8");