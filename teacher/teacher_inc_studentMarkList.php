<div class="card-header">
    <h3 class="card-title">Student Mark List</h3>
</div>

<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr >
            <th style="width: 5%;text-align: center">
                <strong><i>Question</i></strong>
            </th>
            <?php
            require '../../vendor/autoload.php';
            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue( 'A1', $assessment_name);
            $sheet->setCellValue( 'B1', $assessment_id);

            $condition = "q.assessment_id = '$assessment_id'";
            $question = new Question();
            $questionCount = $db->count($question::$db_name." q",$condition);

            $excelUrl = '../xls/'.$assessment_id.'.xlsx';

            if($questionCount > 0 ){
                if($condition != ""){
                    $condition="and ".$condition;
                }
                $db_name = "t_question q,t_lo lo,t_po po";
                $tbCondition="q.lo_id = lo.lo_id and lo.po_id = po.po_id ";
                $column = "q.question_id,q.question_code,q.subject_id,q.assessment_id,q.full_mark,q.lo_id,lo.lo_code,lo.lo_name,po.po_id,po.po_code,po.po_name ";
                $condition = $tbCondition.$condition;
                $questionResult = $db->select_more($db_name,$column,$condition."order by q.question_code ASC");
                $width = (100-15)/$questionCount;
                $inCondition = "";
                $chart = 0;
                $sheet->setCellValue( 'A2', "Question Code");
                $sheet->setCellValue( 'A3', "Lo Code");
                $sheet->setCellValue( 'A4', "PO Code");
                $sheet->setCellValue( 'A5', "Full Mark");
                $sheet->setCellValue( 'A6', "student Number(dont write)");
                foreach ($questionResult as $data){
                    $sheet->setCellValue( pack("C1",66+$chart).'2', $data['question_code']);
                    $sheet->setCellValue( pack("C1",66+$chart).'3', $data['lo_code']);
                    $sheet->setCellValue( pack("C1",66+$chart).'4', $data['po_code']);
                    $sheet->setCellValue( pack("C1",66+$chart).'5', $data['full_mark']);
                    $sheet->setCellValue( pack("C1",66+$chart).'6', "Mark");
                    $chart++;
                    $inCondition.="'".$data['question_id']."',";
    $html=<<<A
                        <th style="width: $width;">
                            {$data['question_code']}
                        </th>
A;

                    echo $html;
                }
                $inCondition = mb_substr($inCondition,0,strlen($inCondition)-1);
                $writer = new Xlsx($spreadsheet);
                $writer->save($excelUrl);
            }

            ?>
            <th style="width: 5%">
                Total
            </th>
            <th style="width: 5%">
                Weighted
            </th>
            <th style="width: 5%">
            </th>
        </tr>
        <tr>
            <th style="width: 5%;text-align: center">
                <strong><i>LO</i></strong>
            </th>
            <?php
            if($questionCount > 0 ){

                foreach ($questionResult as $data){
                    $html=<<<A
                    <th style="width: $width">
                        {$data['lo_code']}
                    </th>
A;
                    echo $html;
                }
            }

            ?>
            <th style="width: 5%">
            </th>
            <th style="width: 5%">
            </th>
            <th style="width: 5%">
            </th>
        </tr>
        <tr>
            <th style="width: 5%;text-align: center">
                <strong><i>PO</i></strong>
            </th>
            <?php
            if($questionCount > 0 ) {
                foreach ($questionResult as $data) {
                    $html = <<<A
                    <th style="width: $width">
                        {$data['po_code']}
                    </th>
A;
                    echo $html;
                }
            }
            ?>
            <th style="width: 5%">
            </th>
            <th style="width: 5%">
            </th>
            <th style="width: 5%">
            </th>
        </tr>
        <tr>
            <th style="width: 5%;text-align: center">
                <strong><i>Full Mark</i></strong>
            </th>
            <?php
            if($questionCount > 0 ) {
                $totalMark = 0;
                foreach ($questionResult as $data){
                    $totalMark+=$data['full_mark'];
                    $html=<<<A
                    <th style="width: $width;color: deepskyblue">
                        {$data['full_mark']}
                    </th>
A;
                    echo $html;
                }
                $weightedTotal = $totalMark/100*$weight;
            }

            ?>
            <?php
            if($questionCount > 0 ) {
                if($totalMark < 100){
                    $html=<<<A
                    <th style="width: $width;color: red">
                       $totalMark
                    </th>
A;
                    echo $html;
                }else{
                    $html=<<<A
                    <th style="width: $width;color: deepskyblue">
                       $totalMark
                    </th>
A;
                    echo $html;
                }
            }
            ?>
            <th style="width: 5%">

            </th>
            <th style="width: 5%">
                <?php
                if($questionCount > 0 ) {
                    echo $weightedTotal;

                }
                ?>
            </th>
            <th style="width: 5%">
            </th>
        </tr>
        </thead>


        <tbody>
        <?php
        if($questionCount > 0){
            $condition = "";
            $startNo = 0;
            if(isset($_REQUEST['studentUser_page'])){
                $pageNumber = $_REQUEST['studentUser_page'];
                $startNo = ($pageNumber-1) * 10;
            }

            $db_name = "t_student_user s,t_semester_student sms,t_subject sb";
            $condition="sb.semester_id = sms.semester_id and sms.student_number = s.student_number and sb.subject_id = '$subject_id' ";
            $pageCount = $db->count($db_name,$condition);

            $markPage = new Page($pageCount,"",true,"studentUser_");

            $limit = " limit $startNo,10";
            $column = "s.student_number,s.user_name ";
            $result = $db->select_more($db_name,$column,$condition,$limit);

            foreach ($result as $data){
                $db_name = "t_student_user s,t_question_marks tqm ";
                $condition = "tqm.student_number = s.student_number and tqm.student_number='".$data['student_number']."'  and tqm.question_id in (".$inCondition.") ORDER BY FIELD(`question_id`, ".$inCondition.") ";
                $column = "s.student_number,tqm.mark ";
                $markResult = $db->select_more($db_name,$column,$condition);
                $count = $db->count($db_name,$condition);
                if($count>0){
                    $html=<<<A
                         <tr >
                            <td>
                              {$data['student_number']}
                            </td>
A;
                    echo $html;
                    $totalMark = 0;
                    $weightedTotal = 0;
                    foreach ($markResult as $markData){
                        $totalMark+=$markData['mark'];
                        $html=<<<A
                            <td >
                                {$markData['mark']}
                            </td>
A;
                        echo $html;
                        $weightedTotal = $totalMark/100*$weight;
                    }
                    $html=<<<A
                            <td>
                              $totalMark
                            </td>
                            <td>
                              $weightedTotal
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteStudentMarkModal" onclick="setData('delete_student_mark','{$data['student_number']}');setData('delete_student_mark_assessment_id','$assessment_id');">
                                    <i class="fas fa-trash"></i>
                            Delete
                                </a>
                            </td>
                        </tr>
A;
                    echo $html;
                }
            }
        }

        ?>

        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    <?php
    if($questionCount > 0){
        echo $markPage->fpage();
    }

    ?>

    <a data-toggle="modal" data-target="#addStudentMarkModel" class="btn btn-success float-right" onclick="setData('qm_assessment_id','<?php echo $assessment_id?>');">
        <i class="fas fa-plus"></i>
        Add Student Mark
    </a>
    <span class="float-right" >  &nbsp;&nbsp;</span>
    <a data-toggle="modal" data-target="#excelModel" class="btn btn-info float-right"  onclick="setData('excel_assessment_id','<?php echo $assessment_id?>');">
        <i class="fas fa-file-excel"></i>
        Excel
    </a>
