<?php
//error_reporting(0);
class FormSurveyController extends Controller
{
	
	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
            );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
                'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
                'expression' => 'AccessControl::check_access()',
                ),
            array('deny',  // deny all users
                'users' => array('*'),
                ),
            );
    }
	
	public function actionView($id)
	{
		$model=FormSurvey::model()->findByPk($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionFormPDF($id)
	{
	    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase','autoload'));

        // Remove header
        $pdf->setPrintHeader(false);

        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(false);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $borderDotted = array(
            'B' => array(
                'width' => 0.1,
                'cap'   => 'butt',
                'dash'  => 1,
                'color' => array(0, 0, 0)
            )
        );

        $borderNormal = array(
            'RTBL' => array(
                'width' => 0.5,
                'dash'  => 0,
                'color' => array(0, 0, 0)
            )
        );
         $borderline = array(
            'BL' => array(
                'width' => 0.2,
               
                'dash'  => 0,
                'color' => array(0, 0, 0)
            )
        );
          $borderNormal2 = array(
            'TLR' => array(
                'width' => 0.5,
                'dash'  => 0,
                'color' => array(0, 0, 0)
            ),

        );

           $borderNormal3 = array(
            'RTBL' => array(
                'width' => 0.2,
                'dash'  => 0,
                'color' => array(0, 0, 0)
            )
        );

        $model=FormSurvey::model()->findByPk($id);
        $pdf->setCellMargins(1, 1, 1, 1);


        $checked1= 'images/checkbox-checked.jpg';
		$checked2= 'images/checkbox-unchecked.jpg';

        $pdf->AddPage();

        $pdf->SetFont('AngsanaUPC', 'B', 20);
        $pdf->writeHTML($model->fs_title, true, 0, true, 0);

        $pdf->writeHTML('<br/><hr>',true,0,true,0);

        foreach ($model->FormSurveyHeader as $key => $value){
        	//$value->fsh_title
        	 $pdf->SetFont('AngsanaUPC', 'B', 20);
        	$pdf->writeHTML($value->fsh_title, true, 0, true, 0);
        	$pdf->SetFont('AngsanaUPC', '', 16);
        	if($value->fsh_type=="checkbox"){
        		$i=0;
        		foreach ($value->FormSurveyList as $key => $valuelist) {
        			if ($i%2=="0"){
        				$pdf->writeHTMLCell(7, '', '', '', '', 0, 0, 0, true, 'L', true);
				        $pdf->Image($checked2, ($pdf->GetX()+1.5), ($pdf->GetY()+3.4), 4, 4, 'JPG', $link =  null, '', true, 150, '', false, false, false, false, false, false);
				        $pdf->writeHTMLCell(7, null, '', '', '', 0, 0, 0, true, 'L', 0);
				        $pdf->writeHTMLCell(80, '', '', '', $valuelist->fsl_value, 0, 0, 0, true, 'L', 0);
        			}
        			else
        			{
        				$pdf->writeHTMLCell(7, '', '', '', '', 0, 0, 0, true, 'L', true);
				        $pdf->Image($checked2, ($pdf->GetX()+1.5), ($pdf->GetY()+3.4), 4, 4, 'JPG', $link =  null, '', true, 150, '', false, false, false, false, false, false);
				        $pdf->writeHTMLCell(7, null, '', '', '', 0, 0, 0, true, 'L', 0);
				        $pdf->writeHTMLCell(80, '', '', '', $valuelist->fsl_value, 0, 1, 0, true, 'L', 0);

        			}
        			$i++;
	        		
		    	}
		    	$pdf->writeHTML('<br/>',true,0,true,0);

        	}
        	else if($value->fsh_type=="radio"){
        		$i=0;
        		foreach ($value->FormSurveyList as $key => $valuelist) {
        			if ($i%2=="0"){
        				$pdf->writeHTMLCell(7, '', '', '', '', 0, 0, 0, true, 'L', true);
				        $pdf->Image($checked2, ($pdf->GetX()+1.5), ($pdf->GetY()+3.4), 4, 4, 'JPG', $link =  null, '', true, 150, '', false, false, false, false, false, false);
				        $pdf->writeHTMLCell(7, null, '', '', '', 0, 0, 0, true, 'L', 0);
				        $pdf->writeHTMLCell(80, '', '', '', $valuelist->fsl_value, 0, 0, 0, true, 'L', 0);
        			}
        			else
        			{
        				$pdf->writeHTMLCell(7, '', '', '', '', 0, 0, 0, true, 'L', true);
				        $pdf->Image($checked2, ($pdf->GetX()+1.5), ($pdf->GetY()+3.4), 4, 4, 'JPG', $link =  null, '', true, 150, '', false, false, false, false, false, false);
				        $pdf->writeHTMLCell(7, null, '', '', '', 0, 0, 0, true, 'L', 0);
				        $pdf->writeHTMLCell(80, '', '', '', $valuelist->fsl_value, 0, 1, 0, true, 'L', 0);

        			}
        			$i++;
        		}
        		$pdf->writeHTML('<br/>',true,0,true,0);
        	}
        	else if($value->fsh_type=="tablescore"){
        		// $html ="<table style='width:100%;border:1px solid #000'>";
        		
	        		// $html .="<tr>";
	        		// 	$html .=" <td rowspan='2' align='center'> <b>รายการ</b></td>";
	        		// 	$html .=" <td rowspan='5' align='center'> <b>ระดับความพึงพอใจ</b></td>";
	        		// $html .="</tr>";

				$pdf->SetFont('AngsanaUPC', 'B', 15);	
				$pdf->setCellMargins(0, 0, 0, 0);	
		        $html='<table width="100%">';
		        $html .='<tr width="100%">';
	        	$html .=' <td width="30%" border="1" rowspan="2" align="center"> <b>รายการ</b></td>';
	        	$html .=' <td width="70%" border="1" colspan="5" align="center"> <b>ระดับความพึงพอใจ</b></td>';
	        	$html .='</tr>';
	       		$html.='<tr width="100%">';
	       		$html.='<td border="1" align="center" width="13%"><B>น้อยที่สุด (1)</B></td>';
	       		$html.='<td border="1" align="center" width="14%"><B>น้อย (2)</B></td>';
	       		$html.='<td border="1" align="center" width="15%"><B>ปานกลาง (3)</B></td>';
	       		$html.='<td border="1" align="center" width="13%"><B>มาก (4)</B></td>';
	       		$html.='<td border="1" align="center" width="15%"><B>มากที่สุด (5)</B></td>';
	       		$html.='</tr>';
	       		$pdf->SetFont('AngsanaUPC', '', 12);
	       		$idx=1;
	       		foreach ($value->FormSurveyList as $key => $valuelist) { 
					$html .="<tr>";
						$html.='<td border="1">'.'  '.$idx++.'. '.$valuelist->fsl_value.'</td>';
						$html .='<td border="1" align="center"><img src="'.$checked2.'" width="15px"></td>';
	        			$html .='<td border="1" align="center"><img src="'.$checked2.'" width="15px"></td>';
	        			$html .='<td border="1" align="center"><img src="'.$checked2.'" width="15px"></td>';
	        			$html .='<td border="1" align="center"><img src="'.$checked2.'" width="15px"></td>';
	        			$html .='<td border="1" align="center"><img src="'.$checked2.'" width="15px"></td>';
        			$html .='</tr>';
        		}
	       		$html.='</table>';
	       		$pdf->writeHTML($html, true, false, true, false);
							  
        	}
        	else if($value->fsh_type=="textField"){
        		 $pdf->writeHTMLCell(80, '', '', '','', $borderDotted, 1, 0, true, 'C', true);

        	}
        	else if($value->fsh_type=="textArea"){
        		$pdf->writeHTMLCell(180, '', '', '','', $borderDotted, 1, 0, true, 'C', true);
        		$pdf->writeHTMLCell(180, '', '', '','', $borderDotted, 1, 0, true, 'C', true);
				$pdf->writeHTMLCell(180, '', '', '','', $borderDotted, 1, 0, true, 'C', true);
        	}


        }

         $pdf->setCellMargins(1, 1, 1, 1);
        //Close and output PDF document
        $pdf->Output('survey.pdf', 'I');
        Yii::app()->end();
	}

	public function actionCreate()
	{
		$model=new FormSurvey;

	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FormSurvey']))
		{
			$model->attributes=$_POST['FormSurvey'];
			$model->startdate=date("Y-m-d", strtotime($_POST['FormSurvey']['startdate']))." 00:00:01";
			$model->enddate=date("Y-m-d", strtotime($_POST['FormSurvey']['enddate']))." 23:59:59";
			$model->fg_id=$_GET['id'];
			// var_dump($model->attributes);
			// exit();
			if($model->save()){
				
				$i=count($_POST['fsh_title']);
			 	//echo $i."<< title<br/>";
				// var_dump($_POST['fsh_title']);
				// exit();

				$key=1;
				$keytitle=0;
				while($key<=$i){
					$modelQuest=new FormSurveyHeader;
					$modelQuest->fs_id=$model->fs_id;
					$modelQuest->fsh_type=$_POST['selectChoichType-'.$key.''];
					$modelQuest->fsh_title=$_POST['fsh_title'][$keytitle];
					if($modelQuest->save()){

						if($_POST['selectChoichType-'.$key.'']=='radio' || $_POST['selectChoichType-'.$key.'']=='checkbox' || $_POST['selectChoichType-'.$key.'']=='tablescore'){
							
							
							$countchoice=count($_POST['choicelistdata-'.$key.'']);
							 //echo $countchoice;
							// exit();
							$keychoice=0;
							$keyloop=1;
							//echo $key."<<< key <br/>";
							while($keyloop<=$countchoice){
								$modelAns=new FormSurveyList;
								$modelAns->fsh_id=$modelQuest->fsh_id;
								//echo $keychoice."<<< choic<br/>";
								$modelAns->fsl_value=$_POST['choicelistdata-'.$key.''][$keychoice];
								//echo $modelAns->fsl_value."<<< value <br/>";
								//exit();
								if($modelAns->save()){
								$keychoice++;
								$keyloop++;
								}
								
							}
						}
						
					}
					
				$keytitle++;
				$key++;
				}
				$this->redirect(array('view','id'=>$model->fs_id));
			}							
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	
	public function actionExportForm($id){
		// $model=FormSurvey::model()->findByPk($id);
		
		// // get a reference to the path of PHPExcel classes 
		// foreach ($model->FormSurveyHeader as $key => $value){
	 //   		echo $value->fsh_title;
	 //   }
	   
	 //   exit();

     $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
 
     // Turn off our amazing library autoload 
      spl_autoload_unregister(array('YiiBase','autoload'));        
 	
     //
     // making use of our reference, include the main class
     // when we do this, phpExcel has its own autoload registration
     // procedure (PHPExcel_Autoloader::Register();)
    include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
 
     // Create new PHPExcel object
     $objPHPExcel = new PHPExcel();

     // Set properties
     $objPHPExcel->getProperties()->setCreator("Bangkokweb")
    ->setLastModifiedBy("Bangkokweb")
    ->setTitle("Excel Report")
    ->setSubject("Excel Report")
    ->setDescription("Excel Report FormSurvey")
    ->setKeywords("Excel Form")
    ->setCategory("Excel result file");
 
 	 
     	$db = Yii::app()->db;
		$sql="SELECT e1.fs_head,e2.fsh_title,e2.fsh_type,e2.fsh_id,
					(SELECT count(*) FROM tbl_formsurvey_log ee1 where e2.fsh_id=ee1.fsh_id) AS CountAns
				FROM tbl_formsurvey E1
				INNER JOIN tbl_formsurvey_header E2
				ON E1.fs_id=E2.fs_id
				WHERE e1.fs_id='".$id."'";
		$res = $db->createCommand($sql)->queryAll();
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','รายงานแบบสอบถาม');
		$table=2;
		$no=1;
		foreach ($res as $key => $value) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,'');
	        $table++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table, 'ข้อที่ '.$no.'.'.$value['fsh_title']);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->getStartColor()->setRGB('E4EAF4');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(30);
            $table++;
            if($value['fsh_type']=="checkbox"){
            	

            	$db = Yii::app()->db;
				$sql2="SELECT e1.fsl_value,e1.fsl_value,(SELECT count(*) FROM tbl_formsurvey_log E2 WHERE e2.fsh_id='".$value['fsh_id']."' AND e1.fsl_value=e2.fsl_value) AS countData
						FROM tbl_formsurvey_list E1
						where e1.fsh_id='".$value['fsh_id']."'";
				$res2 = $db->createCommand($sql2)->queryAll();

            	foreach ($res2 as $key => $valueres) {
            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,$valueres['fsl_value']);
	           		// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->getStartColor()->setRGB('EEE');

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$table,$valueres['countData']);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->getStartColor()->setRGB('333');
	            	 $table++;
            	}
            }
            else if($value['fsh_type']=="radio"){	
            	$db = Yii::app()->db;
				$sql2="SELECT e1.fsl_value,e1.fsl_value,(SELECT count(*) FROM tbl_formsurvey_log E2 WHERE e2.fsh_id='".$value['fsh_id']."' AND e1.fsl_value=e2.fsl_value) AS countData
						FROM tbl_formsurvey_list E1
						where e1.fsh_id='".$value['fsh_id']."'";
				$res2 = $db->createCommand($sql2)->queryAll();

            	foreach ($res2 as $key => $valueres) {
            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,$valueres['fsl_value']);
	           		/*
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->getStartColor()->setRGB('EEE');
*/

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$table,$valueres['countData']);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->getStartColor()->setRGB('333');
	            	 $table++;
            	}
            	
           	
           	}
           	 else if($value['fsh_type']=="tablescore"){	

            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,'หัวข้อ');
	           		$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$table)->getFill()->getStartColor()->setRGB('777777');

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$table,'น้อยที่สุด');
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$table)->getFill()->getStartColor()->setRGB('777777');

	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$table,'น้อย');
	           		$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$table)->getFill()->getStartColor()->setRGB('777777');

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$table,'ปานกลาง');
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$table)->getFill()->getStartColor()->setRGB('777777');

	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$table,'มาก');
	           		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$table)->getFill()->getStartColor()->setRGB('777777');

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$table,'มากที่สุด');
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.$table)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	            	$objPHPExcel->setActiveSheetIndex(0)->getStyle('F'.$table)->getFill()->getStartColor()->setRGB('777777');
	            	 $table++;
            	
            	       	 	$db = Yii::app()->db;
				$sql2="SELECT e1.fsl_value,e1.fsl_id,(SELECT count(*) FROM tbl_formsurvey_log E2 WHERE e2.fsh_id='".$value['fsh_id']."') AS countData
						FROM tbl_formsurvey_list E1
						where e1.fsh_id='".$value['fsh_id']."'";
				$res2 = $db->createCommand($sql2)->queryAll();

				$valueloop=1;
            	foreach ($res2 as $key => $valueres) {
            		$i1=0;
				$i2=0;
				$i3=0;
				$i4=0;
				$i5=0;
            		$db = Yii::app()->db;
					$sql3="SELECT e1.fsl_value
							FROM tbl_formsurvey_log E1
							where e1.fsl_id='".$valueres['fsl_id']."' ";
					$res3 = $db->createCommand($sql3)->queryAll();
					$icount=count($res3);
					foreach ($res3 as $key => $valueres3) {
				
					if($valueres3['fsl_value']==1){
						$i1=$i1+1;
					}
					else if($valueres3['fsl_value']==2){
						$i2=$i2+1;
					}
					else if($valueres3['fsl_value']==3){
						$i3=$i3+1;
					}
					else if($valueres3['fsl_value']==4){
						$i4=$i4+1;
					}
					else if($valueres3['fsl_value']==5){
						$i5=$i5+1;
					}
					

				}
				$i1=($i1*100)/$icount;
				$i2=($i2*100)/$icount;
				$i3=($i3*100)/$icount;
				$i4=($i4*100)/$icount;
				$i5=($i5*100)/$icount;


            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,$valueloop.''.$valueres['fsl_value']);
	           		

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$table,$i1.' %');
	            

	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$table,$i2.' %');
	           	

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$table,$i3.' %');
	            	

	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$table,$i4.' %');
	           		

   
	            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$table,$i5.' %');
	            	
	            	 $table++;
	            	 $valueloop++;
            	}
            	
           	
           	}
           	 else if($value['fsh_type']=="textField"){	
           	 	$db = Yii::app()->db;
				$sql2="SELECT e1.fsl_value
						FROM tbl_formsurvey_log E1
						where e1.fsh_id='".$value['fsh_id']."'";
				$res2 = $db->createCommand($sql2)->queryAll();

            	foreach ($res2 as $key => $valueres) {
            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,$valueres['fsl_value']);
	     

	            	 $table++;
            	}
            	
           	
           	}
           	 else if($value['fsh_type']=="textArea"){	
            	$db = Yii::app()->db;
				$sql2="SELECT e1.fsl_value
						FROM tbl_formsurvey_log E1
						where e1.fsh_id='".$value['fsh_id']."'";
				$res2 = $db->createCommand($sql2)->queryAll();

            	foreach ($res2 as $key => $valueres) {
            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$table,$valueres['fsl_value']);
	            	 $table++;
            	}
           	
           	}
	            
            
            $no++;
            //$fs_head=$value['fs_head'];
		}
		

 
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Simple');
 
      // Set active sheet index to the first sheet, 
      // so Excel opens this as the first sheet
     $objPHPExcel->setActiveSheetIndex(0);
     	

      $data=date('Y-m-d');
 
      // Redirect output to a client’s web browser (Excel2007)
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="report-'.$data.'.xlsx"');
      header('Cache-Control: max-age=0');

 
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      Yii::app()->end();
 
       // 
       // Once we have finished using the library, give back the 
       // power to Yii... 
       spl_autoload_register(array('YiiBase','autoload'));
    }
	


	public function actionUpdate($id)
	{
		$model=FormSurvey::model()->findByPk($id);
		//$courseid='1';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		if(isset($_POST['FormSurvey']))
		{

			$model->attributes=$_POST['FormSurvey'];
			$model->startdate=date("Y-m-d", strtotime($_POST['FormSurvey']['startdate']))." 00:00:01";
			$model->enddate=date("Y-m-d", strtotime($_POST['FormSurvey']['enddate']))." 23:59:59";
			//$model->course_id=$courseid;
			if($model->save()){
				
				if(isset($_POST['valuehiddenall'])){
				$i=$_POST['valuehiddenall'];
				}
				else
				{
					$i='1';
				}
				//var_dump($_POST['fsh_title']);
				//$modelQuestdel=FormSurveyHeader::model()->findAll("fs_id=$id");
				$modelhed=FormSurveyHeader::model()->findAll("fs_id =".$id." ");
				foreach ($modelhed as $key => $valuelistdata) {
					FormSurveyList::model()->deleteAll("fsh_id =".$valuelistdata->fsh_id." ");
				}

				//FormSurveyList::model()->deleteAll("fsh_id=".$id."");
				 FormSurveyHeader::model()->deleteAll("fs_id =".$id." ");
				// FormSurveyList::model()->deleteAll("fsh_id=".$id."");
				//exit();
				 //echo $_POST['valuehiddenall'];
				 //exit();
				$key=1;
				$keytitle=0;
				while($key<=$i){
					//echo "123";
							//echo $_POST['selectChoichType-'.$key.''];
	if($_POST['selectChoichType-'.$key.'']!=""){
						$modelQuest=new FormSurveyHeader;
						$modelQuest->fs_id=$model->fs_id;
						$modelQuest->fsh_type=$_POST['selectChoichType-'.$key.''];
						$modelQuest->fsh_title=$_POST['fsh_title'][$keytitle];
						if($modelQuest->save()){

							if($_POST['selectChoichType-'.$key.'']=='radio' || $_POST['selectChoichType-'.$key.'']=='checkbox' || $_POST['selectChoichType-'.$key.'']=='tablescore'){
								
								if(isset($_POST['choicelistdata-'.$key.''])){
								$countchoice=count($_POST['choicelistdata-'.$key.'']);
								//echo $countchoice;
								$keychoice=0;
								$keyloop=1;
								//echo "asdasd".$key."<<< key <br/>";
								while($keyloop<=$countchoice){
										//echo $keyloop;
										$modelAns=new FormSurveyList;
										$modelAns->fsh_id=$modelQuest->fsh_id;
										//echo $keychoice."<<< choic<br/>";
										$modelAns->fsl_value=$_POST['choicelistdata-'.$key.''][$keychoice];
										//echo $modelAns->fsl_value."<<< value <br/>";
										//exit();
										if($modelAns->save()){
										$keychoice++;
										$keyloop++;
										}
									
									
									}
								}	
							}
							
						}
					
				}
				
				$keytitle++;
				$key++;
				}
				//exit();
				$this->redirect(array('view','id'=>$model->fs_id));
			}	
		}

		if($model->status_approve=='y'){
			$this->render('update',array(
			'model'=>'คุณได้ยืนยันแบบสอบถามแล้วไม่สามารถแก้ไขได้',
		));
		}
		else
		{
		$this->render('update',array(
			'model'=>$model,
		));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->active = 'n';
	    $model->save();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionApprove($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->status_approve = 'y';
	    $model->save();

	   $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('formsurveygroup/index'));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{

		if(isset($id))
		{
			Yii::app()->user->setState('getReturn', $id);
			$model = new FormSurvey('search');
			$model->unsetAttributes();

			if(isset($_GET['FormSurvey']))
				$model->attributes = $_GET['FormSurvey'];
				$this->render('index',array(
					'model'=>$model,
					'pk'=>$id,
					
				));
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionMultiDelete()
	{	
		header('Content-type: application/json');
		if(isset($_POST['chk'])) 
		{
	        foreach($_POST['chk'] as $val) 
	        {
	            $this->actionDelete($val);
	        }
	    }
	}

	/**
	 * Manages all models.
	 */
	// public function actionAdmin()
	// {
	// 	$model=new FormSurvey('search');
	// 	$model->unsetAttributes();  // clear any default values
	// 	if(isset($_GET['FormSurvey']))
	// 		$model->attributes=$_GET['FormSurvey'];

	// 	$this->render('admin',array(
	// 		'model'=>$model,
	// 	));
	// }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FormSurvey the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FormSurvey::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FormSurvey $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='form-survey-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
