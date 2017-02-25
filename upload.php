<?php

$target_dir = '../uploads/'+$_POST['name']+'/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$upload_ok = 1;
$file_type = pathinfo($target_file, PATHINFO_EXTENSION);

if(file_exists($target_file)) {
	echo 'File already exists!';
	$upload_ok=0;
}

/*if($_FILES['file']['size']>500000)
{
	echo 'File size is too large';
	$upload_ok = 0;
}*/

if($file_type!='pdf'){
	echo 'Sorry, only pdf files are allowed';
	$upload_ok = 0;
}

if($upload_ok != 0){
	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
		echo 'Your file '. basename($_FILES["file"]["name"]).' has been saved.';
	}
	else{
	echo "There was an error handling your file.";
}
}
else{
	echo "There was an error handling your file.";
}

require_once('../techexpo/PHPMailer-master/class.phpmailer.php');

$email = new PHPMailer();
$email->From      = $_POST['email'];
$email->FromName  = $_POST['name'];
$email->Subject   = 'Team detail submission[NEW]';
$email->Body      = $_POST['message']+'<br>'+$_POST['select'];
$email->AddAddress( 'er.mayank96@gmail.com' );

$file_to_attach = $target_file;

$email->AddAttachment( $file_to_attach , $_POST['name']+'.pdf' );

return $email->Send();

?>