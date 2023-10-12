
<?php
    include_once("tools/Mysql.php");
    include_once("model/Admin.php");
    include_once ("model/Teacher.php");
    include_once ("model/Student.php");

    if(isset($_POST['submit'])){
        $account = "";
        $password = "";
        $accountErr = "";
        $passErr = "";
        $result = null;

        $customRadio =  $_POST['customRadio'];
        $db = new Mysql();
        /*check email*/
        if (empty($_POST["account"])) {
            $emailErr = "Account is empty.";
        }else {
            $account = $_POST["account"];
        }

        if(empty($_POST['password'])){
            $passErr = "Password is empty.";
        }else{
            $password = sha1($_POST['password']);
        }

        switch ($customRadio) {
            case "admin":
                $admin = new Admin();
                $admin->setUserName($account);
                $admin->setPassword($password);
                setcookie("power","admin",time()+3600);
                $result = $db -> select_one($admin::$db_name,'',$admin);
                break;

            case "teacher":
                $teacher = new Teacher();
                $teacher->setEmail($account);
                $teacher->setPassword($password);
                setcookie("power","teacher",time()+3600);
                $result = $db -> select_one($teacher::$db_name,'',$teacher);
                break;

            case "student":
                $student = new Student();
                $student->setStudentNumber($account);
                $student->setPassword($password);
                setcookie("power","student",time()+3600);
                $result = $db -> select_one($student::$db_name,'',$student);
                break;
        }


        if($accountErr == "" && $passErr == ""){
            if(!empty($result)){
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        foreach ($row as $k => $v) {
                            if(!empty($_COOKIE[$k])){
                                setcookie($k,$v,time()+3600);
                            }else{
                                setcookie($k,$v,time()+3600);
                            }
                        }
                    }

                    switch ($customRadio) {
                        case "admin":
                            header("location:admin/admin_index.php");
                            break;

                        case "teacher":
                            header("location:teacher/teacher_index.php");
                            break;

                        case "student":
                            header("location:student/student_index.php");
                            break;
                    }

                   // echo "login success";

                }else{
                    $accountErr="Can't find user or wrong password";
                }
            } else {
                $accountErr="Can't find user or wrong password";
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<header class="header align-self-center">
    <div class="login-logo">
        <a href="#"><b>FCUC</b> FYP</a>
    </div>
</header>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">

        <div class="card-header text-center">
            <p class="h1"><b>Login</b></p>
            <p>David Gong FYP</p>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="row ">
                    <div class="custom-control custom-radio col-md-4">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="admin" checked>
                        <label for="customRadio1" class="custom-control-label">Admin</label>
                    </div>
                    <div class="custom-control custom-radio col-md-4">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="teacher">
                        <label for="customRadio2" class="custom-control-label">Teacher</label>
                    </div>
                    <div class="custom-control custom-radio col-md-4">
                        <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" value="student">
                        <label for="customRadio3" class="custom-control-label">Student</label>
                    </div>
                </div>
                <br>
                <div class="input-group mb-3">
                    <input type="text" class="form-control <?php echo (!empty($accountErr)) ? 'is-invalid' : ''; ?>" placeholder="Account/Email/Student Number" id="email" name="account" required="required">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback"><?php echo $accountErr; ?></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control <?php echo (!empty($passErr)) ? 'is-invalid' : ''; ?>" placeholder="Password" id="password" name="password" required="required">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback"><?php echo $passErr; ?></div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>

                    <p class="mb-1">
                       If you forget the password please contact the administrator.
                    </p>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<!-- /.login-box -->
<footer class="footer text-center">
    <strong>David Gong B1146 @ FYP</strong>
    <div class="inline-block">
         First City University College
    </div>
</footer>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
