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


function save_db()
{
    $model = New CaptureLearn;
    $model->lesson_id = $_POST['lesson_id'];
    $model->course_id = $_POST['course_id'];
    $model->user_id = Yii::app()->user->id;
    $model->file_id = $_POST['file_id'];
    $model->create_date = date("Y-m-d H:i:s");
    $model->update_date = date("Y-m-d H:i:s");
    $model->save();
}


function check_file_name($inc = 0)
{
    $model = CaptureLearn::model()->find(array('order'=>'id desc'));
    $user_id = (isset(Yii::app()->user->id)) ? Yii::app()->user->id : "";
    $path = 'uploads/learn_picture/'.$model->course_id.'/'.$user_id.'/';
    $file_name = date("Y-m-d_H-i-s");
    $file_no = 1 + $inc;
    $file_extension = '.jpg';
    $full_path = $path.$file_name."_".$model->id."_".$file_no.$file_extension;
    /*
     * example of the filename
     * 'uploads/student_picture/292/1/image_1_16.png'
     * first number is tbl_capture.id
     * second number is amount. it should be 1 all the time
     * unless it got duplicate somehow
     */

    /* if folder not exists: creates it*/
    if (!file_exists($path))
    {
        /*
          0777 it needed to create a recursive path.
          Different permission may works too.
          I have not test it yet.
         */
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
