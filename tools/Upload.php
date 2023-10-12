<?php

$tmp_file = $_FILES ['file'] ['tmp_name'];
$file_types = explode ( ".", $_FILES ['file']['name'] );
$file_type = $file_types [count ( $file_types ) - 1];
/*判别是不是.xls文件，判别是不是excel文件*/
/*设置上传路径*/
$path = "../upload/";
if(!file_exists($path))//判断文件夹是否存在
{
    mkdir($path);
}
/*以时间来命名上传的文件*/
$strs = date ( 'Ymdhis' );
$file_name = $strs . "." . $file_type;
/*是否上传成功*/
if (!move_uploaded_file($tmp_file, $path ."/". $file_name)){
    $this->error ( '上传失败' );
} else {
    //echo "yes";
}
?>
