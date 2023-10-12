<?php
include_once("../model/Admin.php");
include_once("../model/Assessment.php");
include_once("../model/LearningOutcome.php");
include_once("../model/Program.php");
include_once("../model/ProgrammeOutcome.php");
include_once("../model/Question.php");
include_once("../model/QuestionMark.php");
include_once("../model/student.php");
include_once("../model/Subject.php");
include_once("../model/Teacher.php");
include_once("../model/Semester.php");
include_once("../model/SemesterStudent.php");
include_once("../tools/Page.php");
include_once("../tools/Common.php");
include_once("../tools/Mysql.php");
$errInfor = "";
$db = new Mysql();
$common = new Common();


function logout(){
    header("location: ../login.php");
    exit;
}

if(!isset($_COOKIE['power']) ){
    logout();
}else{
    $result=null;
    switch ($_COOKIE['power']) {
        case "admin":
            $admin = new Admin();
            $admin->setUserName($_COOKIE['user_name']);
            $admin->setPassword($_COOKIE['password']);
            $result = $db -> count($admin::$db_name,$admin);
            break;

        case "teacher":
            $teacher = new Teacher();
            $teacher->setEmail($_COOKIE['email']);
            $teacher->setPassword($_COOKIE['password']);
            $result = $db -> count($teacher::$db_name,$teacher);
            break;

        case "student":
            $student = new Student();
            $student->setStudentNumber($_COOKIE['student_number']);
            $student->setPassword($_COOKIE['password']);
            $result = $db -> count($student::$db_name,$student);
            break;
    }
    if($result==0){
        logout();
    }
}


//$myLogout = logout();
?>