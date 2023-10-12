<div class="card-header">
    <h3 class="card-title">Learning Outcome</h3>
</div>

<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr class="text-center">
            <th style="width: 1%">
                #
            </th>
            <th style="width: 10%">
                LO Code
            </th>
            <th style="width: 30%">
                LO Infor
            </th>
            <th style="width: 10%">
                PO Code
            </th>
            <th style="width: 10%">
                PO Name
            </th>
            <th style="width: 10%">
                Program
            </th>
            <th style="width: 20%">
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $condition = "";
        $startNo = 0;
        if(isset($_REQUEST['lo_page'])){
            $pageNumber = $_REQUEST['lo_page'];
            $startNo = ($pageNumber-1) * 10;
        }

        $condition = "lo.subject_id = '$subject_id'";

        $lo = new LearningOutcome();
        $pageCount = $db->count($lo::$db_name." lo",$condition);

        $userePage = new Page($pageCount,"",true,"lo_");

        if($condition != ""){
            $condition="and ".$condition;
        }


        $tbCondition="lo.po_id = po.po_id and po.program_id=p.program_id ";
        $limit = " limit $startNo,10";
        $condition = $tbCondition.$condition;

        $db_name = "t_lo lo,t_po po,t_program p";
        $column = "lo.lo_id,lo.lo_code,lo.lo_name,po.po_id,po.po_code,po.po_name,po.program_id,p.name as program_name ";
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
                            {$data['lo_code']}
                        </td>
                        <td >
                            {$data['lo_name']}
                        </td>
                        <td >
                            {$data['po_code']}
                        </td>
                        <td >
                            {$data['po_name']}
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_lo_id','{$data['lo_id']}');setData('edit_lo_code','{$data['lo_code']}');setData('edit_lo_name','{$data['lo_name']}');setData('edit_subject_id','$subject_id');setSelectChecked('update_po','{$data['po_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('delete_lo','{$data['lo_id']}');setData('delete_lo_subject_id','$subject_id')">
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
    <a data-toggle="modal" data-target="#addModel" class="btn btn-success float-right" onclick="setData('subject_id','<?php echo $subject_id?>')">
        <i class="fas fa-plus"></i>
        Add LO
    </a>
</div>



<?php
if(isset($_POST['add_lo'])){

    $lo = new LearningOutcome();

    if(empty($_POST['lo_code'])){
        $errInfor = "lo code is empty";
    }

    if(empty($_POST['lo_name'])){
        $errInfor = "lo name is empty";
    }


    $lo->setLoId(uniqid());
    $lo->setLoCode($_POST['lo_code']);
    $lo->setLoName($_POST['lo_name']);
    $lo->setPoId($_POST['po']);
    $lo->setSubjectId($_POST['subject_id']);

    if($errInfor == ""){
        $result = $db->insert($lo::$db_name,$lo);
        if($result >= 0){
            echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$lo->getSubjectId()."');</script>");
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
                    <h5 class="modal-title" id="addModelLabel">Learning Outcome Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="subject_id" name="subject_id" class="form-control">
                    <div class="form-group">
                        <label for="inputName">LO Code</label>
                        <input type="text" id="lo_code" name="lo_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">LO Infor</label>
                        <textarea id="lo_name" name="lo_name" class="form-control" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
                        <label>PO</label>
                        <select class="form-control" id="po" name="po">
                            <?php
                            $db_name = "t_po";
                            $column = "po_id,po_code,po_name";
                            $poCondition = "program_id = '$program_id'";
                            $result = $db->select_more($db_name,$column,$poCondition);
                            foreach ($result as $data){
                                $html=<<<A
    <option value='{$data["po_id"]}' >{$data["po_code"]}({$data["po_name"]})</option>
A;
                                echo $html;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_lo" value="add_lo" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['edit_lo'])){

    $lo = new LearningOutcome();
    if (!empty($_POST['edit_lo_code'])) {
        $lo->setLoCode($_POST['edit_lo_code']);
    }
    if (!empty($_POST['edit_lo_name'])) {
        $lo->setLoName($_POST['edit_lo_name']);
    }
    if (!empty($_POST['update_po'])) {
        $lo->setPoId($_POST['update_po']);
    }
    $result = $db->update($lo::$db_name,$lo," lo_id ='".$_POST['edit_lo_id']."'");
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$_POST['edit_subject_id']."');</script>");
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
                    <h5 class="modal-title" id="editModelLabel">Learning Outcome Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body card-body">
                    <input type="hidden" id="edit_lo_id" name="edit_lo_id" class="form-control" value="">
                    <input type="hidden" id="edit_subject_id" name="edit_subject_id" class="form-control" value="">
                    <div class="form-group">
                        <label for="inputName">LO Code</label>
                        <input type="text" id="edit_lo_code" name="edit_po_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">LO Infor</label>
                        <textarea id="edit_lo_name" name="edit_lo_name" class="form-control" rows="3" ></textarea>
                    </div>
                    <div class="form-group">
                        <label>PO</label>
                        <select class="form-control" id="update_po" name="update_po">
                            <?php
                            $db_name = "t_po";
                            $column = "po_id,po_code,po_name";
                            $poCondition = "program_id = '$program_id'";
                            $result = $db->select_more($db_name,$column,$poCondition);
                            foreach ($result as $data){
                                $html=<<<A
    <option value='{$data["po_id"]}' >{$data["po_code"]}({$data["po_name"]})</option>
A;
                                echo $html;
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit_lo" value="edit_lo" class="btn btn-primary float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if(isset($_POST['lo_delete'])){
    $lo = new LearningOutcome();
    $lo->setLoId($_POST['delete_lo']);

    $result = $db->delete($lo::$db_name,$lo);
    if($result >= 0){
        echo("<script>location.replace('".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?subject_id='.$_POST['delete_lo_subject_id']."');</script>");
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
                        <h5>Are you sure you want to delete the this LO?</h5>
                        <input type="hidden" id="delete_lo" name="delete_lo" class="form-control" value="">
                        <input type="hidden" id="delete_lo_subject_id" name="delete_lo_subject_id" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer card-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="submit" name="lo_delete" value="lo_delete" class="btn btn-primary float-right">YES</button>
                </div>
            </form>
        </div>
    </div>
</div>
