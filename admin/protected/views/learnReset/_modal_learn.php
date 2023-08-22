    <h4 style="color: red;">
        ***เมื่อ Reset การเรียน การสอบหลังเรียนและการสอบวัดผลจะถูก Reset ไปด้วย***
    </h4>
    <form  method='post'>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th  width="10%"><center>เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /></center></th>
                        <th  width="40%"><center>ชื่อหลักสูตร</center></th>
                        <th  width="40%"><center>ชื่อบทเรียน</center></th>
                    </tr>
                </thead>

                <input type='hidden' name='reset_type' value="<?= $type; ?>">
                <input type='hidden' name='user_id' value="<?= $user_id ?>">
                <tbody>
                    <?php 

                    foreach ($course as $key => $value) { // learn model
                        // $modelData = Learn::model()->find(array(
                        //     'condition' => 'user_id=:user_id AND course_id=:course_id AND lesson_id=:lesson_id AND active="y"',
                        //     'params' => array(':user_id'=>$user_id,':course_id'=>$value->course_id,'lesson_id' => $value->lesson_id)));                         
                        ?>
                        <tr>
                            <td width="10%" class="text-center"><center><input class="checkCourse" type='checkbox' name=course_id[<?= $value->course_id; ?>_<?= $value->gen_id; ?>]  value="<?= $value->course_id; ?>_<?= $value->gen_id; ?>" /></center></td>
                            <td><center>    
                                <?= $value->course->course_title; ?> <?php if($value->gen_id != 0){ echo "รุ่น ".$value->gen->gen_title; } ?></center></td>

                                <td>
                                    <ul style='list-style-type: none;'>
                                     <?php

                                     $modelData = null;
                                     $modelData = learn::model()->with('les')->findAll(array(
                                         'condition'=>'t.user_id=:user_id AND t.course_id=:course_id AND lesson_active="y" AND lesson.active="y" AND gen_id=:gen_id',
                                         'params' => array('user_id' => $user_id,':course_id'=>$value->course_id, ':gen_id'=>$value->gen_id)
                                     ));
                                     if($modelData){
                                        foreach ($modelData as $keylearn => $valuelearn) {
                                            ?>
                                            <li>
                                                <input class="checkLesson<?= $value->course_id; ?>_<?= $value->gen_id; ?> checkedLesson" type='checkbox' name=lesson_id[]  value="<?=$valuelearn->course_id; ?>,<?= $valuelearn->lesson_id; ?>,<?= $valuelearn->learn_id; ?>,<?= $valuelearn->gen_id ?>" />
                                                <?= $valuelearn->les->title; ?>
                                            </li>
                                            <?php
                                        }
                                    }else{
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
