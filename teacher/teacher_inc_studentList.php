<div class="card-header">
    <h3 class="card-title">Student List</h3>
</div>

<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr class="text-center">
            <th style="width: 1%">
                #
            </th>
            <th style="width: 10%">
                Student Number
            </th>
            <th style="width: 10%">
                User Name
            </th>
            <th style="width: 20%">
                Email
            </th>
            <th style="width: 20%">
                IC/Passport
            </th>
            <th style="width: 10%">
                Program
            </th>
            <th style="width: 10%">
                Status
            </th>
            <th style="width: 20%">
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $condition = "";
        $startNo = 0;
        if(isset($_REQUEST['studentUser_page'])){
            $pageNumber = $_REQUEST['studentUser_page'];
            $startNo = ($pageNumber-1) * 10;
        }
        if(isset($_REQUEST['search'])){
            $search = $_REQUEST['search'];
            $condition = "s.student_number like '%$search%'";
        }

        $condition = "s.student_number=sms.student_number and sms.semester_id ='".$_GET['semester_id']."'";
        $semester_id = $_GET['semester_id'];

        $student = new Student();
        $db_name = "t_student_user s,t_semester_student sms";
        $pageCount = $db->count($db_name,$condition);

        $studentPage = new Page($pageCount,"",true,"studentUser_");

        if($condition != ""){
            $condition="and ".$condition;
        }

        $tbCondition="s.program_id=p.program_id ";
        $limit = " limit $startNo,10";
        $condition = $tbCondition.$condition;
        $db_name = "t_student_user s,t_program p,t_semester_student sms";
        $column = "sms.sms_id, s.student_number,s.user_name,s.email,s.ic_passport,s.program_id,p.name as program_name,s.status ";
        $result = $db->select_more($db_name,$column,$condition,$limit);
        $number = $startNo;
        foreach ($result as $data){
            $status = "graduation";
            if($data['status'] == 1){
                $status = "studying";
            }
            $number++;
            $html=<<<A
                     <tr class="text-center align-items-center justify-content-center">
                        <td>
                            {$number}
                        </td>
                        <td >
                            {$data['student_number']}
                        </td>
                        <td >
                            {$data['user_name']}
                        </td>
                        <td >
                            {$data['email']}
                        </td>
                        <td >
                            {$data['ic_passport']}
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td >
                            {$status}
                        </td>
                        <td class="project-actions text-right">
                             <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('d_sm_id','$semester_id');setData('sms_id','{$data['sms_id']}')">
                                    <i class="fas fa-trash"></i>
                            Delete
                                </a>
                            </td>
                        </tr>
A;

            echo $html;
        }

        ?>

        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    <?php
    echo $studentPage->fpage();

    ?>
    <a data-toggle="modal" data-target="#addModel" class="btn btn-success float-right" onclick="setData('sm_id','<?php echo $semester_id?>')">
        <i class="fas fa-plus"></i>
        Add Student
    </a>
</div>

<?php
if(isset($_POST['sme_student_submit'])){
    $student = new Student();
    $sms = new SemesterStudent();
    $sms->setSmsId($_POST['sm_id'].$_POST['stu_num']);
    $errInfor = "";
    if(empty($_POST['stu_num'])){
        $errInfor = "student Number is empty";
    }
    $student->setStudentNumber($_POST['stu_num']);
    $isStudent = $db->count($student::$db_name,$student);
    $isIn = $db->count($sms::$db_name,$sms);
    if($isStudent == 0){
        $errInfor .= "Can't Find ".$_POST['stu_num']." this student.";
    }else if($isIn >= 1){
        $errInfor .= "The student is alread in this semester.";
    } else{
        if (empty($errInfor)) {
            $sms->setSemesterId($_POST['sm_id']);
            $sms->setStudentNumber($_POST['stu_num']);
            $result = $db->insert($sms::$db_name, $sms);
        } else {
            $errInfor .= "ADD Fail";
        }
    }
    echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?semester_id='.$_POST['sm_id']."');</script>");
}

?>
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="addModelLabel">Add Semester Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="sm_id" name="sm_id" class="form-control" value="">
                    <div class="form-group">
                        <label for="inputName">Student Number</label>
                        <input type="text" id="stu_num" name="stu_num" class="form-control">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="sme_student_submit" value="sme_student_submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if(isset($_POST['student_delete'])){
    $student = new SemesterStudent();
    $student->setSmsId($_POST['sms_id']);

    $result = $db->delete("t_semester_student",$student);
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?semester_id='.$_POST['d_sm_id']."');</script>");
    }else{
        $errInfor="Delete Fail";
    }
}
?>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="deleteModalLabel">Remind</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <div class="form-group">
                        <h5>Are you sure you want to delete the this Student from Semester?</h5>
                        <input type="hidden" id="sms_id" name="sms_id" class="form-control" value="">
                        <input type="hidden" id="d_sm_id" name="d_sm_id" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="submit" name="student_delete" value="student_delete" class="btn btn-primary float-right">YES</button>
                </div>
            </form>
        </div>
    </div>
</div>
