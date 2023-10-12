<div class="card-header">
    <h3 class="card-title">Question List</h3>
</div>

<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr class="text-center">
            <th style="width: 1%">
                #
            </th>
            <th style="width: 15%">
                Question Code
            </th>
            <th style="width: 20%">
                LO Code
            </th>
            <th style="width: 20%">
                PO Code
            </th>
            <th style="width: 20%">
                full_mark
            </th>
            <th style="width: 20%">
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $condition = "";
        $startNo = 0;
        if(isset($_REQUEST['question_page'])){
            $pageNumber = $_REQUEST['question_page'];
            $startNo = ($pageNumber-1) * 10;
        }

        $condition = "q.assessment_id = '$assessment_id'";

        $question = new Question();
        $pageCount = $db->count($question::$db_name." q",$condition);

        $questionPage = new Page($pageCount,"",true,"question_");

        if($condition != ""){
            $condition="and ".$condition;
        }

        $db_name = "t_question q,t_lo lo,t_po po";
        $tbCondition="q.lo_id = lo.lo_id and lo.po_id = po.po_id ";
        $column = "q.question_id,q.question_code,q.subject_id,q.assessment_id,q.full_mark,q.lo_id,lo.lo_code,lo.lo_name,po.po_id,po.po_code,po.po_name ";
        $limit = " limit $startNo,10";
        $condition = $tbCondition.$condition;
        $result = $db->select_more($db_name,$column,$condition."order by q.question_code ASC",$limit);
        $number = $startNo;
        foreach ($result as $data){
            $number++;
            $html=<<<A
                     <tr class="text-center align-items-center justify-content-center">
                        <td>
                            {$number}
                        </td>
                        <td >
                            {$data['question_code']}
                        </td>
                        <td >
                            {$data['lo_code']}
                        </td>
                        <td >
                            {$data['po_code']}
                        </td>
                        <td >
                            {$data['full_mark']}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_question_id','{$data['question_id']}');setData('edit_question_code','{$data['question_code']}');setData('edit_full_mark','{$data['full_mark']}');setData('edit_question_assessment_id','$assessment_id');setSelectChecked('update_lo','{$data['lo_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('delete_question','{$data['question_id']}');setData('delete_question_assessment_id','$assessment_id')">
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
    echo $questionPage->fpage();

    ?>
    <a data-toggle="modal" data-target="#addModel" class="btn btn-success float-right" onclick="setData('assessment_id','<?php echo $assessment_id?>');setData('subject_id','<?php echo $subject_id?>')">
        <i class="fas fa-plus"></i>
        Add Question
    </a>
</div>



<?php
if(isset($_POST['add_question'])){

    $q = new Question();

    if(empty($_POST['question_code'])){
        $errInfor = "question code is empty";
    }

    if(empty($_POST['full_mark'])){
        $errInfor = "full mark is empty";
    }


    $q->setQuestionId(uniqid());
    $q->setQuestionCode($_POST['question_code']);
    $q->setFullMark($_POST['full_mark']);
    $q->setLoId($_POST['lo']);
    $q->setAssessmentId($_POST['assessment_id']);
    $q->setSubjectId($_POST['subject_id']);

    if($errInfor == ""){
        $result = $db->insert($q::$db_name,$q);
        if($result >= 0){
            echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$q->getAssessmentId()."');</script>");
        }else{
            $errInfor="ADD Fail";
        }
    }
}

?>
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="addModelLabel">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="assessment_id" name="assessment_id" class="form-control">
                    <input type="hidden" id="subject_id" name="subject_id" class="form-control">
                    <div class="form-group">
                        <label for="inputName">Question Code</label>
                        <input type="text" id="question_code" name="question_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Full Mark</label>
                        <input type="number" step="0.1" id="full_mark" name="full_mark" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Lo</label>
                        <select class="form-control" id="lo" name="lo">
                            <?php
                            $db_name = "t_lo";
                            $column = "lo_id,lo_code,lo_name";
                            $poCondition = "subject_id = '$subject_id'";
                            $result = $db->select_more($db_name,$column,$poCondition);
                            foreach ($result as $data){
                                $html=<<<A
    <option value='{$data["lo_id"]}' >{$data["lo_code"]}({$data["lo_name"]})</option>
A;
                                echo $html;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_question" value="add_question" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['edit_question'])){

    $q = new Question();

    if (!empty($_POST['edit_question_code'])) {
        $q->setQuestionCode($_POST['edit_question_code']);
    }
    if (!empty($_POST['edit_full_mark'])) {
        $q->setFullMark($_POST['edit_full_mark']);
    }
    if (!empty($_POST['update_lo'])) {
        $q->setLoId($_POST['update_lo']);
    }
    $result = $db->update($q::$db_name,$q," question_id ='".$_POST['edit_question_id']."'");

    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$_POST['edit_question_assessment_id']."');</script>");
    }else{
        $errInfor="Update Fail";
    }
}
?>
<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="editModelLabel">Edit Question Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="edit_question_id" name="edit_question_id" class="form-control" value="">
                    <input type="hidden" id="edit_question_assessment_id" name="edit_question_assessment_id" class="form-control" value="">
                    <div class="form-group">
                        <label for="inputName">Question Code</label>
                        <input type="text" id="edit_question_code" name="edit_question_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Full Mark</label>
                        <input type="number" step="0.1" id="edit_full_mark" name="edit_full_mark" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Lo</label>
                        <select class="form-control" id="update_lo" name="update_lo">
                            <?php
                            $db_name = "t_lo";
                            $column = "lo_id,lo_code,lo_name";
                            $poCondition = "subject_id = '$subject_id'";
                            $result = $db->select_more($db_name,$column,$poCondition);
                            foreach ($result as $data){
                                $html=<<<A
    <option value='{$data["lo_id"]}' >{$data["lo_code"]}({$data["lo_name"]})</option>
A;
                                echo $html;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_question" value="edit_question" class="btn btn-primary float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if(isset($_POST['question_delete'])){
    $q = new Question();
    $q->setQuestionId($_POST['delete_question']);

    $result = $db->delete($q::$db_name,$q);
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?assessment_id='.$_POST['delete_question_assessment_id']."');</script>");
    }else{
        $errInfor="Delete Fail";
    }
}
?>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card modal-content card-deck">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="deleteModalLabel">Remind</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <div class="form-group">
                        <h5>Are you sure you want to delete the this Question?</h5>
                        <input type="hidden" id="delete_question" name="delete_question" class="form-control" value="">
                        <input type="hidden" id="delete_question_assessment_id" name="delete_question_assessment_id" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="submit" name="question_delete" value="question_delete" class="btn btn-primary float-right">YES</button>
                </div>
            </form>
        </div>
    </div>
</div>
