<?php include 'admin_header.inc.php' ?>


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Program</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="admin_programList.php">Program</a></li>
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
                    <h3 class="card-title">Program List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 100%;">
                            <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Program Name">
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
                                Program Name
                            </th>
                            <th style="width: 20%">
                                Program Dean
                            </th>
                            <th style="width: 20%">
                                Total Teachers
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $condition = "";
                        $startNo = 0;
                        if(isset($_REQUEST['program_page'])){
                            $pageNumber = $_REQUEST['program_page'];
                            $startNo = ($pageNumber-1) * 10;
                        }
                        if(isset($_REQUEST['search'])){
                            $search = $_REQUEST['search'];
                            $condition = "name like '%$search%'";
                        }
                        $adminUser = new Admin();
                        $pageCount = $db->count($adminUser::$db_name,$condition);
                        $userePage = new Page($pageCount,"",true,"program_");

                        $tbCondition="p.dean=tt.staff_number ";
                        $limit = " limit $startNo,10";
                        $condition = $tbCondition.$condition;
                        $db_name = "t_program p,t_teacher_user tt ";
                        $column = "p.program_id,p.name,tt.staff_number,tt.user_name,(select count(t.program_id) from t_teacher_user t where t.program_id = p.program_id) num ";
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
                            {$data['name']}
                        </td>
                        <td >
                            {$data['user_name']}
                        </td>
                               <td >
                            {$data['num']}
                        </td>
                        <td class="project-actions text-right">
                          <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_program_id','{$data['program_id']}');setData('edit_program_name','{$data['name']}');setSelectChecked('edit_program_dean','{$data['staff_number']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('program_id','{$data['program_id']}')">
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
                        Add Program
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>

<?php
if(isset($_POST['program_add'])){
    $placeName = "";
    $program = new Program();
    if(empty($_POST['program_name'])){
        $errInfor = "Name is empty";
    }

    if(!empty($_POST['program_dean'])){
        $program->setDean($_POST['program_dean']);
    }

    $program->setProgramId(uniqid());
    $program->setName($_POST['program_name']);
    if($errInfor == ""){
        $result = $db->insert($program::$db_name,$program);
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
                        <h5 class="modal-title" id="addModelLabel">Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">Program Name</label>
                            <input type="text" id="program_name" name="program_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Program Dean</label>
                            <select class="form-control" id="program_dean" name="program_dean" >
                                <?php
                                $db_name = "t_teacher_user";
                                $column = "staff_number,user_name";
                                $result = $db->select_more($db_name,$column);
                                foreach ($result as $data){
                                    $html=<<<A
    <option value='{$data["staff_number"]}'>{$data["user_name"]}</option>
A;
                                    echo $html;
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="program_add" value="program_add" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
if(isset($_POST['program_edit'])){

    $program = new Program();
    if (!empty($_POST['edit_program_name'])) {
        $program->setName($_POST['edit_program_name']);
    }
    if (!empty($_POST['edit_program_dean'])) {
        $program->setDean($_POST['edit_program_dean']);
    }

    $result = $db->update($program::$db_name,$program," program_id ='".$_POST['edit_program_id']."'");
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
                        <h5 class="modal-title" id="editModelLabel">Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <input type="hidden" id="edit_program_id" name="edit_program_id" class="form-control" value="">
                            <label for="inputName">Program Name</label>
                            <input type="text" id="edit_program_name" name="edit_program_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Program Dean</label>
                            <select class="form-control" id="edit_program_dean" name="edit_program_dean" >
                                <?php
                                $db_name = "t_teacher_user";
                                $column = "staff_number,user_name";
                                $result = $db->select_more($db_name,$column);
                                foreach ($result as $data){
$html=<<<A
    <option value='{$data["staff_number"]}'>{$data["user_name"]}</option>
A;
                                    echo $html;
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="program_edit" value="program_edit" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




<?php
if(isset($_POST['program_delete'])){
    $program = new Program();
    $program->setProgramId($_POST['program_id']);

    $result = $db->delete($program::$db_name,$program);
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
                            <h5>Are you sure you want to delete the this Program?</h5>
                            <input type="hidden" id="program_id" name="program_id" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="program_delete" value="program_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include 'admin_footer.inc.php' ?>