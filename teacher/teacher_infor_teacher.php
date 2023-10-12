<?php include 'teacher_inc_header.php' ?>
<?php
$teacher = new Teacher();
$teacher_id = "";
$program_name = "";
$disabled = "";
$book_number = 0;
if(isset($_GET['teacher_id'])){
    $teacher_id = $_GET['teacher_id'];
    $teacher->setStaffNumber($teacher_id);
    $db_name = "t_teacher_user t ";
    $column = "t.staff_number,t.user_name,t.email ";
    $condition="t.staff_number = '$teacher_id' ";
    $result = $db->select_one($db_name,$column,$condition);
    if(!empty($result)){
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_object()) {
                $teacher->setEmail($row->email);
                $teacher->setUserName($row->user_name);
            }
        }
    }

    $total_subject_number = $db->count("t_subject","lecturer='".$teacher_id."'");
}



?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Teacher Information</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_teacherUserLIst.php">Teacher</a></li>
                            <li class="breadcrumb-item"><a href="teacher_infor_teacher.php">Teacher Information</a></li>
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
                                        <h3 class="card-title">Teacher Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="bookTypeName">Teacher</label>
                                            <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo $teacher->getUserName() ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $teacher->getEmail() ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Total Subject</label>
                                            <input id="total_subject" name="total_subject" class="form-control"  value="<?php echo $total_subject_number?>"  disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-success">
                                <?php include 'teacher_inc_subjectList.php' ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </div>

<?php include 'teacher_inc_footer.php' ?>