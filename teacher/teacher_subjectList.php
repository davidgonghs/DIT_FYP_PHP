<?php include 'teacher_inc_header.php' ?>


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Subject</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_programOutcomeLIst.php">Subject List</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <?php include '../promptBar.inc.php' ?>

            <!-- Default box -->
            <div class="card">
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
                                Module Code
                            </th>
                            <th style="width: 20%">
                                Module Name
                            </th>
                            <th style="width: 10%">
                                Module Sname
                            </th>
                            <th style="width: 10%">
                                Lecturer
                            </th>
                            <th style="width: 10%">
                                Program
                            </th>
                            <th style="width: 15%">
                                Semester
                            </th>
                            <th style="width: 20%">
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
                            <a class="btn btn-primary btn-sm" href="teacher_infor_subject.php?subject_id={$data['subject_id']}">
                                <i class="fas fa-folder"></i> 
                        View 
                            </a>
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_subject_id','{$data['subject_id']}');setData('edit_model_code','{$data['model_code']}');setData('edit_model_name','{$data['model_name']}');setData('edit_model_sname','{$data['model_sname']}');setSelectChecked('update_lecture','{$data['lecturer']}');setSelectChecked('update_program','{$data['program_id']}');setSelectChecked('update_semester','{$data['semester_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('delete_subject','{$data['subject_id']}')">
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
                    echo $page->fpage();

                    ?>
                    <a data-toggle="modal" data-target="#addModel" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i>
                        Add Subject
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>

<?php
if(isset($_POST['add_subject'])){

    $subject = new Subject();

    if(empty($_POST['model_code'])){
        $errInfor = "model code is empty";
    }

    if(empty($_POST['model_name'])){
        $errInfor = "model name is empty";
    }
    if(empty($_POST['model_sname'])){
        $errInfor = "model sname is empty";
    }

    $subject->setSubjectId(uniqid());
    $subject->setModelCode($_POST['model_code']);
    $subject->setModelName($_POST['model_name']);
    $subject->setModelSname($_POST['model_sname']);
    $subject->setLecturer($_POST['lecture']);
    $subject->setProgramId($_POST['program']);
    $subject->setSemesterId($_POST['semester']);
    if($errInfor == ""){
        $result = $db->insert($subject::$db_name,$subject);
        if($result >= 0){
            $common->refreshPage();
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
                        <h5 class="modal-title" id="addModelLabel">Subject Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">Module Code</label>
                            <input type="text" id="model_code" name="model_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Module Name</label>
                            <input type="text" id="model_name" name="model_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Module Sname</label>
                            <input type="text" id="model_sname" name="model_sname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Lecture</label>
                            <select class="form-control" id="lecture" name="lecture">
                                <?php
                                $db_name = "t_teacher_user s";
                                $column = "staff_number,user_name";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
$html=<<<A
    <option value='{$data["staff_number"]}' >{$data["user_name"]}</option>
A;
                                    echo $html;
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="program" name="program" >
                                <?php
                                $db_name = "t_program s";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["program_id"]}' >{$data["name"]}</option>
A;
                                    echo $html;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select class="form-control" id="semester" name="semester" >
                                <?php
                                $db_name = "t_semester s";
                                $column = "semester_id,semester_infor,semester_date";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["semester_id"]}' >{$data["semester_date"]}({$data["semester_infor"]})</option>
A;
                                    echo $html;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_subject" value="add_subject" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
if(isset($_POST['edit_subject'])){

    $subject = new Subject();

    if (!empty($_POST['edit_model_code'])) {
        $subject->setModelCode($_POST['edit_model_code']);
    }
    if (!empty($_POST['edit_model_name'])) {
        $subject->setModelName($_POST['edit_model_name']);
    }
    if (!empty($_POST['edit_model_sname'])) {
        $subject->setModelSname($_POST['edit_model_sname']);
    }
    if (!empty($_POST['update_lecture'])) {
        $subject->setLecturer($_POST['update_lecture']);
    }
    if (!empty($_POST['update_program'])) {
        $subject->setProgramId($_POST['update_program']);
    }
    if (!empty($_POST['update_semester'])) {
        $subject->setSemesterId($_POST['update_semester']);
    }
    echo("<script>console.log('".json_encode($subject)."');</script>");
    $result = $db->update($subject::$db_name,$subject," subject_id ='".$_POST['edit_subject_id']."'");
    if($result >= 0){
        $common->refreshPage();
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
                        <h5 class="modal-title" id="editModelLabel">Student Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <input type="hidden" id="edit_subject_id" name="edit_subject_id" class="form-control" value="">
                        <div class="form-group">
                            <label for="inputName">Module Code</label>
                            <input type="text" id="edit_model_code" name="edit_model_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Module Name</label>
                            <input type="text" id="edit_model_name" name="edit_model_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Module Sname</label>
                            <input type="text" id="edit_model_sname" name="edit_model_sname" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Lecture</label>
                            <select class="form-control" id="update_lecture" name="update_lecture">
                                <?php
                                $db_name = "t_teacher_user s";
                                $column = "staff_number,user_name";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["staff_number"]}' >{$data["user_name"]}</option>
A;
                                    echo $html;
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="update_program" name="update_program">
                                <?php
                                $db_name = "t_program s";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["program_id"]}'>{$data["name"]}</option>
A;
                                    echo $html;
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select class="form-control" id="update_semester" name="update_semester" >
                                <?php
                                $db_name = "t_semester s";
                                $column = "semester_id,semester_infor,semester_date";
                                $result = $db->select_more($db_name,$column,$in_condition);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["semester_id"]}' >{$data["semester_date"]}({$data["semester_infor"]})</option>
A;
                                    echo $html;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_subject" value="edit_subject" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['subject_delete'])){
    $subject = new Subject();
    $subject->setSubjectId($_POST['delete_subject']);

    $result = $db->delete($subject::$db_name,$subject);
    if($result >= 0){
        $common->refreshPage();
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
                            <h5>Are you sure you want to delete the this subject?</h5>
                            <input type="hidden" id="delete_subject" name="delete_subject" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="subject_delete" value="subject_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php include 'teacher_inc_footer.php' ?>