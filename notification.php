<?php

//database connection
$db_name = "id2084390_event";
$mysql_username = "id2084390_event";
$mysql_password = "ashish123";
$server_name = "localhost";
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password, $db_name);

$message = $_POST["message"];
$title = $_POST["title"];
$picture = $_POST["picture"];
$path_to_fcm = "https://fcm.googleapis.com/fcm/send";
$server_key = 
"AAAAscwS1Gg:APA91bEghRl4q8_ZUnJoYFFApYxKA3RgksKvW_7vjxN7naxu9-gCW9XdvsxCxPEcmb-SrMIbqTMGGoOTtWLG-KdGpk5tysQfp6QNt5P8AD7rsgLqYD7khIGi7N72aWK_M4Sc8GSWn43y";

$headers = array(
			"Authorization:key=" .$server_key,
			"Content-Type:application/json"
			);

$curl_session = curl_init();
	curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
	curl_setopt($curl_session, CURLOPT_POST, true);
	curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);    //Check its usage
	curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);     //Check its usage

$query = "select fcm_token from fcm_info";
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_array($result)){
		
	$fields = array(
			"to"=>$row["fcm_token"],
			"data"=>array("title"=>$title,"message"=>$message,"picture"=>$picture)
				    );
	
	$details = json_encode($fields);
	curl_setopt($curl_session, CURLOPT_POSTFIELDS, $details);
	$result_curl = curl_exec($curl_session);
}
curl_close($curl_session);
mysqli_close($conn);
echo "success";
?>