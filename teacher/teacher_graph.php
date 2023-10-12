<?php include 'teacher_inc_header.php' ?>
<?php
$subject = new Subject();
$subject_id = "";
$semester_id = "";
$program_id = "";
$disabled = "";
$total_lo_number = 0;
$data = array();
$lpMark = array();
$loCode = array();
$assessmentName = array();
$assessmentMarkArray= array();
$assessmentMark= array();
$totalAssessmentNumber = 0;
$colorSource = ['#198964', '#fbca1b','#6248f0', '#c9d9d2',  '#fb6703', '#b5f3f0', '#f0260f', '#00abff', '#617d8c'];
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
    $semester_id = $data['semester_id'];
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
                                <div class="card-header">
                                    <h3 class="card-title">Student Mark List</h3>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr >
                                            <th style="width: 10%;text-align: center">
                                                <strong><i>LO Code</i></strong>
                                            </th>
                                            <?php
                                            $condition="lo.po_id = po.po_id and lo.subject_id = '$subject_id'";
                                            $db_name = "t_lo lo,t_po po ";
                                            $column = "lo.lo_id,lo.lo_code,po.po_id,po.po_code ";
                                            $loCount = $db->count($db_name,$condition);
                                            $loResult = $db->select_more($db_name,$column,$condition." order by lo.lo_code ASC");
                                            $width = 0;
                                            if($loCount != 0){
                                                $width = (100-10)/$loCount;
                                            }

                                            foreach ($loResult as $data){
                                                array_push($loCode,$data["lo_code"]." / ".$data["po_code"]);
                                                $html=<<<A
                <th style="width: $width;">
                    {$data['lo_code']}
                </th>
A;
                                                echo $html;
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%;text-align: center">
                                                <strong><i>PO Code</i></strong>
                                            </th>
                                            <?php
                                                foreach ($loResult as $data){
                                                    $html=<<<A
                <th style="width: $width">
                        {$data['po_code']}
                </th>
A;
                                                    echo $html;
                                                }
                                            ?>
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

                                        $db_name = "t_subject s, t_semester ss, t_semester_student sms,t_student_user su ";
                                        $condition = "s.semester_id = ss.semester_id and ss.semester_id = sms.semester_id and sms.student_number = su.student_number and s.subject_id = '$subject_id' ";
                                        $column = "su.student_number,su.user_name ";
                                       // $pageCount = $db->count("t_semester_student","semester_id='".$semester_id."'");
                                        $pageCount = $db->count($db_name,$condition);


                                        $markPage = new Page($pageCount,"",true,"studentUser_");
                                        $limit = " limit $startNo,10";
                                        $result = $db->select_more($db_name,$column,$condition,$limit);
                                            foreach ($result as $data){
                                                $db_name = "t_lo lo, t_question_marks qm,t_question q ";
                                                $condition = "qm.question_id = q.question_id and q.lo_id = lo.lo_id and qm.student_number = '".$data['student_number']."' and q.subject_id = '$subject_id' GROUP BY q.lo_id ORDER BY lo.lo_code ";
                                                $column = "SUM(mark) as lmark ";
                                                $markResult = $db->select_more($db_name,$column,$condition);
                                                    $html=<<<A
                     <tr >
                        <td>
                          {$data['student_number']}
                        </td>
A;
                                                    echo $html;

                                                    foreach ($markResult as $markData){
                                                        $html=<<<A
                        <td >
                            {$markData['lmark']}
                        </td>
A;
                                                        echo $html;
                                                    }

                                                    $html=<<<A
                    </tr>
A;
                                                    echo $html;


                                        }

                                            $db_name = "t_question_marks qm,t_question q,t_lo lo ";
                                            $condition = "qm.question_id = q.question_id and q.lo_id = lo.lo_id and q.subject_id = '$subject_id' GROUP BY q.lo_id ORDER BY lo.lo_code ";
                                            $column = "SUM(mark) as sumLoMark ";
                                            $markResult = $db->select_more($db_name,$column,$condition);
                                            $semester_studnet_number = $db->count("t_semester_student","semester_id='".$semester_id."'");

                                            $html=<<<E
                     <tr >
                        <td >
                          Achievement
                        </td>
E;
                                            echo $html;
                                        if($semester_studnet_number!=0){
                                            foreach ($markResult as $markData){
                                                $achievement = $markData['sumLoMark']/$semester_studnet_number;
                                                array_push($lpMark,$achievement);
                                                $html=<<<A
                        <td >
                            $achievement
                        </td>
A;
                                                echo $html;
                                            }
                                        }
                                            $html=<<<A
                    </tr>
A;
                                            echo $html;



                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <?php
                                    if($pageCount!=0){
                                        echo $markPage->fpage();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="card card-success ">
                                <div class="card-header">
                                    <h3 class="card-title">Assessment Mark List</h3>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr >
                                            <th style="width: 10%;text-align: center">
                                                <strong><i>LO Code</i></strong>
                                            </th>
                                            <?php
                                            foreach ($loResult as $data){
                                                $html=<<<A
                    <th style="width: $width;">
                        {$data['lo_code']}
                    </th>
A;
                                                echo $html;
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%;text-align: center">
                                                <strong><i>PO Code</i></strong>
                                            </th>
                                            <?php
                                            foreach ($loResult as $data){
                                                $html=<<<A
                <th style="width: $width">
                    {$data['po_code']}
                </th>
A;
                                                echo $html;
                                            }

                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%;text-align: center">
                                                <strong><i>Full Mark</i></strong>
                                            </th>
                                            <?php
                                            foreach ($loResult as $data){

                                                $html=<<<A
                    <th style="width: $width;color: deepskyblue">
                        100.0
                    </th>
A;
                                                echo $html;
                                            }

                                            ?>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php
                                        $condition = "";
                                        $startNo = 0;
                                        if(isset($_REQUEST['assessment_page'])){
                                            $pageNumber = $_REQUEST['assessment_page'];
                                            $startNo = ($pageNumber-1) * 10;
                                        }

                                        $assessment = new Assessment();
                                        $assessment->setSubjectId($subject_id);
                                        $pageCount = $db->count($assessment::$db_name,$assessment);
                                        $aPage = new Page($pageCount,"",true,"assessment_");
                                        $limit = " limit $startNo,10";
                                        $result = $db->select_more($assessment::$db_name,"*",$assessment,$limit);

                                        foreach ($result as $data){
                                            $db_name = "t_question_marks qm,t_question q,t_lo lo ";
                                            $condition = "qm.question_id = q.question_id and q.lo_id = lo.lo_id and q.assessment_id = '".$data['assessment_id']."' and q.subject_id = '$subject_id' GROUP BY q.lo_id ORDER BY lo.lo_code ";
                                            $column = "lo.lo_code,SUM(mark) as amark ";
                                            $markResult = $db->select_more($db_name,$column,$condition);
                                            $count = $db->count($db_name,$condition);
                                            if($count>0){
                                                $totalAssessmentNumber++;
                                                array_push($assessmentName,$data['assessment_name']);
                                                $html=<<<A
                     <tr >
                        <td>
                          {$data['assessment_name']}
                        </td>
A;
                                                echo $html;

                                                $assessmentMark = array();
                                                foreach ($loResult as $loData){
                                                    $mark = 0;
$html=<<<A
                        <td >
                            -
                        </td>
A;
                                                    foreach ($markResult as $markData){
                                                        if($loData['lo_code'] == $markData['lo_code']){
                                                            $mark = $markData['amark'];
$html=<<<A
                        <td >
                            {$markData['amark']}
                        </td>
A;
                                                        }
                                                    }
                                                    echo $html;
                                                    array_push($assessmentMark,$mark);
                                                }
                                                array_push($assessmentMarkArray,$assessmentMark);

                                                $html=<<<A
                    </tr>
A;
                                                echo $html;

                                            }
                                        }

                                        $db_name = "t_question_marks qm,t_question q,t_lo lo ";
                                        $condition = "qm.question_id = q.question_id and q.lo_id = lo.lo_id and q.subject_id = '$subject_id' GROUP BY q.lo_id ORDER BY lo.lo_code ";
                                        $column = "SUM(mark) as sumLoMark ";
                                        $markResult = $db->select_more($db_name,$column,$condition);
                                        $html=<<<E
                     <tr >
                        <td>
                          Total
                        </td>
E;
                                        echo $html;


                                        foreach ($markResult as $markData){
                                            $loTotal = $markData['sumLoMark'];
                                            $html=<<<A
                        <td >
                            {$markData['sumLoMark']}
                        </td>
A;
                                            echo $html;
                                        }
                                        $html=<<<A
                    </tr>
A;
                                        echo $html;


                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <?php
                                    echo $aPage->fpage();

                                    ?>
                                </div>
                            </div>
                        </div>




                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"> <i class="far fa-chart-bar"></i>  Percentage of LO/PO Achievement</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="stackedBarChart" style="min-height: 250px; height: 100%; max-height: 100%; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h3 class="card-title"> <i class="far fa-chart-bar"></i>  Percentage of LO/PO Assessment Component</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="loStackedBarChart" style="min-height: 250px; height: 100%; max-height: 100%; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>


                    </div>



                </section>
            </div>
    </div>

<?php include 'teacher_inc_footer.php' ?>

<script>
    $(function () {

        var areaChartData = {
            labels  :<?php echo json_encode($loCode); ?>,
            datasets: [
                {
                    label               : 'Lo Achievement',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : true,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : <?php echo json_encode($lpMark); ?>
                }
            ]
        }
        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, areaChartData)

        var stackedBarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })










        var loStackedBarChartData = {
            labels  :<?php echo json_encode($loCode); ?>,
            datasets: [
                <?php
                $data="";
                for($i=0;$i<$totalAssessmentNumber;$i++){
                    $data .= " {label:'$assessmentName[$i]',
                    backgroundColor:'$colorSource[$i]',
                    borderColor:'$colorSource[$i]',
                    pointRadius:true,
                    pointColor:'$colorSource[$i]',
                    pointStrokeColor:'$colorSource[$i]',
                    pointHighlightFill:'#fff',
                    pointHighlightStroke:'$colorSource[$i]',
                    data:".json_encode($assessmentMarkArray[$i])."},";
                }
                echo $data;
                ?>
            ]




        }

        var loStackedBarChartCanvas = $('#loStackedBarChart').get(0).getContext('2d')
        var loStackedBarChartData = $.extend(true, {}, loStackedBarChartData)

        var loStackedBarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(loStackedBarChartCanvas, {
            type: 'bar',
            data: loStackedBarChartData,
            options: loStackedBarChartOptions
        })



    })
</script>
