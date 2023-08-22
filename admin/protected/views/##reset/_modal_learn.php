    <form  method='post'>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>เลือกทั้งหมด <br><input type='checkbox' id='checkAll' /></th>
                        <th>ชื่อหลักสูตร</th>
                        <th>ชื่อบทเรียน</th>
                    </tr>
                </thead>

                <input type='hidden' name='reset_type' value="<?= $type; ?>">
                <input type='hidden' name='user_id' value="<?= $user_id ?>">

                <tbody>
                    <?php foreach ($course as $key => $value) {
                        if($value){
                            ?>
                            <tr>
                                <td width="10%" class="text-center"><input class="checkCourse" type='checkbox' name=course_id[<?= $value->course_id; ?>]  value="<?= $value->course_id; ?>" /></td>
                                <td><?= $value->course_title; ?></td>

                                <td>
                                    <ul style='list-style-type: none;'>
                                     <?php 
                                     /*$modelControlLesson = ControlLesson::model()->findAll(array('condition' => 'course_id='.$value->course_id));*/
                                     foreach ($lesson[$value->course_id] as $key => $lessons) {
                                        ?>
                                        <li><input class="checkLesson<?= $value->course_id; ?> checkedLesson" type='checkbox' name=lesson_id[]  value="<?=$lessons->course_id; ?>,<?= $lessons->id; ?>,<?= $lessons->type; ?>" /> 
                                            <?= $lessons->title; ?>
                                        </li>
                                        <?php 
                                    }
                                    ?>
                                </ul>
                            </td>
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
