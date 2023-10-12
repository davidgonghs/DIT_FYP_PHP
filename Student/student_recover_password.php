<?php include 'student_inc_header.php' ?>
<?php
if(isset($_POST['change_password'])){
    $student_number = $_COOKIE['student_number'];
    $student = new Student();
    $student->setStudentNumber($student_number);
    $student->setPassword(sha1($_POST['c_password']));
    $result = $db -> count($student::$db_name,$student);
    if($result!=0){
        if($_POST['n_password1'] != $_POST['n_password2']){
            $errInfor="New Password and New password (again) are not the same.";
        }else{
            $student->setStaffNumber($student_number);
            $student->setPassword(sha1($_POST['n_password1']));
            $result = $db->update($student::$db_name,$student," student_number='".$student_number."'");
            if($result >= 0){
                foreach ($_COOKIE as $key => $value) {
                    setcookie($key, null);
                }
                $common->refreshPage();
            }else{
                $errInfor="Update Fail";
            }
        }
    }else{
        $errInfor="Can't find user";
    }
}

?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Change Password</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Change Password</a></li>
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
                        <div class="col-md-4 m-auto">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="card-header">
                                    <h5 class="card-title m-auto">Change Password</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputName">Current Password</label>
                                        <input type="password" id="c_password" name="c_password" class="form-control" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">New Password</label>
                                        <input type="password" id="n_password1" name="n_password1" class="form-control" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">New password (again)</label>
                                        <input type="password" id="n_password2" name="n_password2" class="form-control" required="required">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <a type="button" class="btn btn-secondary" href="teacher_index.php" >Cancel</a>
                                    <button type="submit" name="change_password" value="change_password" class="btn btn-primary float-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
    </div>

<?php include 'student_inc_footer.php' ?>