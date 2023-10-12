<?php include 'teacher_inc_header.php' ?>
<?php
$assessment = new Assessment();
$assessment_id = "";
$subject_id = "";
$assessment_name = "";
$total_question_number = 0;
$questionResult = "";
$type="";
$weight=0;
$data = array();
if(isset($_GET['assessment_id'])){
    $assessment_id = $_GET['assessment_id'];
    $assessment->setAssessmentId($assessment_id);


    $db_name = "t_assessment a,t_subject s,t_teacher_user t ";
    $condition = " a.subject_id=s.subject_id and s.lecturer=t.staff_number and a.assessment_id = '$assessment_id' ";
    $column = "s.subject_id,s.model_code,s.model_name,s.model_sname,a.assessment_id,a.assessment_name,a.type,a.weight,s.lecturer,t.user_name as teacher_name ";

    $result = $db->select_one($db_name,$column,$condition);

    if(!empty($result)){
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_object()) {
               $data = array("subject_id"=>($row->subject_id),
                    "model_code"=>($row->model_code),
                    "model_name"=>($row->model_name),
                    "model_sname"=>($row->model_sname),
                    "assessment_id"=>($row->assessment_id),
                    "assessment_name"=>($row->assessment_name),
                    "type"=>($row->type),
                    "weight"=>($row->weight),
                     "lecturer"=>($row->lecturer),
                     "teacher_name"=>($row->teacher_name));
                }
                switch ($data['type']){
                    case '0':{
                        $type="Assignment";
                        break;
                    }
                    case '1':{
                        $type="Classwork";
                        break;
                    }
                    case '2':{
                        $type="Tutorial";
                        break;
                    }
                    case '3':{
                        $type="Midterm Test";
                        break;
                    }
                    case '4':{
                        $type="Final Exam";
                        break;
                    }
                    case '5':{
                        $type="Quize";
                        break;
                    }
                }
            }
        $subject_id = $data['subject_id'];
        $weight = $data['weight'];
        $assessment_name = $data['assessment_name'];
        $total_question_number = $db->count("t_question","assessment_id='".$data['assessment_id']."'");

    }

}



?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Assessment Information</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_infor_subject.php?subject_id=<?php echo $subject_id?>">Subject Information</a></li>
                            <li class="breadcrumb-item"><a href="#">Assessment Information</a></li>
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
                                        <h3 class="card-title">Assessment Information</h3>
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
                                            <label for="bookTypeName">Assessment Name</label>
                                            <input type="text" id="assessment_name" name="assessment_name" class="form-control" value="<?php echo $data['assessment_name'] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="bookTypeName">Type</label>
                                            <input type="text" id="type" name="type" class="form-control" value="<?php echo $type ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeShelfNumber">Weight</label>
                                            <input  type="text" id="weight" name="weight" class="form-control"  value="<?php echo $data['weight']."%" ?>"  disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-9">
                            <div class="card card-primary ">
                                <?php include 'teacher_inc_questionList.php' ?>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-success">
                                <?php
                                    include 'teacher_inc_studentMarkList.php'
                                 ?>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
    </div>

<?php include 'teacher_inc_footer.php' ?>