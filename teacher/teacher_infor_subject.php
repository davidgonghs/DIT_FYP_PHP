<?php include 'teacher_inc_header.php' ?>
<?php
$subject = new Subject();
$subject_id = "";
$program_id = "";
$disabled = "";
$book_number = 0;
$data = array();
if(isset($_GET['subject_id'])){
    $subject_id = $_GET['subject_id'];
    $subject->setSubjectId($subject_id);
    $db_name = "t_subject s,t_program p,t_teacher_user t,t_semester sm ";
    $condition="s.program_id=p.program_id and s.lecturer = t.staff_number and s.semester_id = sm.semester_id and s.subject_id = '$subject_id' ";
    $column = "s.subject_id,s.model_code,s.model_name,s.model_sname,s.lecturer,s.program_id,p.name as program_name,t.user_name as teacher_name,sm.semester_date,sm.semester_infor,s.semester_id ";

    $result = $db->select_one($db_name,$column,$condition);

    if(!empty($result)){
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_object()) {
                $data = array("subject_id"=>($row->subject_id),
                    "model_code"=>($row->model_code),
                    "model_name"=>($row->model_name),
                    "model_sname"=>($row->model_sname),
                    "lecturer"=>($row->lecturer),
                    "program_id"=>($row->program_id),
                    "program_name"=>($row->program_name),
                    "teacher_name"=>($row->teacher_name),
                    "semester_date"=>($row->semester_date),
                    "semester_infor"=>($row->semester_infor),
                    "semester_id"=>($row->semester_id));

            }
        }
    }
    $program_id = $data['program_id'];
    $assessment_number = $db->count("t_assessment","subject_id='".$subject_id."'");
    $semester_studnet_number = $db->count("t_semester_student","semester_id='".$data['semester_id']."'");
}





?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Subject Information</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Subject Information</a></li>
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
                        <div class="col-md-2">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Subject Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="bookTypeName">Model Code</label>
                                            <input type="text" id="model_code" name="model_code" class="form-control" value="<?php echo $data['model_code'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Model Name</label>
                                            <input type="text" id="model_name" name="model_name" class="form-control" value="<?php echo $data['model_name'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Model Sname</label>
                                            <input type="text" id="model_sname" name="model_sname" class="form-control" value="<?php echo $data['model_sname'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Teacher Name</label>
                                            <input type="text" id="teacher_name" name="teacher_name" class="form-control" value="<?php echo $data['teacher_name'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Program Name</label>
                                            <input type="text" id="program_name" name="program_name" class="form-control" value="<?php echo $data['program_name'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Semester Infor</label>
                                            <input type="text" id="semester_infor" name="semester_infor" class="form-control" value="<?php echo $data['semester_date']."(".$data['semester_infor'].")" ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Total Student</label>
                                            <input  type="text" id="total_student" name="total_student" class="form-control"  value="<?php echo $semester_studnet_number?>"  disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Total Assessment</label>
                                            <input  type="text" id="total_assessment" name="total_assessment" class="form-control"  value="<?php echo $assessment_number?>"  disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-10">
                            <div class="card card-primary ">
                                <?php include 'teacher_inc_learningOutcome.php' ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-success">
                                <?php include 'teacher_inc_assessmentList.php' ?>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
    </div>

<?php include 'teacher_inc_footer.php' ?>