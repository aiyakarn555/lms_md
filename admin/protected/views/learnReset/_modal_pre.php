    <h4 style="color: red;">
        ***เมื่อ Reset สอบก่อนเรียน การเรียน การสอบหลังเรียนและการสอบวัดผลจะถูก Reset ไปด้วย***
    </h4>
    <form method='post'>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="15%"><center>เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /></center></th>
                        <th width="40%"><center>ชื่อหลักสูตร</center></th>
                        <th><center>ชื่อบทเรียน</center></th>
                    </tr>
                </thead>
                <tbody>

                    <input type='hidden' name='reset_type' value="<?= $type; ?>">
                    <input type='hidden' name='user_id' value="<?= $user_id ?>">
                    <!-- <input type='checkbox' id='checkAll' /> เลือกทั้งหมด -->
                    <?php
                    foreach ($course as $key => $value) { ?>

                    <tr>
                        <td width="10%" class="text-center" style="vertical-align: middle;"><center><input class="checkCourse" type='checkbox' name=course_id[<?= $value->course_id; ?>_<?= $value->gen_id; ?>]  value="<?= $value->course_id; ?>_<?= $value->gen_id; ?>" /></center></td>
                        <td><center><?= $value->course->course_title; ?> <?php if($value->gen_id != 0){ echo "รุ่น ".$value->gen->gen_title; } ?></center></td>
                        <td>
                            <ul style='list-style-type: none;'>
                             <?php
                             $modelcourse = Score::model()->findAll(array(
                                'condition'=>'course_id=:course_id AND type="pre" AND active="y" AND gen_id=:gen_id AND user_id=:user_id GROUP BY lesson_id ,gen_id',
                                'params' => array(':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id, ':user_id'=>$user_id)
                            ));

                             foreach ($modelcourse as $keycourse=> $valuecourse) {
                                 $modelData = null;
                                 $modelData = Lesson::model()->findAll(array(
                                    'condition'=>'course_id=:course_id AND id=:lesson_id AND active="y"',
                                    'params' => array('lesson_id' => $valuecourse->lesson_id,':course_id'=>$valuecourse->course_id)
                                ));

          
                                 if($modelData){
                                    foreach ($modelData as $keylearn => $valuelearn) {
                                        ?>
                                        <li>
                                            <input class="checkLesson<?= $value->course_id; ?>_<?= $value->gen_id; ?> checkedLesson" type='checkbox' name=lesson_id[]  value="<?=$valuelearn->course_id; ?>,<?= $valuelearn->id; ?>,0,<?= $value->gen_id; ?>" />
                                            <?= $valuelearn->title; ?>
                                        </li>
                                        <?php
                                    }
                                }
                            }

                            ?>
                        </ul>
                    </td>

                </tr>
                <?php
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
