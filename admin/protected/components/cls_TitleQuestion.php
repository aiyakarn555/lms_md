<?php
	class cls_TitleQuestion
	{
		public function getSkip(){
			return 20;
		}
		private function getModelPK($id){
			return MTitlequestion::model()->findByPk($id);
		}
		public function selectAutoComplete($filter){
			$criteria = new CDbCriteria;
			$criteria->select=array('Tit_cNameTH','Tit_cNameEN');
			$criteria->addCondition("cAction = 'y'");

			//$criteria->limit = $this->getSkip();
			$criteria->limit = 10;
			$criteria->addCondition(
				"(Tit_cNameTH LIKE '%".$filter."%' OR Tit_cNameEN LIKE '%".$filter."%')");
			$result = MTitlequestion::model()->findAll($criteria);

			return $result;
		}
		public function selectData($filter,$page){
			$criteria = new CDbCriteria;
			$criteria->select=array('Tit_cNameTH','Tit_cNameEN','Tit_nID');
			$criteria->addCondition("cActive = 'y'");

			$criteria->limit = $this->getSkip();

			$criteria->offset = ($page-1)*$this->getSkip();

			if($filter!=null){
				$criteria->addCondition(
					"(Tit_cNameTH LIKE '%".$filter."%' "
						."OR Tit_cNameEN LIKE '%".$filter."%')");
			}
			return MTitlequestion::model()->findAll($criteria);
		}
		public function countData($filter){
			return MTitlequestion::model()->count("cActive = 'y' AND 
				(Tit_cNameTH LIKE '%".$filter."%' "
						."OR Tit_cNameEN LIKE '%".$filter."%')");
		}
		public function insertData($QuestionTH,$QuestionEN,$DescriptionTH,$DescriptionEN,$session){
			$model = new MTitlequestion;
			//$model = addMaster($model,'admin','y');
			$model->Tit_cNameTH = $QuestionTH;
			$model->Tit_cNameEN = $QuestionEN;
			$model->Tit_cDetailTH = $DescriptionTH;
			$model->Tit_cDetailEN = $DescriptionEN;
			$model->cCreateBy = $session;
	       	$model->dCreateDate = date('Y-m-d H:i:s');
	       	$model->cUpdateBy = $session;
	       	$model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'y';
	        return $model->save();
		}
		public function updateData($id,$QuestionTH,$QuestionEN,$DescriptionTH,$DescriptionEN,$session){
			$update = MTitlequestion::model()->findByPk($id);
			$update->Tit_cNameTH = $QuestionTH;
			$update->Tit_cNameEN = $QuestionEN;
			$update->Tit_cDetailTH = $DescriptionTH;
			$update->Tit_cDetailEN = $DescriptionEN;
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			return $update->save();
		}
		public function deleteData($id,$session){
			$update = MTitlequestion::model()->findByPk($id);
			$update->cActive = 'n';
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			return $update->save();
		}
		public function deleteAll(){
			return MTitlequestion::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>'admin'
				,'dUpdateDate'=>date('Y-m-d H:i:s')),"cActive = 'y'");
		}
		private function addMaster($model,$createby,$action){
			$model->cCreateby = $createby;
	       	$model->dCreatedate = date('Y-m-d H:i:s');
	        $model->cActive = $action;
			return $model;
		}
	}
?>