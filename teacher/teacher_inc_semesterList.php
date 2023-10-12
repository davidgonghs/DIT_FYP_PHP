<div class="card-header">
    <h3 class="card-title">Semester</h3>

</div>

<div class="card-body p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr class="text-center">
            <th style="width: 1%">
                #
            </th>
            <th style="width: 25%">
                Semester Infor
            </th>
            <th style="width: 25%">
                Semester Date
            </th>
            <th style="width: 25%">
                Total Subject
            </th>
            <th style="width: 24%">
                Program
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

        if(isset($_GET['student_number'])){
            $student_number = $_GET['student_number'];
            $condition = "s.semester_id = st.semester_id and st.student_number = '$student_number'";
        }

        if(isset($_COOKIE['student_number'])){
            $student_number = $_COOKIE['student_number'];
            $condition = "s.semester_id = st.semester_id and st.student_number = '$student_number'";
        }

        $semester = new Semester();
        $db_name = "t_semester s,t_semester_student st ";
        $pageCount = $db->count($db_name,$condition);

        $userePage = new Page($pageCount,"",true,"semester_");
        if($condition != ""){
            $condition="and ".$condition;
        }
        $tbCondition="s.program_id=p.program_id ";
        $limit = " limit $startNo,10";
        $condition = $tbCondition.$condition;

        $db_name = "t_semester s,t_program p,t_semester_student st ";
        $column = "s.semester_id,s.program_id,s.semester_infor,s.semester_date,p.name as program_name ";
        $result = $db->select_more($db_name,$column,$condition,$limit);
        $number = $startNo;
        foreach ($result as $data){
            $number++;
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
                            $semester_subject_number
                        </td>
                        <td >
                            {$data['program_name']}
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