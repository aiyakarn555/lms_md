<?php
	$strPath = realpath(basename(getenv($_SERVER["SCRIPT_NAME"])));
	$FileName = "Report/Excel/".date('Y-m-d')."_".$id.".xls";
	$xlApp = new COM("Excel.Application");
	/*if($xlApp)
	{
		echo "Connect to Excel.Application";
	}
	else
	{
		echo "Can Not Connect to Excel.Application";
	}*/
	/*$xlBook = $xlApp->Workbooks->Add();
	$xlApp->Application->Visible = False;
	$xlBook->Worksheets(2)->Select;
	$xlBook->Worksheets(2)->Delete;
	$xlBook->Worksheets(2)->Select;
	$xlBook->Worksheets(2)->Delete;


	$xlBook->Worksheets(1)->Name = "Report";
	//$xlBook->Worksheets(1)->Name = $Header[0]['Gna_cNameTH'];
	$xlBook->Worksheets(1)->Select;


	$xlBook->ActiveSheet->Cells(1,1)->Value = "My Customer";
	$xlBook->ActiveSheet->Cells(1,1)->Font->Bold = True;
	$xlBook->ActiveSheet->Cells(1,1)->Font->Name = "Tahoma";
	$xlBook->ActiveSheet->Cells(1,1)->Font->Size = 16;

	$xlBook->ActiveSheet->Cells(2,1)->Value = "Customer Name";
	$xlBook->ActiveSheet->Cells(2,1)->Font->Name = "Tahoma";
	$xlBook->ActiveSheet->Cells(2,1)->BORDERS->Weight = 1;
	$xlBook->ActiveSheet->Cells(2,1)->Font->Size = 10;
	$xlBook->ActiveSheet->Cells(2,1)->MergeCells = True;

	$xlBook->ActiveSheet->Cells(2,2)->Value = "Used";
	$xlBook->ActiveSheet->Cells(2,2)->BORDERS->Weight = 1;
	$xlBook->ActiveSheet->Cells(2,2)->Font->Name = "Tahoma";
	$xlBook->ActiveSheet->Cells(2,2)->Font->Size = 10;
	$xlBook->ActiveSheet->Cells(2,2)->MergeCells = True;
 
	/*$xlBook->ActiveChart->HasTitle = True;
	$xlBook->ActiveChart->ChartTitle->Characters->Text = "My Chart";

	@unlink($strPath."/".$FileName);
	$xlBook->SaveAs($strPath."/".$FileName);
	$xlApp->Application->Quit; 
	echo CHtml::link($FileName);*/

/*if (file_exists(realpath("assets/Excel/ExportExcel/Excel.php"))) {
	require_once(realpath("assets/Excel/ExportExcel/Excel.php"));
}*/
?>