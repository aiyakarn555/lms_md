<?php

//=========================================================================
// HELPER TAKE A PIC FROM WEBCAME DURING VIDEO LESSON AND SAVE TO DATABASE
//=========================================================================
# these functions are called from course-learn.php line: 1045

# indicate ajax request
if (isset($_POST['action']))
{
    switch ($_POST['action'])
    {
    case 'save_pic':
        save_pic($_POST['base64']);
        break;
    case 'save_db':
        save_db();
    }
}

/* extract base64 string to picture and save it */
function save_pic($data)
{
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    $success = file_put_contents(check_file_name(), $data);
}
/*
 * log each picture that saved during video lesson
 * save_db() and save_pic() always run together save_db runs first
 */
function save_db()
{
    $model = New CaptureExamsTeams;
    $model->lesson_teams_id = $_POST['lesson_teams_id'];
    $model->ms_teams_id = $_POST['ms_teams_id'];
    $model->user_id = Yii::app()->user->id;
    $model->time = $_POST['time'];
    $model->ques_type = $_POST['ques_type'];
    $model->create_date = date("Y-m-d H:i:s");
    $model->update_date = date("Y-m-d H:i:s");
    $model->save();
}

/*
 * check if file name duplicate or not
 * if duplicate: increases the number
 * else: save the file
 * @return string full path
 */
function check_file_name($inc = 0)
{
    $model = CaptureExamsTeams::model()->find(array('order'=>'id desc'));
    $user_id = (isset(Yii::app()->user->id)) ? Yii::app()->user->id : "";
    $path = 'uploads/exams_teams_picture/'.$model->ms_teams_id.'/'.$user_id.'/';
    $file_name = date("Y-m-d_H-i-s");
    $file_no = 1 + $inc;
    $file_extension = '.jpg';
    $full_path = $path.$file_name."_".$model->id."_".$file_no.$file_extension;

    /* if folder not exists: creates it*/
    if (!file_exists($path))
    {
        mkdir($path,0777,true);
    }

    if(file_exists($full_path))
    {
        # if file is duplicate (recursive)
        return check_file_name($inc + 1);
    }
    else
    {
        # update the last row of database for picture name
        $model->file_name = $file_name."_".$model->id."_".$file_no.$file_extension;
        $model->save();

        # file name has not been used, which mean we can use it!
        return $full_path;
    }
}
?>
