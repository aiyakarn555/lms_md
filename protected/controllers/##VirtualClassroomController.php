<?php

class VirtualClassroomController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//CourseOnline
		$this->render('index');
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionJoin($id)
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();
		$room = Vroom::model()->findByPk($id);

		if($room && !Yii::app()->user->isGuest){
			$userObject = Yii::app()->getModule('user')->user();
			$joinParams = array(
				'meetingId' => $room->id, 				// REQUIRED - We have to know which meeting to join.
				'username' => $userObject->username,		// REQUIRED - The user display name that will show in the BBB meeting.
				'password' => $room->attendeePw,					// REQUIRED - Must match either attendee or moderator pass for meeting.
				// 'createTime' => '',					// OPTIONAL - string
				'userId' => $userObject->id,						// OPTIONAL - string
				// 'webVoiceConf' => ''				// OPTIONAL - string
			);
			// Get the URL to join meeting:
			$itsAllGood = true;
			try {$result = $bbb->getJoinMeetingURL($joinParams);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true) {
				//Output results to see what we're getting:
				$this->redirect($result);
			}else{
				$this->redirect(array('virtualclassroom/index'));
			}

		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}