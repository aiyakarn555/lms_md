<?php
	class cls_TypeAnswer
	{
		public function getSkip(){
			return 20;
		}
		private function getModelPK($id){
			return MTypeanswer::model()->findByPk($id);
		}
		public function selectAutoComplete($filter){
			$criteria = new CDbCriteria;
			$criteria->select=array('Tan_cNameTH','Tan_cNameEN');
			$criteria->addCondition("cActive = 'y'");

			//$criteria->limit = $this->getSkip();
			$criteria->limit = 10;
			$criteria->addCondition(
				"(Tan_cNameTH LIKE '%".$filter."%' OR Tan_cNameEN LIKE '%".$filter."%')");
			$result = MTypeanswer::model()->findAll($criteria);

			return $result;
		}
		public function selectData($filter,$page){
			$criteria = new CDbCriteria;
			$criteria->select=array('Tan_cNameTH','Tan_cNameEN','Tan_nID');
			$criteria->addCondition("cActive = 'y'");

			$criteria->limit = $this->getSkip();

			$criteria->offset = ($page-1)*$this->getSkip();

			if($filter!=null){
				$criteria->addCondition(
					"(Tan_cNameTH LIKE '%".$filter."%' "
						."OR Tan_cNameEN LIKE '%".$filter."%')");
			}
			return MTypeanswer::model()->findAll($criteria);
		}
		public function countData($filter){
			return MTypeanswer::model()->count("cActive = 'y' AND 
				(Tan_cNameTH LIKE '%".$filter."%' "
						."OR Tan_cNameEN LIKE '%".$filter."%')");
		}
		public function insertData($nameTH, $nameEN, $detailTH, $detailEN, $ruleTH, $ruleEN,$session) {
	        $model = new MTypeanswer();
	        $model->Tan_cNameTH = $nameTH;
	        $model->Tan_cNameEN = $nameEN;
	        $model->Tan_cDescriptionTH = $detailTH;
	        $model->Tan_cDescriptionEN = $detailEN;
	        $model->Tan_cRulesTH = $ruleTH;
	        $model->Tan_cRulesEN = $ruleEN;
	        $model->cCreateBy = $session;
	        $model->dCreateDate = date('Y-m-d H:i:s');
	        $model->cUpdateBy = $session;
	        $model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'y';
	        return $model->save();
	    }
		public function updateData($id,$nameTH, $nameEN, $detailTH, $detailEN, $ruleTH, $ruleEN,$session){
			$update = MTypeanswer::model()->findByPk($id);
	        $update->Tan_cNameTH = $nameTH;
	        $update->Tan_cNameEN = $nameEN;
	        $update->Tan_cDescriptionTH = $detailTH;
	        $update->Tan_cDescriptionEN = $detailEN;
	        $update->Tan_cRulesTH = $ruleTH;
	        $update->Tan_cRulesEN = $ruleEN;
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			return $update->save();
		}
		public function deleteData($id,$session){
			$update = MTypeanswer::model()->findByPk($id);
			$update->cActive = 'n';
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			return $update->save();
		}
		public function deleteAll($session){
			return MTypeanswer::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
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