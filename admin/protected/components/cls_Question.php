<?php
	class cls_Question
	{
		public function getSkip(){
			return 20;
		}
		private function getModelPK($id){
			return MQuestion::model()->findByPk($id);
		}
		public function selectAutoComplete($filter){
			$criteria = new CDbCriteria;
			$criteria->select=array('Que_cNameTH','Que_cNameEN');
			$criteria->addCondition("cActive = 'y'");

			//$criteria->limit = $this->getSkip();
			$criteria->limit = 10;
			$criteria->addCondition(
				"(Que_cNameTH LIKE '%".$filter."%' OR Que_cNameEN LIKE '%".$filter."%')");
			$result = MQuestion::model()->findAll($criteria);

			return $result;
		}
		public function selectData($filter,$page){
			$criteria = new CDbCriteria;
			$criteria->select=array('Que_cNameTH','Que_cNameEN','Que_nID');
			$criteria->addCondition("cActive = 'y'");

			$criteria->limit = $this->getSkip();

			$criteria->offset = ($page-1)*$this->getSkip();

			if($filter!=null){
				$criteria->addCondition(
					"(Que_cNameTH LIKE '%".$filter."%' "
						."OR Que_cNameEN LIKE '%".$filter."%')");
			}
			//$criteria->order = 'Gna_dEnd DESC';
			return MQuestion::model()->findAll($criteria);
		}
		public function countData($filter){
			return MQuestion::model()->count("cActive = 'y' AND 
				(Que_cNameTH LIKE '%".$filter."%' "
						."OR Que_cNameEN LIKE '%".$filter."%')");
		}
		public function deleteAll($session){
			return MQuestion::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s')),"cActive = 'y'");
		}
	}
?>