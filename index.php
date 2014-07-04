<?php
/*
todo:
error output on checks
error checks for slideshow with images
*/

$dir = "img/"; //directory of images

//upload image
if(isset($_FILES['fileToUpload'])) {
	$image = getimagesize($_FILES['fileToUpload']['tmp_name']);
	$imageTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP);
	
	//check image type, size and error
	if(in_array($image[2], $imageTypes) && $_FILES['fileToUpload']['size'] < 150000 && $_FILES['fileToUpload']['error'] == 0){
		//if the same file doesnt already exist
		if(!file_exists($dir.$_FILES['fileToUpload']['name'])){
			//move temp file to image directory
			move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $dir.$_FILES['fileToUpload']['name']);
		}
	}
}

//delete image
if(isset($_POST['fileToDelete'])) {
	unlink($_POST['fileToDelete']);
}

//put images from image directory into array
$myFileArray = array();
if ($handle = opendir($dir)) {  
    while (false !== ($file = readdir($handle))) 
	{   
		//check that file is an image
		$image = getimagesize($dir.$file);
		$imageTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP);
		if(in_array($image[2], $imageTypes))
		{
			//place image into array
			$myFileArray[] = $dir.$file;
        }   
    }  
    closedir($handle);   
}
?>

<head>
	<link rel="stylesheet" href="css/style.css">
	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
		$(function(){
			$('.slideshow div:gt(0)').hide();
			setInterval(function(){
				$('.slideshow div:first').fadeOut().next().fadeIn().end().appendTo('.slideshow');
			}, 2000);
		});
	</script>
</head>
<body>
<div class="container">
	<div class="slideshow">
	<?php for($i = 0; $i < count($myFileArray); $i++){ ?>
		<div><img src="<?=$myFileArray[$i]?>"/></div>
	<? } ?>
	</div>

	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
		<input type="file" name="fileToUpload"/><br/>
		<input type="submit" name="submit" value="Upload">
	</form>
	
	<div class="display">
	<?php for($i = 0; $i < count($myFileArray); $i++){ ?>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<img src="<?=$myFileArray[$i]?>"> 
			<input type="hidden" name="fileToDelete" value="<?=$myFileArray[$i]?>">
			<input type="submit" value="X">
		</form>
	<? } ?>
	</div>
</div>
</body>