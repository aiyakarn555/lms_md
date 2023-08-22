    <form action='LearnReset/ResetLearnLesson' method='post'>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="15%"><center>เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /></center> </th>
                        <th><center>ชื่อหลักสูตร</center></th>
                    </tr>
                </thead>
                <tbody>

                    <input type='hidden' name='reset_type' value="<?= $type; ?>">
                    <input type='hidden' name='type_test' value="<?= $type_test; ?>">
                    <input type='hidden' name='user_id' value="<?= $user_id ?>">                    
                    <!-- <input type='checkbox' id='checkAll' /> เลือกทั้งหมด -->
                    <?php
                    foreach ($course as $key => $value) {
                        $courseScore = Coursescore::model()->find(array(
                            'condition' => 'course_id=:course_id AND user_id=:user_id AND active="y" AND gen_id=:gen_id AND type=:type_test',
                            'params' => array(':course_id' => $value->course_id, ':user_id' => $user_id, ':gen_id'=>$value->gen_id, ':type_test' => $type_test)
                        ));
                        ?>
                        <?php
                        if($courseScore){
                         ?>
                         <tr>
                            <td width="10%" class="text-center" style="vertical-align: middle;"><center>
                                <input class="checkCourse" type='checkbox' name=course_id[<?= $value->course_id; ?>_<?= $value->gen_id; ?>]  value="<?= $value->course_id; ?>_<?= $value->gen_id; ?>" />
                            </center></td>
                            <td></center><?= $value->course->course_title; ?> <?php if($value->gen_id != 0){ echo "รุ่น ".$value->gen->gen_title; } ?></center></td>
                        </tr>
                        <?php
                    }
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
