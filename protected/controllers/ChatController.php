<?php

class ChatController extends Controller
{
	private $_id;
	private $_adminListUsers;
	private $_usersListAdmin;

	public function init()
	{
		$this->_id = Yii::app()->user->id;

		// admin list user
		$this->_adminListUsers = array(
			'condition'=>'id !=:currentID AND superuser=0 AND status=1 AND online_status=1',
			'params'=>array('currentID'=>$this->_id)
		);

		// users list admin
		$this->_usersListAdmin = array(
			'condition'=>'id !=:currentID AND superuser=1 AND status=1 AND online_status=1',
			'params'=>array('currentID'=>$this->_id)
		);
	}

	public function actionListUsers()
	{
		$_search = isset($_POST['s']) ? $_POST['s'] : NULL;

		if($this->isCheck() === true) :
			$_user = User::model()->findAll( $this->searchUsers($this->_adminListUsers, $_search) );
		else:
			$_user = User::model()->findAll( $this->searchUsers($this->_usersListAdmin, $_search) );
		endif;

		$_json['isAdmin'] = $this->isCheck();
		$_json['your_id'] = $this->_id;
		if( count($_user) > 0 ) :
			foreach ($_user as $user) {
				$_json['data'][] = array(
					'userid' => $user->id,
					'name' 	=> $user->username,
					'image'	=> $this->hasImagePath( $user->pic_user ),
					'email'	=> $user->email,
					'message' => $this->countChat($user->id),
				);
			}

			if($_search == NULL){
				function sorting($a, $b){
					return ($a['message'] < $b['message']);
				}
				usort($_json['data'], 'sorting');
			}

		endif;

		echo CJSON::encode($_json);		
	}

	public function actionUser()
	{
		if(isset($_POST['id'])) : 
			$user = User::model()->findByPk( $_POST['id'] );

			$_json = array(
				'userid' => $user->id,
				'name' 	=> $user->username,
				'image'	=> $this->hasImagePath( $user->pic_user ),
				'email'	=> $user->email
			);

			echo CJSON::encode($_json);
		endif;
	}

	public function actionCheckMsg()
	{
		$id = isset($_POST['isID']) ? $_POST['isID'] : NULL;
		if($id != NULL){
			$_chat = Chat::model()->findAll(array(
				'condition'=>'chatcode=:chat',
				'params'=>array( 'chat'=>$this->getCode($this->_id,$id) ),
				'order'=> 'time ASC'				
			));

			if(count($_chat) > 0){
				foreach ($_chat as $msg) {					
					$user = User::model()->findByPk( $msg->user_from );

					$_json[] = array(
						'msg_class' => $this->_id==$msg->user_from ? 'me' : 'another',
						'msg_from' => $user->username,
						'msg_image' => $this->hasImagePath( $user->pic_user ),
						'msg_text' => $msg->message,
						'msg_time' => $this->setTimer( $msg->time ),
					);							
				}
			}else{
				$_json = array();
			}

			echo CJSON::encode($_json);		
		}
	}

	public function actionSend()
	{
		$_to = isset($_POST['to']) ? $_POST['to'] : NULL;
		$_msg = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : NULL;
		$_from = isset($this->_id) ? $this->_id : NULL;
		$_time = time();

		if($_from!=NULL && $_msg!=NULL && $_to!=NULL) : 

			$isRoom = $this->getCode($_to, $_from);
			if($this->getCode($_to, $_from) == NULL){
				$_setRoom = $this->setCode($_time);

				$room = new Chatroom();
				$room->room_code = $_setRoom;
				$room->room_user = $this->setArray($_to, $_from);
				if($room->validate()){
					$room->save();
				}
			}

			$chat = new Chat();
			$chat->chatcode = isset($_setRoom) ? $_setRoom : $isRoom;
			$chat->user_from = $_from;
			$chat->time = $_time;
			$chat->view = 0;
			$chat->message = $_msg;			

			if($chat->validate()) {
				if($chat->save()){
					$user = User::model()->findByPk( $_from );

					$_json = array(
						'from_id' => $_from,
						'to_id' => $_to,
						'msg_from' => $user->username,
						'msg_image' => $this->hasImagePath( $user->pic_user ),
						'msg_text' => $_msg,
						'msg_time' => $this->setTimer( $_time ),
					);

					echo CJSON::encode($_json);
				}
			}
		endif;
	}

	public function actionReadMessage()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : NULL;
		if($id != NULL){
			$code = $this->getCode($this->_id,$id);
			$criteria = new CDbCriteria;
			$criteria->condition = 'chatcode=:setChat AND user_from=:userID AND view=0';
			$criteria->params = array( ':setChat'=>$code, ':userID'=>$id );

			$chat = Chat::model()->findAll( $criteria );
			if(count($chat) > 0){
				$call = count($chat) - 1;
				foreach ($chat as $x => $edit) {
					$edit->view = time();
					$edit->save();
					if($x == $call){
						echo CJSON::encode(array('view'=>true));
					}
				}
			}
		}
	}

	public function actionTest(){
		var_dump($this->countChat(2));
	} 

	private function isCheck()
	{
		if(Yii::app()->user->isGuest){
			return false;
		}else{
			$user = User::model()->findByPk( $this->_id );
			if($user->superuser == 1){
				return true;
			}else{
				return false;
			}
		}
	}

	private function countChat($id){
		$code = $this->getCode($this->_id,$id);
		$criteria = new CDbCriteria;
		$criteria->condition = 'chatcode=:setChat AND user_from=:userID AND view=0';
		$criteria->params = array( ':setChat'=>$code, ':userID'=>$id );

		$_chat = Chat::model()->findAll($criteria);

		return count($_chat);
	}

	private function searchUsers($rootArr, $subArr=NULL)
	{
		if($subArr != NULL){
			$order = array('order'=>'username LIKE \'%'.$subArr.'%\' DESC');
			$search = array_merge($rootArr, $order);
		}else{
			$search = $rootArr;
		}
		return $search;
	}

	private function hasImagePath( $image )
	{
		$img = Yii::app()->request->baseUrl.'/images/'.$image;
		if(file_exists( Yii::app()->basePath.'/../images/'.$image ) && $image != NULL){
			return $img;
		}else{
			return Yii::app()->request->baseUrl.'/images/no_img.jpg';
		}
	}

	private function getCode($num1,$num2)
	{
		$setArr = array($num1,$num2);
		$room = Chatroom::model()->findAll();
		foreach ($room as $key => $_room) {
			$compare = explode(',', $_room->room_user);
			$success = array_diff($setArr,$compare);
			if(empty($success)){
				return $_room->room_code;
			}
		}
	}

	private function setCode($_code)
	{
		return base64_encode($_code);
	}

	private function setArray($num1, $num2){
		return $num1.','.$num2;
	}

	private function setTimer( $_int )
	{
		date_default_timezone_set("Asia/Bangkok");
		if(date('Y-m-d') == date('Y-m-d', $_int)){
			return date('เมื่อเวลา H:i', $_int);
		}else{
			return date('วันที่ d/m/y', $_int);
		}		
	}
}