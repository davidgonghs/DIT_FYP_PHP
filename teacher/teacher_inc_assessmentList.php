<div class="card-header">
    <h3 class="card-title">Assessment List</h3>
</div>
<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr class="text-center">
            <th style="width: 1%">
                #
            </th>
            <th style="width: 20%">
                Assessment Name
            </th>
            <th style="width: 20%">
                Weight
            </th>
            <th style="width: 15%">
                Type
            </th>
            <th style="width: 20%">
                Total Question
            </th>
            <th style="width: 20%">
            </th>
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

        $condition = "a.subject_id = '$subject_id'";

        $assessment = new Assessment();
        $pageCount = $db->count($assessment::$db_name." a",$condition);

        $userePage = new Page($pageCount,"",true,"assessment_");

        if($condition != ""){
            $condition="and ".$condition;
        }


        $tbCondition="a.subject_id = s.subject_id ";
        $limit = " limit $startNo,10";
        $condition = $tbCondition.$condition;

        $db_name = "t_assessment a,t_subject s ";
        $column = "a.assessment_id,a.assessment_name,a.subject_id,a.type,a.weight ";
        $result = $db->select_more($db_name,$column,$condition,$limit);
        $number = $startNo;
        foreach ($result as $data){
            $number++;
            $type = "";
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
            $total_question_number = $db->count("t_question","assessment_id='".$data['assessment_id']."'");
            $html=<<<A
                     <tr class="text-center align-items-center justify-content-center">
                        <td>
                            {$number}
                        </td>
                        <td >
                            {$data['assessment_name']}
                        </td>
                        <td >
                            {$data['weight']}%
                        </td>
                        <td >
                            $type
                        </td>
                        <td >
                            $total_question_number
                        </td>
                        <td class="project-actions text-right">
                           <a class="btn btn-primary btn-sm" href="teacher_infor_assessment.php?assessment_id={$data['assessment_id']}">
                                        <i class="fas fa-folder"></i> 
                                View 
                            </a>
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editAssessmentModel" onclick="setData('edit_assessment_id','{$data['assessment_id']}');setData('edit_assessment_name','{$data['assessment_name']}');setData('edit_weight','{$data['weight']}');setData('edit_assessment_subject_id','$subject_id');setSelectChecked('update_type','{$data['type']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteAssessmentModal" onclick="setData('delete_assessment_id','{$data['assessment_id']}');setData('delete_assessment_subject_id','$subject_id')">
                                <i class="fas fa-trash"></i>
                        Delete
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
<!-- /.card-body -->
<div class="card-footer clearfix">
    <?php
    echo $userePage->fpage();

    ?>
    <a data-toggle="modal" data-target="#addAssessmentModel" class="btn btn-success float-right" onclick="setData('add_assessment_subject_id','<?php echo $subject_id?>')">
        <i class="fas fa-plus"></i>
        Add Assessment
    </a>
</div>



<?php
if(isset($_POST['add_assessment'])){

    $assessment = new Assessment();
    if(empty($_POST['assessment_name'])){
        $errInfor = "assessment name is empty";
    }

    if(empty($_POST['weight'])){
        $errInfor = "weight is empty";
    }

    $assessment->setAssessmentId(uniqid());
    $assessment->setAssessmentName($_POST['assessment_name']);
    $assessment->setWeight($_POST['weight']);
    $assessment->setType($_POST['type']);
    $assessment->setSubjectId($_POST['add_assessment_subject_id']);

    if($errInfor == ""){
        $result = $db->insert($assessment::$db_name,$assessment);
        if($result >= 0){
            echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$assessment->getSubjectId()."');</script>");
        }else{
            $errInfor="ADD Fail";
        }
    }
}

?>
<div class="modal fade" id="addAssessmentModel" tabindex="-1" role="dialog" aria-labelledby="addAssessmentModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="addAssessmentModelLabel">Assessment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="add_assessment_subject_id" name="add_assessment_subject_id" class="form-control" value="">
                    <div class="form-group">
                        <label for="inputName">Assignment Name</label>
                        <input type="text" id="assessment_name" name="assessment_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Weight</label>
                        <input type="number" id="weight" name="weight" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value='0' >Assignment</option>
                            <option value='1' >Classwork</option>
                            <option value='2' >Tutorial</option>
                            <option value='3' >Midterm Test</option>
                            <option value='4' >Final Exam</option>
                            <option value='5' >Quize</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_assessment" value="add_assessment" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['edit_assessment'])){

    $assessment = new Assessment();
    if (!empty($_POST['edit_assessment_name'])) {
        $assessment->setAssessmentName($_POST['edit_assessment_name']);
    }
    if (!empty($_POST['edit_weight'])) {
        $assessment->setWeight($_POST['edit_weight']);
    }
    if (!empty($_POST['update_type'])) {
        $assessment->setType($_POST['update_type']);
    }
    $result = $db->update($assessment::$db_name,$assessment," assessment_id ='".$_POST['edit_assessment_id']."'");
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$_POST['edit_assessment_subject_id']."');</script>");
    }else{
        $errInfor="Update Fail";
    }
}
?>
<div class="modal fade" id="editAssessmentModel" tabindex="-1" role="dialog" aria-labelledby="editAssessmentModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="editAssessmentModelLabel">Learning Outcome Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="edit_assessment_id" name="edit_assessment_id" class="form-control" value="">
                    <input type="hidden" id="edit_assessment_subject_id" name="edit_assessment_subject_id" class="form-control" value="">
                    <div class="form-group">
                        <label for="inputName">Assignment Name</label>
                        <input type="text" id="edit_assessment_name" name="edit_assessment_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Weight</label>
                        <input type="number" id="edit_weight" name="edit_weight" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="update_type" name="update_type">
                            <option value='0' >Assignment</option>
                            <option value='1' >Classwork</option>
                            <option value='2' >Tutorial</option>
                            <option value='3' >Midterm Test</option>
                            <option value='4' >Final Exam</option>
                            <option value='5' >Quize</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_assessment" value="edit_assessment" class="btn btn-primary float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if(isset($_POST['assessment_delete'])){
    $assessment = new Assessment();
    $assessment->setAssessmentId($_POST['delete_assessment_id']);

    $result = $db->delete($assessment::$db_name,$assessment);
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$_POST['delete_assessment_subject_id']."');</script>");
    }else{
        $errInfor="Delete Fail";
    }
}
?>
<div class="modal fade" id="deleteAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="deleteAssessmentModalLabel">Remind</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <div class="form-group">
                        <h5>Are you sure you want to delete the this Assessment?</h5>
                        <input type="hidden" id="delete_assessment_id" name="delete_assessment_id" class="form-control" value="">
                        <input type="hidden" id="delete_assessment_subject_id" name="delete_assessment_subject_id" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="submit" name="assessment_delete" value="assessment_delete" class="btn btn-primary float-right">YES</button>
                </div>
            </form>
        </div>
    </div>
</div>
