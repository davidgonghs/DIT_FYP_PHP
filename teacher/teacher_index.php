<?php include 'teacher_inc_header.php' ?>
<?php


$teacher_user_number = 0;
$student_user_number = 0;
$subject_number = 0;
$po_number = 0;
if($teacher_program_number>0){ //如果有program 代表老师是dean
    $result = $db->select_more($program::$db_name,"program_id",$program);
    $in_condition = "program_id in (";
    foreach ($result as $data){
        $in_condition = $in_condition."'".$data['program_id']."',";
    }
    $in_condition = mb_substr($in_condition,0,strlen($in_condition)-1);
    $in_condition = $in_condition.")";

    $teacher_user_number = $db->count("t_teacher_user",$in_condition);
    $student_user_number = $db->count("t_student_user",$in_condition." and status = '1'");
    $subject_number = $db->count("t_subject",$in_condition);

    $po_number = $db->count("t_po",$in_condition);
}


if($teacher_program_number==0){  //普通老师
    $subject = new Subject();
    $subject->setLecturer($_COOKIE['staff_number']);
    $subject_number = $db->count($subject::$db_name,$subject);
    if($subject_number > 0){
        $result = $db->select_more($subject::$db_name,"subject_id",$subject);
        $in_condition = "s.subject_id in (";
        foreach ($result as $data){
            $in_condition = $in_condition."'".$data['subject_id']."',";
        }
        $in_condition = mb_substr($in_condition,0,strlen($in_condition)-1);
        $in_condition = $in_condition.")";


        $db_name = "t_subject s, t_semester ss, t_semester_student sms,t_student_user su ";
        $condition = "s.semester_id = ss.semester_id and ss.semester_id = sms.semester_id and sms.student_number = su.student_number and su.status = '1' and ".$in_condition;

        $student_user_number = $db->count($db_name,$condition);
    }
}



//echo("<script>console.log('".$in_condition."');</script>");
//$admin_user_number = $db->count("t_admin_user","");
//$teacher_user_number = $db->count("t_teacher_user","");
//$student_user_number = $db->count("t_student_user","");
//$subject_number = $db->count("t_subject","");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Home</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <?php
                if($teacher_program_number>0){
$html=<<<A
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3> $po_number</h3>
                            <p>Total Program Learning Outcome Number</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>


                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>$teacher_user_number</h3>
                            <p>Total Teacher</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
A;
                    echo $html;

                }

                ?>
                <!-- ./col -->
                <div class=" <?php
                                if($teacher_program_number>0){
                                    echo 'col-lg-3 col-6';
                                }else{
                                    echo 'col-lg-6 col-6';
                                }?>">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $student_user_number;?></h3>
                            <p>Total Student</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="<?php
                if($teacher_program_number>0){
                    echo 'col-lg-3 col-6';
                }else{
                    echo 'col-lg-6 col-6';
                }?>">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $subject_number;?></h3>
                            <p>Total Subject Number</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">Subject</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 100%;">
                                    <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Model Code">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default" onclick="search()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr class="text-center">
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th style="width: 10%">
                                        Model Code
                                    </th>
                                    <th style="width: 20%">
                                        Model Name
                                    </th>
                                    <th style="width: 10%">
                                        Model Sname
                                    </th>
                                    <th style="width: 20%">
                                        Lecturer
                                    </th>
                                    <th style="width: 15%">
                                        Program
                                    </th>
                                    <th style="width: 25%">
                                        Semester
                                    </th>
                                    <th style="width: 5%">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $condition = "";
                                $startNo = 0;
                                if(isset($_REQUEST['subject_page'])){
                                    $pageNumber = $_REQUEST['subject_page'];
                                    $startNo = ($pageNumber-1) * 10;
                                }
                                if(isset($_REQUEST['search'])){
                                    $search = $_REQUEST['search'];
                                    $condition = "s.model_code like '%$search%'";
                                }

                                $staff_number = $_COOKIE['staff_number'];
                                $condition = "s.lecturer ='$staff_number'";

                                $in_condition = "";
                                if($teacher_program_number>0){ //如果有program 代表老师是dean
                                    $result = $db->select_more($program::$db_name,"program_id",$program);
                                    $in_condition = "s.program_id in (";
                                    foreach ($result as $data){
                                        $in_condition = $in_condition."'".$data['program_id']."',";
                                    }
                                    $in_condition = mb_substr($in_condition,0,strlen($in_condition)-1);
                                    $in_condition = $in_condition.")";
                                    if($condition != ""){
                                        $condition = $condition."and ".$in_condition;
                                    }else{
                                        $condition = $in_condition;
                                    }
                                }

                                $subject = new Subject();
                                $pageCount = $db->count($subject::$db_name." s",$condition);

                                $page = new Page($pageCount,"",true,"subject_");
                                if($condition != ""){
                                    $condition="and ".$condition;
                                }
                                $tbCondition="s.program_id=p.program_id and s.lecturer = t.staff_number and s.semester_id = sm.semester_id ";
                                $limit = " limit $startNo,10";
                                $condition = $tbCondition.$condition;

                                $db_name = "t_subject s,t_program p,t_teacher_user t,t_semester sm ";
                                $column = "s.subject_id,s.model_code,s.model_name,s.model_sname,s.lecturer,s.program_id,p.name as program_name,t.user_name as teacher_name,sm.semester_date,sm.semester_infor,s.semester_id ";
                                $result = $db->select_more($db_name,$column,$condition,$limit);
                                $number = $startNo;
                                foreach ($result as $data){
                                    $number++;
                                    $html=<<<A
                             <tr class="text-center align-items-center justify-content-center">
                                <td>
                                    {$number}
                                </td>
                                <td >
                                    {$data['model_code']}
                                </td>
                                <td >
                                    {$data['model_name']}
                                </td>
                                <td >
                                    {$data['model_sname']}
                                </td>
                                <td >
                                    {$data['teacher_name']}
                                </td>
                                <td >
                                    {$data['program_name']}
                                </td>
                                <td >
                                    {$data['semester_date']}({$data['semester_infor']})
                                </td>
                                
                                <td class="project-actions text-right">
                                   <a class="btn btn-info btn-sm" href="teacher_graph.php?subject_id={$data['subject_id']}">
                                        <i class="fas fa-chart-bar"></i> 
                                Graph
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="teacher_infor_subject.php?subject_id={$data['subject_id']}">
                                        <i class="fas fa-folder"></i> 
                                View 
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
                        <div class="card-footer clearfix">
                            <?php
                            echo $page->fpage();
                            ?>
                        </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php include 'teacher_inc_footer.php' ?>




