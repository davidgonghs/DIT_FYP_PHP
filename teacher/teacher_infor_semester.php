<?php include 'teacher_inc_header.php' ?>
<?php
$semester = new Semester();
$semester_id = "";
$program_name = "";
$disabled = "";
$book_number = 0;
if(isset($_GET['semester_id'])){
    $semester_id = $_GET['semester_id'];
    $semester->setSemesterId($semester_id);
    $result = $db->select_one("t_semester s,t_program p ","s.semester_id,s.program_id,s.semester_infor,s.semester_date,p.name as program_name ","s.program_id=p.program_id and s.semester_id = '$semester_id'");
    if(!empty($result)){
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_object()) {
                $semester->setProgramId($row->program_id);
                $semester->setSemesterInfor($row->semester_infor);
                $semester->setSemesterDate($row->semester_date);
                $program_name = $row->program_name;
            }
        }
    }

    $semester_studnet_number = $db->count("t_semester_student","semester_id='".$semester_id."'");
    $semester_subject_number = $db->count("t_subject","semester_id='".$semester_id."'");

}





?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Semester Information</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_semesterList.php">Semester</a></li>
                            <li class="breadcrumb-item"><a href="teacher_infor_semester.php">Semester Information</a></li>
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
                                        <h3 class="card-title">Semester Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" id="semester_id" name="semester_id" class="form-control" value="<?php echo $semester->getSemesterId() ?>">
                                        <div class="form-group">
                                            <label for="bookTypeName">Semester Infor</label>
                                            <input type="text" id="semester_infor" name="semester_infor" class="form-control" value="<?php echo $semester->getSemesterInfor() ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Semester Date</label>
                                            <input type="text" id="semester_date" name="semester_date" class="form-control" value="<?php echo $semester->getSemesterDate() ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Total Student</label>
                                            <input id="total_student" name="total_student" class="form-control"  value="<?php echo $semester_studnet_number?>"  disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Total Subject</label>
                                            <input id="total_student" name="total_subject" class="form-control"  value="<?php echo $semester_subject_number?>"  disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="introduction">Program</label>
                                            <input id="Program" name="Program" class="form-control"  value="<?php echo $program_name?>"  disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


<!--                        --><?php //include 'userCard.inc.php' ?>

                        <div class="col-md-9">
                            <div class="card card-success">
                              <?php include 'teacher_inc_subjectList.php' ?>
                                <!-- /.card-body -->

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-info">
                                <?php include 'teacher_inc_studentList.php' ?>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </div>

<?php include 'teacher_inc_footer.php' ?>