</div>

<?php
if(isset($_POST['excel_submit'])){

    echo("<script>console.log('aaaaaaaaaaaa');</script>");
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
    echo("<script>console.log('".$path."');</script>");
    /*以时间来命名上传的文件*/
    $strs = date ( 'Ymdhis' );
    $file_name = $strs . "." . $file_type;
    /*是否上传成功*/
    if (!move_uploaded_file($tmp_file, $path ."/". $file_name)){
        echo("<script>console.log('upload fail');</script>");
    } else {

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path ."/". $file_name);
        $worksheet = $spreadsheet->getSheet(0);
        $data = $worksheet->toArray();  // 转为数组
        echo("<script>console.log('".json_encode($data)."');</script>");
        if($data[0][1] != $_POST['excel_assessment_id']){
            $errInfor="error data ,can't find assessment.";
        }else{
            $question = new Question();
            $column = "question_id,question_code,full_mark ";
            $condition = "assessment_id = '".$_POST['excel_assessment_id']."'";
            $questionResult = $db->select_more($question::$db_name,$column,$condition." order by question_code ASC");
            $highestColumn = $worksheet->getHighestColumn();
            $highestRow = $worksheet->getHighestRow(); // 总行数
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            $qm = new QuestionMark();
            for($i=6;$i<=$highestRow;$i++){
                $colum = 0;
                $qm->setStudentNumber($data[$i][$colum]);//student number
                $colum++;
                foreach ($questionResult as $questionData){
                    $qm->setMarkId(uniqid());
                    $qm->setQuestionId($questionData['question_id']);
                    $qm->setMark($data[$i][$colum]);
                    $result = $db->insert($qm::$db_name,$qm);
                    $colum++;
                }
            }
            echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$_POST['excel_assessment_id']."');</script>");
        }
    }
}
?>

