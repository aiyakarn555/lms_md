<?php
	class cls_GroupQuestionnaire
	{
		public function getSkip(){
			return 20;
		}
		private function getModelPK($id){
			return CGroupquestionnaire::model()->findByPk($id);
		}
		public function selectAutoComplete($filter){
			$criteria = new CDbCriteria;
			$criteria->select=array('Gna_cNameTH','Gna_cNameEN');
			$criteria->addCondition("cActive = 'y'");

			//$criteria->limit = $this->getSkip();
			$criteria->limit = 10;
			$criteria->addCondition(
				"(Gna_cNameTH LIKE '%".$filter."%' OR Gna_cNameEN LIKE '%".$filter."%')");
			$result = CGroupquestionnaire::model()->findAll($criteria);

			return $result;
		}
		public function selectData($filter,$page){
			$criteria = new CDbCriteria;
			$criteria->select=array('Gna_cNameTH','Gna_cNameEN','Gna_dStart','Gna_dEnd','Gna_nID');
			$criteria->addCondition("cActive = 'y'");

			$criteria->limit = $this->getSkip();

			$criteria->offset = ($page-1)*$this->getSkip();

			if($filter!=null){
				$criteria->addCondition(
					"(Gna_cNameTH LIKE '%".$filter."%' "
						."OR Gna_cNameEN LIKE '%".$filter."%')");
			}
			//$criteria->order = 'Gna_dEnd DESC';
			return CGroupquestionnaire::model()->findAll($criteria);
		}
		public function countData($filter){
			return CGroupquestionnaire::model()->count("cActive = 'y' AND 
				(Gna_cNameTH LIKE '%".$filter."%' "
						."OR Gna_cNameEN LIKE '%".$filter."%')");
		}
		/*public function insertData($nameTH, $nameEN, $detailTH, $detailEN, $ruleTH, $ruleEN,$session) {
	        $model = new CGroupquestionnaire();
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
			$update = CGroupquestionnaire::model()->findByPk($id);
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
			$update = CGroupquestionnaire::model()->findByPk($id);
			$update->cActive = 'n';
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			return $update->save();
		}*/
		public function deleteAll($session){
			return CGroupquestionnaire::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s')),"cActive = 'y'");
		}/*
		private function addMaster($model,$createby,$action){
			$model->cCreateby = $createby;
	       	$model->dCreatedate = date('Y-m-d H:i:s');
	        $model->cActive = $action;
			return $model;
		}*/
	}
?>