<?php echo CHtml::beginForm(Yii::app()->createUrl('AddGroup/Preview'), 'POST'); ?>

<?php 
$Opentable=0;
$closetable=0;
$loop=1;
$Scloop=1;
$close=0;
$Title=0;
while($row=$data->read()){      
    $num = 1;
if($row['Tit_nID']!=$Title)
    {   
        $Title=$row['Tit_nID'];
        echo "<table> ";
        echo "<tr><td>";
        echo "<h1>".$row['Tit_cNameTH']."</h1>";
        echo "</tr></td>";
        echo "</table>";
       
    }
    for($t=1;$t<=$count;$t++){      
    $x=0;                   
   
        if($row['Tit_nID']==$t){   
 
                if($row['Tan_nID']==1)
                {    
                if($x<1)
                            {
                                $num1=1;
                                $x++    ;
                            }                       
                                if ($row['Cho_nID'] != null) {
                                echo "<div>";
                                echo "<br>";
                                echo $num1.') '.$row['Que_cNameTH'];     
                                 echo '&nbsp;';                          
                                echo "<button type='button' id='del".$row['Que_nID']."' class='btn btn-primary'  value='".$row['Sna_nID']."' onclick='getTxt(".$row['Que_nID'].");'>DEL</button>";
                                echo "";                             
                                $c = 0;
                                echo "<div id='choice".$loop."''></div>";  
                                echo '<script>                                                      
                                 jQuery.ajax({
                                    type: "POST",
                                    url: "../AddGroup/Choice",
                                    data: {
                                                cID: "'.$row['Que_nID'].'"                                                                               
                                          },
                                    success: function (msg) {           
                                        //alert("Success");                            
                                        $("#choice'.$loop.'").html(msg);
                                    },
                                    error: function (xhr) {
                                        alert("failure: " + xhr.readyState + this.url);

                                    }
                                });           
                                                                                
                                                               
                                
                                </script> ';

                                 echo "</div>";
                                $loop++;
                            }           
                }
                if($row['Tan_nID']==2) 
                {
                    if($x<1)
                            {
                                $num2=1;
                                $x++    ;
                            }           
                                if ($row['Cho_nID'] != null) {
                                echo "<div>";
                                echo "<br>";
                                echo $num2.') '.$row['Que_cNameTH'];    
                                 echo '&nbsp;';                             
                                echo "<button type='button' id='del".$row['Que_nID']."' class='btn btn-primary'  value='".$row['Sna_nID']."' onclick='getTxt(".$row['Que_nID'].");'>DEL</button>";                            
                                $c = 0;                             
                                echo "<div id='subchoice".$Scloop."''></div>";  
                                echo '<script>   
                                 //alert("ID: "+'.$row['Que_nID'].');                    
                                 jQuery.ajax({
                                    type: "POST",
                                    url: "../AddGroup/SubChoice",
                                    data: {
                                                cID: "'.$row['Que_nID'].'"                                                                               
                                          },
                                    success: function (msg) {                                       
                                        $("#subchoice'.$Scloop.'").html(msg);
                                    },
                                    error: function (xhr) {
                                        alert("failure: " + xhr.readyState + this.url);

                                    }
                                });           
                                </script> ';
                                $Scloop++;
                                echo "</div>";
                            }           
                }                
                   
                if($row['Tan_nID']==3)
                {
                                   
                   if($row['Tit_nID']!=$Opentable){                    
                   $Opentable = $row['Tit_nID'];
                                
                                if($closetable==1)
                                {
                                   
                                    echo "</table>";
                                    echo "<br>";
                                    $closetable=0;
                                }
                                $closetable=1;;
                                $numC3 = 1;
                                //echo "<div>";  
                                echo "<br>";                                                   
                                echo " <table border=1 class='table table-bordered'>";
                                echo "<tr>";
                                echo "<td>" . $row['Tit_cNameTH'] . "</td>";
                                echo "<td> 5 </td>";
                                echo "<td> 4 </td>";
                                echo "<td> 3 </td>";
                                echo "<td> 2 </td>";
                                echo "<td> 1 </td>";
                                echo "<td> แสดงความคิดเห็น</td>";
                                echo "<td> ลบ </td>";
                                echo "</tr>";                              
                               
                    }
                                                      
                                echo "<tr>";
                                echo "<td> ".$numC3.")".$row['Que_cNameTH'] . "  </td>";                               
                                $numC3++;
                                echo "<td>";
                                echo CHtml::radioButton('radio', false);
                                echo"</td>";
                                echo "<td>";
                                echo CHtml::radioButton('radio', false);
                                echo"</td>";
                                echo "<td>";
                                echo CHtml::radioButton('radio', false);
                                echo"</td>";
                                echo "<td>";
                                echo CHtml::radioButton('radio', false);
                                echo"</td>";
                                echo "<td>";
                                echo CHtml::radioButton('radio', false);
                                echo"</td>";
                                echo "<td>";
                                echo CHtml::textField('txt');
                                echo "</td>";                                
                                echo "<td><button type='button' id='del".$row['Que_nID']."' class='btn btn-primary'  value='".$row['Sna_nID']."' onclick='getTxt(".$row['Que_nID'].");'>DEL</button></td>";
                                echo "</tr>";        
                                                     
                                                               
                }//end Tan 3
                else{
                    if($close<1)
                    {
                              
                                echo "</table>";
                                echo "<br>";
                                $close++;
                    }

                }           
                     
                if($row['Tan_nID']==4)
                {
                                if($x<1)
                                {
                                    $num4=1;
                                    $x++    ;
                                }     
                                echo "<div>";
                                echo "<br>";
                                echo $num4.")".$row['Que_cNameTH'];
                                $num4++;
                                echo '&nbsp;';
                                echo CHtml::textField("txtshort");           
                                echo '&nbsp;';                 
                                echo "<button type='button' class='btn btn-primary' id='del".$row['Que_nID']."'  value='".$row['Sna_nID']."' onclick='getTxt(".$row['Que_nID'].");'>DEL</button>";
                                echo "<br>";
                                echo "</div>";
                }
                if($row['Tan_nID']==5)
                {
                                if($x<1)
                                {
                                    $num5=1;
                                    $x++    ;
                                }   
                                echo "<div>";                          
                                echo "<br>";
                                echo $num5.")".$row['Que_cNameTH'];
                                $num5++;
                                echo '&nbsp;';
                                echo CHtml::textarea("txtslong");   
                                echo '&nbsp;';                              
                                echo "<button type='button' class='btn btn-primary' id='del".$row['Que_nID']."'  value='".$row['Sna_nID']."' onclick='getTxt(".$row['Que_nID'].");'>DEL</button>";
                                echo "<br>";
                                echo "</div>";
                }
                

        
            
        
        


    }// end if 
}// end type
}// end while?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/jquery/jquery-1.11.3.min.js"); ?>

<script type="text/javascript">


var baseUrl = "../AddGroup/Preview";


function getTxt(question)
{
var r = confirm("Are you Sure!");
    if (r == true) {
       var Sna_nID = $('#del'+question).prop("value");
       var qID = question;
          jQuery.ajax({
                type: "POST",
                url: "../AddGroup/Delete",
                data: {Sna_nID: Sna_nID,Q_ID: qID},
                success: function (msg) {
                    //cosole.log('success');
                    alert('ลบคำถามเรียบร้อย');
                    location.reload();
                },
                error: function (xhr) {
                    alert("failure: " + xhr.readyState + this.url);

                }
            });




    } else {
        //alert('Cancle');
    }

 

}
</script>

<? echo CHtml::endForm();