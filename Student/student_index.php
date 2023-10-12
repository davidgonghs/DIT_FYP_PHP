<?php include 'student_inc_header.php' ?>
<?php


$teacher_user_number = 0;
$student_user_number = 0;
$subject_number = 0;

$student = new Student();
$student_number = $_COOKIE['student_number'];
$student->setStudentNumber($student_number);
$db_name = "t_student_user t ";
$column = "t.user_name,t.email,t.ic_passport,t.status ";
$condition="t.student_number = '$student_number' ";
$result = $db->select_one($db_name,$column,$condition);
if(!empty($result)){
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_object()) {
            $student->setEmail($row->email);
            $student->setUserName($row->user_name);
            $student->setIcPassport($row->ic_passport);
            $student->setStatus($row->status);
        }
    }
}
$status = "graduation";
if($student->getStatus() == 1){
    $status = "studying";
}


?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student Information</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="teacher_studentUserList.php">Student</a></li>
                        <li class="breadcrumb-item"><a href="teacher_infor_teacher.php">Student Information</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                <?php include '../promptBar.inc.php' ?>

                <div class="row">
                    <div class="col-md-3">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Student Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="bookTypeName">Student</label>
                                        <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo $student->getUserName() ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="bookTypeName">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $student->getEmail() ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="bookTypeName">IC/PASSPORT</label>
                                        <input type="text" id="ic_passport" name="ic_passport" class="form-control" value="<?php echo $student->getIcPassport() ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="placeShelfNumber">Status</label>
                                        <input id="status" name="status" class="form-control"  value="<?php echo $status ?>"  disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-9">
                        <div class="card card-primary ">
                            <?php include '../teacher/teacher_inc_semesterList.php' ?>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="card card-success">
                            <?php include '../teacher/teacher_inc_studentSubjectList.php' ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
</div>

<?php include 'student_inc_footer.php' ?>




