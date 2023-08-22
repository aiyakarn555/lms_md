    <form action='LearnReset/ResetLearnLesson' method='post'>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="20%">เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /> </th>
                        <th>ชื่อหลักสูตร</th>
                    </tr>
                </thead>
                <tbody>

                    <input type='hidden' name='reset_type' value="<?= $type; ?>">
                    <input type='hidden' name='user_id' value="<?= $user_id ?>">
                    <!-- <input type='checkbox' id='checkAll' /> เลือกทั้งหมด -->
                    <?php foreach ($score as $key => $value) {
                        /*$courseManage = Coursemanage::model()->findAll(array('condition' => 'id='.$value->course_id));
                        $chkCourseQuiz = false;
                        foreach ($courseManage as $key => $courseManage) {
                            if(!$chkCourseQuiz){
                                $courseScore = Coursescore::model()->find(array(
                                    'condition' => 'manage_id=:courseManage AND course_id=:course_id AND user_id=:user_id AND active="y"',
                                    'params' => array(':course_id' => $value->course_id,':courseManage' => $courseManage->manage_id,':user_id' => $user_id)));
                            }
                            if($courseScore && !$chkCourseQuiz)$chkCourseQuiz = true;
                        }*/
                        //if($chkCourseQuiz){
                           ?>



                           <tr>
                            <td width="10%" class="text-center" style="vertical-align: middle;"><input class="checkCourse" type='checkbox' name=course_id[<?= $value->course_id; ?>]  value="<?= $value->course_id; ?>" /></td>
                            <td><?= $value->course->course_title; ?></td>
                        </tr>


                        <?php
                    //}
                }
                ?>
            </tbody>
        </table>
    </div>
</form>
<script>

    $('#checkAll').change(function () {
        $('input:checkbox').prop('checked', $(this).prop('checked'));
    });
    $('.checkCourse').change(function () {
        var checked = $('.checkLesson'+$(this).val());
        checked.prop('checked', $(this).prop('checked'));
    });   
</script>
