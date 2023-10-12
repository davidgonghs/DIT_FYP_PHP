<div class="card-header">
    <h3 class="card-title">Subject</h3>

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
            <th style="width: 20%">
                Lecturer
            </th>
            <th style="width: 15%">
                Program
            </th>
            <th style="width: 25%">
                Semester
            </th>
            <th style="width: 5%">
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

        if(isset($_GET['semester_id'])){
            $semester_id = $_GET['semester_id'];
            $condition = "s.semester_id ='$semester_id'";
        }

        if(isset($_GET['teacher_id'])){
            $teacher_id = $_GET['teacher_id'];
            $condition = "s.lecturer ='$teacher_id'";
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
                        </td>
                    </tr>
A;

            echo $html;
        }

        ?>

        </tbody>
    </table>
</div>
<div class="card-footer clearfix">
    <?php
    echo $page->fpage();
    ?>
</div>