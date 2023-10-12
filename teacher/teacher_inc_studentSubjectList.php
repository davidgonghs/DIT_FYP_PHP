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
                Model Code
            </th>
            <th style="width: 10%">
                Model Name
            </th>
            <th style="width: 10%">
                Model Sname
            </th>
            <th style="width: 20%">
                Lecturer
            </th>
            <th style="width: 10%">
                Program
            </th>
            <th style="width: 25%">
                Semester
            </th>
            <th style="width: 10%">
                Mark
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

        if(isset($_GET['student_number'])){
            $student_number = $_GET['student_number'];
            $condition = "tss.student_number = '".$student_number."' ";
        }

        if(isset($_COOKIE['student_number'])){
            $student_number = $_COOKIE['student_number'];
            $condition = "tss.student_number = '".$student_number."' ";
        }


        $subject = new Subject();
        $db_name = "t_subject s,t_program p,t_teacher_user t,t_semester sm,t_semester_student tss ";
        if($condition != ""){
            $condition="and ".$condition;
        }
        $tbCondition="s.program_id=p.program_id and s.lecturer = t.staff_number and s.semester_id = sm.semester_id and s.semester_id = tss.semester_id ";
        $condition = $tbCondition.$condition;
        $pageCount = $db->count($db_name,$condition);

        $page = new Page($pageCount,"",true,"subject_");


        $limit = " limit $startNo,10";

        $column = "s.subject_id,s.model_code,s.model_name,s.model_sname,s.lecturer,s.program_id,p.name as program_name,t.user_name as teacher_name,sm.semester_date,sm.semester_infor,s.semester_id ";
        $result = $db->select_more($db_name,$column,$condition,$limit);
        $number = $startNo;

        foreach ($result as $data){
            $student_mark = 0;
            $grade = "";
            $definition = "";
            $sql = "select FORMAT(SUM(tm.tmark),2) as tmar from t_subject ts LEFT JOIN (
Select a.subject_id,a.weight *  sum(qm.mark)/100 as tmark from t_assessment a,t_question q, t_question_marks qm 
where a.subject_id='".$data['subject_id']."' and a.assessment_id = q.assessment_id and q.question_id = qm.question_id and qm.student_number = '".$student_number."' group BY a.assessment_id) tm ON tm.subject_id = ts.subject_id";
            $mark = $db->query($sql);
            if(!empty($mark)){
                if ($mark->num_rows > 0) {
                    // output data of each row
                    while($row = $mark->fetch_object()) {
                        if(empty($row->tmar)){
                            $student_mark = 0;
                        }else{
                            $student_mark = $row->tmar;
                        }

                    }
                }
                echo("<script>console.log('".$student_mark."');</script>");


                if($student_mark>89){
                    $grade = "A+";
                    $definition="High Distinction";
                }else if ($student_mark >79){
                    $grade = "A";
                    $definition="Distinction";
                }else if ($student_mark >74){
                    $grade = "A-";
                    $definition="Distinction";
                }else if ($student_mark >69){
                    $grade = "B+";
                    $definition="Merit";
                }else if ($student_mark >64){
                    $grade = "B";
                    $definition="Merit";
                }else if ($student_mark >59){
                    $grade = "B-";
                    $definition="Merit";
                }else if ($student_mark >54){
                    $grade = "C+";
                    $definition="Pass";
                }else if ($student_mark >49){
                    $grade = "C";
                    $definition="Pass";
                }else if ($student_mark >44){
                    $grade = "C-";
                    $definition="Fail";
                }else if ($student_mark >39){
                    $grade = "D+";
                    $definition="Fail";
                }else if ($student_mark >34){
                    $grade = "D";
                    $definition="Fail";
                }else if ($student_mark >29){
                    $grade = "D-";
                    $definition="Fail";

                }else{
                    $grade = "F";
                    $definition="Fail";
                }
            }
            $mark_sen="";
            if($student_mark!=0){
                $mark_sen =  $student_mark."(".$grade.",".$definition.")";
            }else{
                $mark_sen = "N/A (Not Applicable)";
            }
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
                        <td >
                           $mark_sen
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