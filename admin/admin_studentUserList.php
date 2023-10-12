<?php include 'admin_header.inc.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="admin_studentUserList.php">Student User</a></li>
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
                    <h3 class="card-title">Student List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 100%;">
                            <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Student Number">
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
                                Student Number
                            </th>
                            <th style="width: 10%">
                                User Name
                            </th>
                            <th style="width: 20%">
                                Email
                            </th>
                            <th style="width: 20%">
                                IC/Passport
                            </th>
                            <th style="width: 10%">
                                Program
                            </th>
                            <th style="width: 10%">
                                Status
                            </th>
                            <th style="width: 20%">
                            </th>
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
                        if(isset($_REQUEST['search'])){
                            $search = $_REQUEST['search'];
                            $condition = "student_number like '%$search%'";
                        }
                        $student = new Student();
                        $pageCount = $db->count($student::$db_name,$condition);

                        $userePage = new Page($pageCount,"",true,"studentUser_");

                        if($condition != ""){
                            $condition="and ".$condition;
                        }

                        $tbCondition="s.program_id=p.program_id ";
                        $limit = " limit $startNo,10";
                        $condition = $tbCondition.$condition;
                        $db_name = "t_student_user s,t_program p";
                        $column = "s.student_number,s.user_name,s.email,s.ic_passport,s.program_id,p.name as program_name,s.status ";
                        $result = $db->select_more($db_name,$column,$condition,$limit);
                        $number = $startNo;
                        foreach ($result as $data){
                            $status = "graduation";
                            if($data['status'] == 1){
                                $status = "studying";
                            }
                            $number++;
                            $html=<<<A
                     <tr class="text-center align-items-center justify-content-center">
                        <td>
                            {$number}
                        </td>
                        <td >
                            {$data['student_number']}
                        </td>
                        <td >
                            {$data['user_name']}
                        </td>
                        <td >
                            {$data['email']}
                        </td>
                        <td >
                            {$data['ic_passport']}
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td >
                            {$status}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_student_number','{$data['student_number']}');setData('edit_student_name','{$data['user_name']}');setData('edit_student_email','{$data['email']}');setData('edit_student_ic_p','{$data['ic_passport']}');setSelectChecked('update_program','{$data['program_id']}');setSelectChecked('update_status','{$data['status']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('student_number','{$data['student_number']}')">
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
                        Add Student
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>

<?php
if(isset($_POST['student_submit'])){

    $student = new Student();

    if(empty($_POST['studentNumber'])){
        $errInfor = "Student Number is empty";
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


    $student->setProgramId($_POST['program']);
    $student->setStudentNumber($_POST['studentNumber']);
    $student->setUserName($_POST['name']);
    $student->setEmail($_POST['email']);
    $student->setPassword(sha1($_POST['password']));
    $student->setStatus(1);
    if(!empty($_POST['ic_p'])){
        $student->setIcPassport($_POST['ic_p']);
    }

    if($errInfor == ""){
        $result = $db->insert($student::$db_name,$student);
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
                        <h5 class="modal-title" id="addModelLabel">Student Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">Student Number</label>
                            <input type="text" id="studentNumber" name="studentNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Email</label>
                            <input type="text" id="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">IC/PASSPORT</label>
                            <input type="text" id="ic_p" name="ic_p" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Password</label>
                            <input type="text" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="program" name="program">
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
                        <button type="submit" name="student_submit" value="student_submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['edit_student'])){

    $student = new Student();
    if (!empty($_POST['edit_student_name'])) {
        $student->setUserName($_POST['edit_student_name']);
    }
    if (!empty($_POST['edit_student_email'])) {
        $student->setEmail($_POST['edit_student_email']);
    }
    if (!empty($_POST['edit_student_ic_p'])) {
        $student->setIcPassport($_POST['edit_student_ic_p']);
    }
    if (!empty($_POST['edit_student_password'])) {
        $student->setPassword(sha1($_POST['edit_student_password']));
    }
    if (!empty($_POST['update_program'])) {
        $student->setProgramId($_POST['update_program']);
    }

    $student->setStatus($_POST['update_status']);
    $result = $db->update($student::$db_name,$student," student_number ='".$_POST['edit_student_number']."'");
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
                        <input type="hidden" id="edit_student_number" name="edit_student_number" class="form-control">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="edit_student_name" name="edit_student_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Email</label>
                            <input type="text" id="edit_student_email" name="edit_student_email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">IC/PASSPORT</label>
                            <input type="text" id="edit_student_ic_p" name="edit_student_ic_p" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Password</label>
                            <input type="text" id="edit_student_password" name="edit_student_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="update_program" name="update_program" >
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
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="update_status" name="update_status" >
                                <option value='1'>studying</option>
                                <option value='2'>graduation</option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit_student" value="edit_student" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['student_delete'])){
    $student = new Student();
    $student->setStudentNumber($_POST['student_number']);

    $result = $db->delete($student::$db_name,$student);
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
                            <h5>Are you sure you want to delete the this Student?</h5>
                            <input type="hidden" id="student_number" name="student_number" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="student_delete" value="student_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include 'admin_footer.inc.php' ?>