<div class="modal fade" id="excelModel" tabindex="-1" role="dialog" aria-labelledby="excelModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="excelModelLabel">Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body card-body">
                    <input type="hidden" id="excel_assessment_id" name="excel_assessment_id" class="form-control">
                    <div class="form-group">
                        <a class="btn  btn-info buttons-excel"  href="<?php echo $excelUrl?>" download>
                            <i class="fas fa-file-excel"></i>
                            Excel Upload Template
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="file">File ：</label>
                        <input type="file" name="file" id="file"><br>
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="excel_submit" value="excel_submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
if(isset($_POST['add_studentMark'])){

    $qm = new QuestionMark();

    $errInfor="";

    if(empty($_POST['student_number'])){
        $errInfor = "student number is empty";
    }

    $question = new Question();
    $column = "question_id,question_code ";
    $condition = "assessment_id = '".$_POST['qm_assessment_id']."'";
    $questionResult = $db->select_more($question::$db_name,$column,$condition." order by question_code ASC");
    $inCondition = "";
    foreach ($questionResult as $data){
        $inCondition.="'".$data['question_id']."',";
    }
    $inCondition = mb_substr($inCondition,0,strlen($inCondition)-1);

    $condition = "student_number = '".$_POST['student_number']."' and question_id in (".$inCondition.")";
    $num = $db->count($qm::$db_name,$condition);

    $qm->setStudentNumber($_POST['student_number']);
    if($num == 0){
        foreach ($questionResult as $data){
            $qm->setMarkId(uniqid());
            $qm->setQuestionId($data['question_id']);
            $qm->setMark($_POST[$data['question_id']]);
            $result = $db->insert($qm::$db_name,$qm);
        }
    }

    echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$_POST['qm_assessment_id']."');</script>");
}
?>

<div class="modal fade" id="addStudentMarkModel" tabindex="-1" role="dialog" aria-labelledby="addStudentMarkModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="addStudentMarkModelLabel">Add Student Mark</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="qm_assessment_id" name="qm_assessment_id" class="form-control">
                    <div class="form-group">
                        <label>Student Number</label>
                        <select class="form-control" id="student_number" name="student_number">
                            <?php
                            if($questionCount > 0){
                                $db_name = "t_student_user s,t_semester_student sms,t_subject sb";
                                $condition="sb.semester_id = sms.semester_id and sms.student_number = s.student_number and sb.subject_id = '$subject_id' ";
                                $column = "s.student_number,s.user_name ";
                                $result = $db->select_more($db_name,$column,$condition);

                                foreach ($result as $data){
                                    $html=<<<A
        <option value='{$data["student_number"]}' >{$data["student_number"]}({$data["user_name"]})</option>
A;
                                    echo $html;
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                        foreach ($questionResult as $data){
    $html=<<<A
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-5 col-form-label "> Question {$data['question_code']} : </label>
                            <div class="col-sm-4 float-left">
                               <input type="number" step="0.1" id="{$data['question_id']}" name="{$data['question_id']}" class="form-control" max="{$data['full_mark']}">
                            </div>
                        </div>
A;
                            echo $html;
                        }
                    }

                    ?>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_studentMark" value="add_studentMark" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>





<?php
if(isset($_POST['student_mark_delete'])){

    $errInfor="";
    $qm = new QuestionMark();
    $qm->setStudentNumber($_POST['delete_student_mark']);

    $question = new Question();
    $column = "question_id,question_code ";
    $condition = "assessment_id = '".$_POST['delete_student_mark_assessment_id']."'";
    $questionResult = $db->select_more($question::$db_name,$column,$condition);
    $qm->setStudentNumber($_POST['delete_student_mark']);

    foreach ($questionResult as $data){
        $qm->setQuestionId($data['question_id']);
        $result = $db->delete($qm::$db_name,$qm);
    }

    if(empty($errInfor)){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$_POST['delete_student_mark_assessment_id']."');</script>");
    }
}
?>
<div class="modal fade" id="deleteStudentMarkModal" tabindex="-1" role="dialog" aria-labelledby="deleteStudentMarkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="deleteStudentMarkModalLabel">Remind</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <div class="form-group">
                        <h5>Are you sure you want to delete the this Student Marks?</h5>
                        <input type="hidden" id="delete_student_mark" name="delete_student_mark" class="form-control" value="">
                        <input type="hidden" id="delete_student_mark_assessment_id" name="delete_student_mark_assessment_id" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="submit" name="student_mark_delete" value="student_mark_delete" class="btn btn-primary float-right">YES</button>
                </div>
            </form>
        </div>
    </div>
</div>
