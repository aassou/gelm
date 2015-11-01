<?php 
function imageProcessing($source, $path){
	$image="";
	if(isset($source) && $source['error']==0){
		if($source['size']<=10000000000){
			$extensionsAutorise = array('png', 'gif', 'jpeg', 'jpg', 'PNG', 'JPG', 'JPEG', 'GIF', 'PDF', 'pdf');
			$infosFichier = pathinfo($source['name']);
			$extensionUpload = $infosFichier['extension'];
			if(in_array($extensionUpload, $extensionsAutorise)){
				$nameUpload = basename($source['name']);
				$nameUpload = uniqid().$nameUpload;
				move_uploaded_file($source['tmp_name'], '..'.$path.$nameUpload);
				$image = '../GELM'.$path.$nameUpload;
			}
		}
	}
	return $image;
}
?>