<?php include 'teacher_inc_header.php' ?>


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
                            <li class="breadcrumb-item"><a href="teacher_index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="teacher_teacherUserLIst.php">Teacher User</a></li>
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
                            <th style="width: 20%">
                                Staff Number
                            </th>
                            <th style="width: 15%">
                                User Name
                            </th>
                            <th style="width: 20%">
                                Email
                            </th>
                            <th style="width: 20%">
                                Program
                            </th>
                            <th style="width: 10%">
                                Total Subject
                            </th>
                            <th style="width: 10%">
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
                            $condition = "t.user_name like '%$search%'";
                        }

                        if($teacher_program_number>0){ //如果有program 代表老师是dean
                            $result = $db->select_more($program::$db_name,"program_id",$program);
                            $in_condition = "t.program_id in (";
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

                        $teacher = new Teacher();
                        $pageCount = $db->count($teacher::$db_name." t",$condition);

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
                            $subject = new Subject();
                            $subject->setLecturer($data['staff_number']);
                            $subject_number = $db->count($subject::$db_name,$subject);
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
                        <td >
                            $subject_number
                        </td>
                        <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="teacher_infor_teacher.php?teacher_id={$data['staff_number']}">
                                <i class="fas fa-folder"></i> 
                        View 
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
                </div>
            </div>
            <!-- /.card -->

        </section>
    </div>

<?php include 'teacher_inc_footer.php' ?>