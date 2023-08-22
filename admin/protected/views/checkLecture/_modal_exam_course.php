    <form id='form-course' action='CheckLecture/SaveExam' method='post'>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>คำถาม</th>
                        <th>คำตอบ</th>
                         <th>คะแนนเต็ม</th>
                        <th width="20%">ให้คะแนน <br><!-- <input type='checkbox' id='checkAll' /> --> </th>
                    </tr>
                </thead>
                <tbody>

                    <!-- <input type='hidden' name='reset_type' value="<?= $type; ?>">
                    <input type='hidden' name='user_id' value="<?= $user_id ?>"> -->
                    <!-- <input type='checkbox' id='checkAll' /> เลือกทั้งหมด -->
                    <?php foreach ($model as $key => $value) {
                     ?>
                     <tr>
                       
                        <td style="word-wrap:break-word;"><?= $value->questions->ques_title; ?>
                        </td>
                        <td><?= $value->logques_text; ?>
                        </td>
                         <td class="center"><?= $value->questions->max_score; ?>
                        </td>
                         <td width="10%" class="text-center" style="vertical-align: middle;">
                            <!-- <input class="checkCourse" type='checkbox' data-toggle="toggle" name=logques_id[<?= $value->logques_id; ?>]  value="<?= $value->logques_id; ?>" /> -->
                            <input type="number" name=logques_id[<?= $value->logques_id; ?>] min="0" max=<?= $value->questions->max_score; ?> required value="<?= $value->result; ?>">
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
            </tbody>
        </table>
    </div>
</form>
<script>

</script>
