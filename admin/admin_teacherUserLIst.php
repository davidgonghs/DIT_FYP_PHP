<?php include 'admin_header.inc.php' ?>


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Teacher</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="admin_teacherUserLIst.php">Teacher User</a></li>
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
                    <h3 class="card-title">Teacher List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 100%;">
                            <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Teacher Name">
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
                            <th style="width: 30%">
                                Staff Number
                            </th>
                            <th style="width: 20%">
                                User Name
                            </th>
                            <th style="width: 20%">
                                Email
                            </th>
                            <th style="width: 20%">
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
                        if(isset($_REQUEST['teacherUser_page'])){
                            $pageNumber = $_REQUEST['teacherUser_page'];
                            $startNo = ($pageNumber-1) * 10;
                        }
                        if(isset($_REQUEST['search'])){
                            $search = $_REQUEST['search'];
                            $condition = "user_name like '%$search%'";
                        }
                        $teacher = new Teacher();
                        $pageCount = $db->count($teacher::$db_name,$condition);

                        $userePage = new Page($pageCount,"",true,"teacherUser_");
                        if($condition != ""){
                            $condition="and ".$condition;
                        }
                        $tbCondition="t.program_id=p.program_id ";
                        $limit = " limit $startNo,10";
                        $condition = $tbCondition.$condition;
                        $db_name = "t_teacher_user t,t_program p";
                        $column = "t.staff_number,t.user_name,t.email,t.program_id,p.name as program_name ";
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
                            {$data['staff_number']}
                        </td>
                        <td >
                            {$data['user_name']}
                        </td>
                        <td >
                            {$data['email']}
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_staff_number','{$data['staff_number']}');setData('update_teacher_name','{$data['user_name']}');setData('update_teacher_email','{$data['email']}');setData('update_select_content','{$data['program_id']}');setSelectChecked('update_program','{$data['program_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('staff_number','{$data['staff_number']}')">
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
                        Add Teacher
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>

<?php
if(isset($_POST['teacher_submit'])){


    $teacher = new Teacher();
    if(empty($_POST['staffNumber'])){
        $errInfor = "Staff Number is empty";
    }

    if(empty($_POST['name'])){
        $errInfor = "Name is empty";
    }

    if(empty($_POST['email'])){
        $errInfor = "Email is empty";
    }

    if(empty($_POST['password'])){
        $errInfor = "password is empty";
    }

    if(!empty($_POST['program'])){
        $teacher->setProgramId($_POST['program']);
    }

    $teacher->setStaffNumber($_POST['staffNumber']);
    $teacher->setUserName($_POST['name']);
    $teacher->setEmail($_POST['email']);
    $teacher->setPassword(sha1($_POST['password']));

    if($errInfor == ""){
        $result = $db->insert($teacher::$db_name,$teacher);
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
                        <h5 class="modal-title" id="addModelLabel">Teacher Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">Staff Number</label>
                            <input type="text" id="staffNumber" name="staffNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Password</label>
                            <input type="text" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="program" name="program" >
                                <?php
                                $db_name = "t_program";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column);
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
                        <button type="submit" name="teacher_submit" value="teacher_submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['teacher_edit'])){


    $teacher = new Teacher();
    if (!empty($_POST['update_teacher_name'])) {
        $teacher->setUserName($_POST['update_teacher_name']);
    }
    if (!empty($_POST['update_teacher_email'])) {
        $teacher->setEmail($_POST['update_teacher_email']);
    }
    if (!empty($_POST['update_teacher_password'])) {
        $teacher->setPassword(sha1($_POST['update_teacher_password']));
    }
    if (!empty($_POST['update_program'])) {
        $teacher->setProgramId($_POST['update_program']);
    }

    $result = $db->update($teacher::$db_name,$teacher," staff_number='".$_POST['edit_staff_number']."'");
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
                        <h5 class="modal-title" id="editModelLabel">Teacher Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <input type="hidden" id="edit_staff_number" name="edit_staff_number" class="form-control" value="">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="update_teacher_name" name="update_teacher_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Email</label>
                            <input type="email" id="update_teacher_email" name="update_teacher_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Password</label>
                            <input type="text" id="update_teacher_password" name="update_teacher_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="update_program" name="update_program" onchange="setData('update_select_content',this.options[this.selectedIndex].id)">
                                <?php
                                $db_name = "t_program";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column);
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
                        <button type="submit" name="teacher_edit" value="teacher_edit" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['teacher_delete'])){
    $teacher = new Teacher();
    $teacher->setStaffNumber($_POST['staff_number']);

    $result = $db->delete($teacher::$db_name,$teacher);
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
                            <h5>Are you sure you want to delete the this Teacher?</h5>
                            <input type="hidden" id="staff_number" name="staff_number" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="teacher_delete" value="teacher_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include 'admin_footer.inc.php' ?>