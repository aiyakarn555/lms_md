<?php
class MyWebApplication extends CWebApplication {
    
    // return string '/blc/upload/news/' (length=17)
    public $folderUpload = "uploads";

    public function getUploadUrl($module) {
        if($module == null)
            $module = $this->controller->id;
    	$path = "";
    	$baseUrl = $this->baseUrl."/".$this->folderUpload."/";
        $path = $baseUrl.$module."/";
        return $path;
    }

    public function getDeleteImageYush($model,$id,$image) 
    {   
        $originalPath = Yii::app()->getUploadPath($model).$id."\\".Yush::SIZE_ORIGINAL."\\".$image;
        $largePath    = Yii::app()->getUploadPath($model).$id."\\".Yush::SIZE_LARGE."\\".$image;
        $smallPath    = Yii::app()->getUploadPath($model).$id."\\".Yush::SIZE_SMALL."\\".$image;
        $thumbPath    = Yii::app()->getUploadPath($model).$id."\\".Yush::SIZE_THUMB."\\".$image;

        if(file_exists($originalPath)){ unlink($originalPath); }
        if(file_exists($largePath)){ unlink($largePath); }
        if(file_exists($smallPath)){ unlink($smallPath); }
        if(file_exists($thumbPath)){ unlink($thumbPath);}

        return true;
    }

    // return string 'D:\Dropbox\blc\protected\upload\news\' (length=37)
    public function getUploadPath($module) {
        if($module == null)
            $module = $this->controller->id;
        $path = "";
        $basePath = $this->basePath."\\..\\".$this->folderUpload."\\";
        $path = $basePath.$module."\\";
        return $path;
    }

    public function checkShowImage($module,$fileName,$prefix="thumb-",$width=null,$height=null) {
        if($module == null)
            $module = $this->controller->id;

        if($width == null){
            if($prefix == "thumb-"){
                $width = $this->params['IMAGE_SIZE']['THUMB']['WIDTH'];
            }else{
                $width = $this->params['IMAGE_SIZE']['FULL']['WIDTH'];
            }
        }

        if($height == null){
            if($prefix == "thumb-"){
                $height = $this->params['IMAGE_SIZE']['THUMB']['HEIGHT'];
            }else{
                $height = $this->params['IMAGE_SIZE']['FULL']['HEIGHT'];
            }
        }

        $fileFullPath = $this->getUploadPath($module).$prefix.$fileName;
        $fileFullUrl = $this->getUploadUrl($module).$prefix.$fileName;
        $fileNoImage = "http://placehold.it/".$width."x".$height;

        if(is_file($fileFullPath))
            return $fileFullUrl;
        else
            return $fileNoImage;
    }

    // Upload Image
    public function uploadImage($model,$nameHtml) {

        $time = date("dmYHis");
        $uploadedFile = CUploadedFile::getInstance($model,$nameHtml);

        if($uploadedFile){
            $fileName = $time.".".$uploadedFile->getExtensionName();
            return $fileName;
        }else{
            return false;
        }        
    }

    // Save Upload Image
    public function uploadImageSave($module,$uploadedFile,$fileName,$oldImage = "") {
        if($module == null)
            $module = $this->controller->id;

        if($uploadedFile){
            $uploadFolder = $this->getUploadPath($module);
            $uploadedFile->saveAs($uploadFolder.$fileName);  // image will uplode to rootDirectory/banner/
            $thumb=$this->phpThumb->create($uploadFolder.$fileName);

            $thumb->adaptiveResize($this->params['IMAGE_SIZE']['UPLOADFILE']['WIDTH'],$this->params['IMAGE_SIZE']['UPLOADFILE']['HEIGHT']);
            $thumb->save($uploadFolder."full-".$fileName);
            $thumb->adaptiveResize($this->params['IMAGE_SIZE']['THUMB']['WIDTH'],$this->params['IMAGE_SIZE']['THUMB']['HEIGHT']);
            $thumb->save($uploadFolder."thumb-".$fileName);
            
            unlink($uploadFolder.$fileName);
            if($oldImage != ""){
                $this->deleteImage($module,$oldImage);
            }
        }   
    }

    // Delete File
    public function deleteImage($module,$img)
    {
        if($module == null)
            $module = $this->controller->id;

        $srcFileThumb = $this->getUploadPath($module)."thumb-".$img;
        $srcFileFull = $this->getUploadPath($module)."full-".$img;
        if(file_exists($srcFileThumb) && file_exists($srcFileFull)){
            unlink($srcFileThumb);
            unlink($srcFileFull);
            return true;
        }else{
            return false;
        }
    }
    
}