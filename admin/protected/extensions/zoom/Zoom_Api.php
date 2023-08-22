<?php 
/* 
| Developed by: Tauseef Ahmad
| Last Upate: 01-19-2021 08:45 PM
| Facebook: www.facebook.com/ahmadlogs
| Twitter: www.twitter.com/ahmadlogs
| YouTube: https://www.youtube.com/channel/UCOXYfOHgu-C-UfGyDcu5sYw/
| Blog: https://ahmadlogs.wordpress.com/
 */ 
 
//Include Firebase Library and Dependencies
require_once 'php-jwt-master/src/BeforeValidException.php';
require_once 'php-jwt-master/src/ExpiredException.php';
require_once 'php-jwt-master/src/SignatureInvalidException.php';
require_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


class Zoom_Api
{
	// private $zoom_api_key = '0Og0k_oLSWabGGXiUSwWqA';
	// private $zoom_api_secret = '4tPoLMB84CizhhRNa6CaljrsZeAefkr5Ez2G';
	//MD
	private $zoom_api_key = 'qzifLljFQDKeCny5pKF79w';
	private $zoom_api_secret = 'I1SYtF0Szvn6Ez62YNAboxoYHDg1EoykhTOT';	
	
	//function to generate JWT
	private function generateJWTKey() {
		$key = $this->zoom_api_key;
		$secret = $this->zoom_api_secret;
		$token = array(
			"iss" => $key,
			"exp" => time() + 3600 //60 seconds as suggested
		);
		return JWT::encode( $token, $secret );
	}	
	
	//function to create meeting
    	public function createMeeting($data = array(),$host)
    	{
		$post_time  = $data['start_date'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));
		$dateStart = date_format(date_create($post_time), "Y-m-d");
		$timestr = date_format(date_create($post_time), "H:i");

		$start_time = $dateStart.' '.$timestr.':00.000000';

		$to_end_time  = $data['end_date'];
		// $end_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time2));
		$dateEnd = date_format(date_create($to_end_time), "Y-m-d");
		$timeEndstr = date_format(date_create($to_end_time), "H:i");

		$end_time = $dateEnd.' '.$timeEndstr.':00.000000';

		$diff_date  = date_diff(date_create($post_time),date_create($to_end_time));
		$num_date = (int)$diff_date->format("%a");
		if($num_date == 0){
			$num_date = 1;
		}

		$createMeetingArray = array();
		if (!empty($data['alternative_host_ids'])) {
		    if (count($data['alternative_host_ids']) > 1) {
			$alternative_host_ids = implode(",", $data['alternative_host_ids']);
		    } else {
			$alternative_host_ids = $data['alternative_host_ids'][0];
		    }
		}
		// $alternative_host_ids = $cohost;
		$createMeetingArray['topic']      = $data['topic'];
		$createMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
		$createMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
		$createMeetingArray['start_time'] = $start_time;
		$createMeetingArray['timezone']   = 'Asia/Tashkent';
		$createMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
		$createMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;
		$createMeetingArray["recurrence"] = array(
			"end_date_time"=> $end_time,
			"end_times"=> $num_date,
			// "monthly_day"=> 1,
			// "monthly_week"=> 1,
			// "monthly_week_day"=> 1,
			"repeat_interval"=> 1,
			"type"=> 1,
			// "weekly_days"=> "1"
		);

		$createMeetingArray['settings']   = array(
            		'join_before_host'  => !empty($data['join_before_host']) ? true : true,
            		'host_video'        => !empty($data['option_host_video']) ? true : false,
            		'participant_video' => !empty($data['option_participants_video']) ? true : false,
            		'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
            		'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
            		'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            		'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        	);


		return $this->sendRequest($createMeetingArray,$host);
	}	
	
	//function to send request
    	protected function sendRequest($data,$host)
    	{
		//Enter_Your_Email
		// $request_url = "https://api.zoom.us/v2/users/peeblack366@gmail.com/meetings";
    	$request_url = "https://api.zoom.us/v2/users/".$host."/meetings";
		
		$headers = array(
			"authorization: Bearer ".$this->generateJWTKey(),
			"content-type: application/json",
			"Accept: application/json",
		);
		
		$postFields = json_encode($data);
		
        	$ch = curl_init();
        	curl_setopt_array($ch, array(
            	CURLOPT_URL => $request_url,
	    	CURLOPT_RETURNTRANSFER => true,
	    	CURLOPT_ENCODING => "",
	    	CURLOPT_MAXREDIRS => 10,
	    	CURLOPT_TIMEOUT => 30,
	    	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    	CURLOPT_CUSTOMREQUEST => "POST",
	    	CURLOPT_POSTFIELDS => $postFields,
	    	CURLOPT_HTTPHEADER => $headers,
        	));

        	$response = curl_exec($ch);
        	$err = curl_error($ch);
        	curl_close($ch);
        	if (!$response) {
            		return $err;
		}
        	return json_decode($response);
	}
}

