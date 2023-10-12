<?php include 'teacher_inc_header.php' ?>


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Semester</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_semesterList.php">Semester List</a></li>
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
                    <h3 class="card-title">Semester</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 100%;">
                            <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Semester Information">
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
                            <th style="width: 20%">
                                Semester Infor
                            </th>
                            <th style="width: 10%">
                                Semester Date
                            </th>
                            <th style="width: 15%">
                                Total Student
                            </th>
                            <th style="width: 15%">
                                Total Subject
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
                        if(isset($_REQUEST['semester_page'])){
                            $pageNumber = $_REQUEST['semester_page'];
                            $startNo = ($pageNumber-1) * 10;
                        }
                        if(isset($_REQUEST['search'])){
                            $search = $_REQUEST['search'];
                            $condition = "s.semester_infor like '%$search%'";
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

                        $semester = new Semester();
                        $pageCount = $db->count($semester::$db_name." s",$condition);

                        $userePage = new Page($pageCount,"",true,"semester_");
                        if($condition != ""){
                            $condition="and ".$condition;
                        }
                        $tbCondition="s.program_id=p.program_id ";
                        $limit = " limit $startNo,10";
                        $condition = $tbCondition.$condition;

                        $db_name = "t_semester s,t_program p";
                        $column = "s.semester_id,s.program_id,s.semester_infor,s.semester_date,p.name as program_name ";
                        $result = $db->select_more($db_name,$column,$condition,$limit);
                        $number = $startNo;
                        foreach ($result as $data){
                            $number++;
                            $semester_studnet_number = $db->count("t_semester_student","semester_id='".$data['semester_id']."'");
                            $semester_subject_number = $db->count("t_subject","semester_id='".$data['semester_id']."'");
                            $html=<<<A
                     <tr class="text-center align-items-center justify-content-center">
                        <td>
                            {$number}
                        </td>
                        <td >
                            {$data['semester_infor']}
                        </td>
                        <td >
                            {$data['semester_date']}
                        </td>
                        <td >
                            $semester_studnet_number
                        </td>
                        <td >
                            $semester_subject_number
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="teacher_infor_semester.php?semester_id={$data['semester_id']}">
                                <i class="fas fa-folder"></i> 
                        View 
                            </a>
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_semester_id','{$data['semester_id']}');setData('edit_semester_date','{$data['semester_date']}');setData('edit_semester_infor','{$data['semester_infor']}');setSelectChecked('update_program','{$data['program_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('delete_semester','{$data['semester_id']}')">
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
                    <a data-toggle="modal" data-target="#addModel" class="btn btn-success float-right">
                        <i class="fas fa-plus"></i>
                        Add Semester
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>
<?php
if(isset($_POST['add_semester'])){

    $semester = new Semester();

    if(empty($_POST['semester_infor'])){
        $errInfor = "semester infor is empty";
    }

    if(empty($_POST['semester_date'])){
        $errInfor = "semester date is empty";
    }

    $semester->setSemesterId(uniqid());
    $semester->setProgramId($_POST['program']);
    $semester->setSemesterInfor($_POST['semester_infor']);
    $semester->setSemesterDate($_POST['semester_date']);



    if($errInfor == ""){
        $result = $db->insert($semester::$db_name,$semester);
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
                        <h5 class="modal-title" id="addModelLabel">Semester Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">Semester Infor</label>
                            <input type="text" id="semester_infor" name="semester_infor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Semester Date</label>
                            <input type="month" id="semester_date" name="semester_date" class="form-control">
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
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_semester" value="add_semester" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
if(isset($_POST['edit_semester'])){

    $semester = new Semester();

    if (!empty($_POST['edit_semester_infor'])) {
        $semester->setSemesterInfor($_POST['edit_semester_infor']);
    }
    if (!empty($_POST['edit_semester_date'])) {
        $semester->setSemesterDate($_POST['edit_semester_date']);
    }
    if (!empty($_POST['update_program'])) {
        $semester->setProgramId($_POST['update_program']);
    }
   // echo("<script>console.log('".json_encode($subject)."');</script>");
    $result = $db->update($semester::$db_name,$semester," semester_id ='".$_POST['edit_semester_id']."'");
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
                        <h5 class="modal-title" id="editModelLabel">Semester Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <input type="hidden" id="edit_semester_id" name="edit_semester_id" class="form-control" value="">
                        <div class="form-group">
                            <label for="inputName">Semester Infor</label>
                            <input type="text" id="edit_semester_infor" name="edit_semester_infor" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Semester Date</label>
                            <input type="month" id="edit_semester_date" name="edit_semester_date" class="form-control">
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
                    </div>

                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_semester" value="edit_semester" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['semester_delete'])){
    $semester = new Semester();
    $semester->setSemesterId($_POST['delete_semester']);

    $result = $db->delete($semester::$db_name,$semester);
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
                            <h5>Are you sure you want to delete the this Semester?</h5>
                            <input type="hidden" id="delete_semester" name="delete_semester" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="semester_delete" value="semester_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php include 'teacher_inc_footer.php' ?>