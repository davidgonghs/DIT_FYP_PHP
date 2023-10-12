<!--echo("<script>console.log('".$errInfor."');</script>");-->
<!---->
<!--$where = "";-->
<!--foreach ($student as $k => $v) {-->
<!--if($v != '' && !empty($v)){-->
<!--$where .= " and ".$k."="."\\'$v\\'";-->
<!--}-->
<!--}-->
<!--echo("<script>console.log('".$where."');</script>");-->
<?php
include_once("tools/Mysql.php");

$sql = "select FORMAT(SUM(tm.tmark),2) as tmar from t_subject ts LEFT JOIN (
    Select a.subject_id,a.weight *  sum(qm.mark)/100 as tmark from t_assessment a,t_question q, t_question_marks qm 
    where a.subject_id='60f44d59893e9' and a.assessment_id = q.assessment_id and q.question_id = qm.question_id and qm.student_number = 'B1146' group BY a.assessment_id) tm ON tm.subject_id = ts.subject_id";
$db = new Mysql();
$mark = $db->query($sql);

if(!empty($mark)){
    if ($mark->num_rows > 0) {
        // output data of each row
        while($row = $mark->fetch_object()) {
            echo $row->tmar;

        }
    }
}





?>