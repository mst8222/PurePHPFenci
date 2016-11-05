<?php
/**
 * Created by PhpStorm.
 * User: mst82
 * Date: 2016/11/5
 * Time: 16:42
 */
//显示编码
header("Content-type: text/html; charset=utf-8");

//引入配置文件
require_once "config.php";


//数据库操作
//$model = Darticle::find()->all();
$sql = "SELECT * FROM darticle";
$model = mysqli_query($conn, $sql);

if ($model->num_rows > 0) {
    // 输出每行数据
    while($m = $model->fetch_assoc()) {
        //实例化分词插件核心类
        $so = scws_new();
//设置分词时所用编码
        $so->set_charset('utf-8');
//设置分词所用词典(此处使用utf8的词典)
        $so->set_dict('C:/scws/etc/dict.utf8.xdb');
//设置分词所用规则
        $so->set_rule('C:/scws/etc/rules.utf8.ini ');
//分词前去掉标点符号
        $so->set_ignore(false);
//是否复式分割，如“中国人”返回“中国＋人＋中国人”三个词。
        $so->set_multi(true);
//设定将文字自动以二字分词法聚合
        $so->set_duality(true);
        //要进行分词的语句
        $so->send_text($m['title']);
        print $m['title'];
        $strl = "";
        $str2 = "";
        //获取分词结果，如果提取高频词用get_tops方法
        while ($tmp = $so->get_result())
        {
            foreach ($tmp as $t){
                if ($strl!=""){
                    $strl = $strl.",".$t['word'];
                    $str2 = $str2.",".$t['word']."(".$t['attr'].")";
                }
                else{
                    $strl = $t['word'];
                    $str2 = $t['word']."(".$t['attr'].")";
                }
            }
//                $strl = $strl.$tmp['word'];
//                print_r($tmp);
        }
        $so->close();
        print $str2."<br />";
//            $sql1 = "Update darticle Set fenci='".$strl."' Where id = ".$m['id'];
        $sql2 = "Update darticle Set cixing='".$str2."' Where id = ".$m['id'];
//            Yii::$app->db->createCommand($sql)
//                ->execute();
//        Yii::$app->db->createCommand($sql2)->execute();
        $conn->query($sql2);
//        exit();
    }
} else {
    echo "0 个结果";
}

$conn->close();