
 <section class="content">
<form action="<?= $this->createUrl('site/UploadFile') ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
</form>
</section>
