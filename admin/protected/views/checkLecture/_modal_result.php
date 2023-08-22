    <form id='form-lesson' action='CheckLecture/SaveExam' method='post'>
     <!-- <form action="<?php echo Yii::app()->createUrl("CheckLecture/saveExam"); ?>" method='post'> -->
        <?php if(count($model) > 0){ 
           
            ?>
        <div class="table-responsive">
            <table class="table table-bordered" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="center">คำถาม</th>
                        <th class="center">คำตอบ</th>
                        <th class="center">คะแนนที่ได้</th>
                        <th width="20%" class="center">คะแนน <br><!-- <input type='checkbox' id='checkAll' /> --> </th>
                    </tr>
                </thead>
                <tbody>

                    <!-- <input type='hidden' name='reset_type' value="<?= $type; ?>">
                    <input type='hidden' name='user_id' value="<?= $user_id ?>"> -->
                    <!-- <input type='checkbox' id='checkAll' /> เลือกทั้งหมด -->
                    <?php foreach ($model as $key => $value) {
                       
                     ?>
                     <tr>
                        
                        <td style="word-wrap:break-word;"><?= $value->question->ques_title; ?>
                        </td>
                        <td><?= $value->logques_text; ?>
                        </td>
                        <td class="center"><?= $value->result; ?>/<?= $value->question->max_score; ?>
                        </td>
                         <td width="10%" class="text-center" style="vertical-align: middle;">
                            <!-- <input class="checkCourse" type='checkbox' data-toggle="toggle" name=logques_id[<?= $value->logques_id; ?>]  value="<?= $value->logques_id; ?>" /> -->
                            <input type="number" style="width: 100%;" name=logques_id[<?= $value->logques_id; ?>] min="0" max=<?= $value->question->max_score; ?> placeholder="  ให้คะแนนใหม่" required value=<?= $value->result; ?> >
                            <!-- <select name=logques_id[<?= $value->logques_id; ?>] required>
                              <option value="">เลือกคำตอบ</option>
                              <option value="1">ถูก</option>
                              <option value="0">ผิด</option>
                            </select> -->
                        </td> 
                    </tr>
                    <?php
                }
                ?>
                    <tr>
                        <td colspan="2">คะแนนรวมทั้งหมด
                        </td>

                        <td class="center"><?= $model[0]->Score->score_number; ?>/<?= $model[0]->Score->score_total; ?>
                        </td>
                    </tr>

            </tbody>
        </table>
    </div>
    <?php }else{ ?>
        <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                    <!-- // Table END -->
                </div>

    <?php } ?>
</form>
<script>

</script>
