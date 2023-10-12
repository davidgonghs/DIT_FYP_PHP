<?php include 'teacher_inc_header.php' ?>


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Program Outcome</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_programOutcomeLIst.php">Program Outcome</a></li>
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
                    <h3 class="card-title">Program Outcome</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 100%;">
                            <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search Program Outcome Name">
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
                                PO Code
                            </th>
                            <th style="width: 30%">
                                PO Name
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
                        if(isset($_REQUEST['po_page'])){
                            $pageNumber = $_REQUEST['po_page'];
                            $startNo = ($pageNumber-1) * 10;
                        }
                        if(isset($_REQUEST['search'])){
                            $search = $_REQUEST['search'];
                            $condition = "po.po_name like '%$search%'";
                        }

                        if($teacher_program_number>0){ //如果有program 代表老师是dean
                            $result = $db->select_more($program::$db_name,"program_id",$program);
                            $in_condition = "po.program_id in (";
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

                        $po = new ProgrammeOutcome();
                        $pageCount = $db->count($po::$db_name." po",$condition);

                        $userePage = new Page($pageCount,"",true,"po_");
                        if($condition != ""){
                            $condition="and ".$condition;
                        }


                        $tbCondition="po.program_id=p.program_id ";
                        $limit = " limit $startNo,10";
                        $condition = $tbCondition.$condition;



                        $db_name = "t_po po,t_program p";
                        $column = "po.po_id,po.po_code,po.po_name,po.program_id,p.name as program_name ";
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
                            {$data['po_code']}
                        </td>
                        <td >
                            {$data['po_name']}
                        </td>
                        <td >
                            {$data['program_name']}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editModel" onclick="setData('edit_po_id','{$data['po_id']}');setData('edit_po_code','{$data['po_code']}');setData('edit_po_name','{$data['po_name']}');setSelectChecked('update_program','{$data['program_id']}');">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#deleteModal" onclick="setData('delete_po','{$data['po_id']}')">
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
                        Add PO
                    </a>
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>
<?php
if(isset($_POST['add_po'])){

    $po = new ProgrammeOutcome();

    if(empty($_POST['po_code'])){
        $errInfor = "po code is empty";
    }

    if(empty($_POST['po_name'])){
        $errInfor = "po name is empty";
    }

    $po->setPoId(uniqid());
    $po->setProgramId($_POST['program']);
    $po->setPoCode($_POST['po_code']);
    $po->setPoName($_POST['po_name']);


    if($errInfor == ""){
        $result = $db->insert($po::$db_name,$po);
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
                        <h5 class="modal-title" id="addModelLabel">PO Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="form-group">
                            <label for="inputName">PO Code</label>
                            <input type="text" id="po_code" name="po_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">PO Name</label>
                            <input type="text" id="po_name" name="po_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="program" name="program" >
                                <?php
                                $db_name = "t_program";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column,$program);
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
                        <button type="submit" name="add_po" value="add_po" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
if(isset($_POST['edit_po'])){

    $po = new ProgrammeOutcome();
    if (!empty($_POST['edit_po_id'])) {
        $po->setPoId($_POST['edit_po_id']);
    }
    if (!empty($_POST['edit_po_code'])) {
        $po->setPoCode($_POST['edit_po_code']);
    }
    if (!empty($_POST['edit_po_name'])) {
        $po->setPoName($_POST['edit_po_name']);
    }
    if (!empty($_POST['update_program'])) {
        $po->setProgramId($_POST['update_program']);
    }
    $result = $db->update($po::$db_name,$po," po_id ='".$_POST['edit_po_id']."'");
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
                        <input type="hidden" id="edit_po_id" name="edit_po_id" class="form-control" value="">
                        <div class="form-group">
                            <label for="inputName">PO Code</label>
                            <input type="text" id="edit_po_code" name="edit_po_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">PO Name</label>
                            <input type="text" id="edit_po_name" name="edit_po_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control" id="update_program" name="update_program">
                                <?php
                                $db_name = "t_program";
                                $column = "program_id,name";
                                $result = $db->select_more($db_name,$column,$program);
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
                        <button type="submit" name="edit_po" value="edit_po" class="btn btn-primary float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php
if(isset($_POST['po_delete'])){
    $po = new ProgrammeOutcome();
    $po->setPoId($_POST['delete_po']);

    $result = $db->delete($po::$db_name,$po);
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
                            <h5>Are you sure you want to delete the this PO?</h5>
                            <input type="hidden" id="delete_po" name="delete_po" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="po_delete" value="po_delete" class="btn btn-primary float-right">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php include 'teacher_inc_footer.php' ?>