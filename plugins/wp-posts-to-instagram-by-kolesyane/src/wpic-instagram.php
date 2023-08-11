<?php

class Wpic
{
	/**
	 * The API base URL.
	 */

	const API_URL = 'https://i.instagram.com/api/v1/';

	const API_LONG_DATE_API_HASH = '25eace5393646842f0d0c3fb2ac7d3cfa15c052436ee86b5406a8433f54d24a5';

	/**
	 *  Define the user agent
	 */
	const API_AGENT = 'Instagram 6.21.2 Android (19/4.4.2; 480dpi; 1152x1920; Meizu; MX4; mx4; mt6595; en_US)';

	private $login;

	private $pass;

	private $guid;

	private $device_id;

	private $caption;

	private $filename;

	private $login_response;

	/**
	 * Set the username and password of the account that you wish to post a photo to
	 */
	public function __construct($login, $pass, $caption, $filename)
	{
			$this->login    = $login;
			$this->pass     = $pass;
			$this->filename = $filename;
			$this->caption  = $caption;

			//Define the GuID
			$this->guid = $this->GenerateGuid();

			// Set the devide ID
			$this->device_id = "android-" . $this->guid;

			$data = '{"device_id":"' . $this->device_id.'","guid":"' . $this->guid.'","username":"' . $this->login . '","password":"' . $this->pass . '","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';

			$sig = $this->GenerateSignature($data);

			$data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=6';

			$this->login_response = $this->SendRequest('accounts/login/', true, $data, self::API_AGENT, false);

	}

	public function prepareSquareImage(){
		if (!@file_get_contents($this->filename)) {
			return false;
		}

		$image_sizes = getimagesize($this->filename);
		$basefilename = basename($this->filename);
		$basepath = wp_upload_dir();

		if ($image_sizes[0] > $image_sizes[1]) {
			$sqare_border = $image_sizes[1];
		}
		else {
			$sqare_border = $image_sizes[0];
		}
		if ($sqare_border > 500) {
			$sqare_border = 500;
		}

		//require WP > 3.5
		$image = wp_get_image_editor( $this->filename );

		if ( ! is_wp_error( $image ) ) {
			$image->resize( $sqare_border, $sqare_border, true );
			$new_img = $image->save( $basepath[path] . '/insta_' . $basefilename, 'jpg' );
			if ($new_img) {
				$this->filename = $new_img['path'];
				return true;
			}
			return false;
		}

		return false;

	}

	private function postPicture(){

		// Post the picture
		$data = $this->GetPostData($this->filename);
		$post = $this->SendRequest('media/upload/', true, $data, self::API_AGENT, true);

		return $post;
	}

	private function postCaption($media_id){

		// Remove and line breaks from the caption
		$caption = preg_replace("/\r|\n/", "", $this->caption);

		$data = '{"device_id":"' . $this->device_id . '","guid":"' . $this->guid . '","media_id":"' . $media_id . '","caption":"' . trim($caption) . '","device_timestamp":"' . time() . '","source_type":"5","filter_type":"0","extra":"{}","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
		$sig = $this->GenerateSignature($data);
		$new_data = 'signed_body=' . $sig . '.' . urlencode($data) . '&ig_sig_key_version=4';
		// Now, configure the photo
		$conf = $this->SendRequest('media/configure/', true, $new_data, self::API_AGENT, true);
		return $conf;
	}

	public function processPost(){
		$login = $this->login_response;

		if (strpos($login[1], "Sorry, an error occurred while processing this request.")) {
			add_option('wpic_error', __("Request failed, there's a chance that this proxy/ip is blocked",'wpic'));
			return false;
		}
		else {

			if (empty($login[1])) {
				add_option('wpic_error', __("Empty response received from the server while trying to login",'wpic'));
				return false;
			}
			else {

				// Decode the array that is returned
				$obj = @json_decode($login[1], true);
				if (empty($obj)) {
					add_option('wpic_error', __( "Could not decode the Instagram response",'wpic'));
					return false;
				}
				else {

					// Post the picture
					$post = $this->postPicture();

					if (empty($post[1])) {
						add_option('wpic_error', __( "Empty response received from the server while trying to post the image",'wpic'));
						return false;
					}
					else {

						// Decode the response
						$obj = @json_decode($post[1], true);
						if (empty($obj)) {
							add_option('wpic_error', __("Could not decode the Instagram response",'wpic'));
							return false;
						}
						else {

							$status = $obj['status'];

							if ($status == 'ok') {

								$conf = $this->postCaption($obj['media_id']);

								if (empty($conf[1])) {
									add_option('wpic_error', __( "Empty response received from the server while trying to configure the image",'wpic'));
									return false;
								}
								else {

									if (strpos($conf[1], "login_required")) {
										add_option('wpic_error', __("You are not logged in. There's a chance that the account is banned",'wpic'));
										return false;
									}
									else {
										$obj = @json_decode($conf[1], true);
										$status = $obj['status'];
										if ($status != 'fail') {
											add_option('wpic_success', __('Posted to Instagram','wpic'));
											return true;
										}
										else {
											add_option('wpic_error', __('Failed post to Instagram','wpic'));
											return false;
										}
									}
								}
							}
							else {
								add_option('wpic_error', __("Instagram response status error",'wpic'));
								return false;
							}
						}
					}
				}
			}
		}
	}

	public function SendRequest($url, $post, $post_data, $user_agent, $cookies) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_URL . $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		if($post) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}

		if($cookies) {
			curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
		} else {
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
		}

		$response = curl_exec($ch);
		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return array($http, $response);
	}

	private function GenerateGuid() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(16384, 20479),
			mt_rand(32768, 49151),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535));
	}

	private function GenerateSignature($data) {
		return hash_hmac('sha256', $data, self::API_LONG_DATE_API_HASH);
	}

	private function GetPostData($filename) {
		if(!$filename) {
			echo "The image doesn't exist: ".$filename;

		} else {

			$post_data = array('device_timestamp' => time(),
				'photo' => new CURLFile($filename));

			return $post_data;
		}
	}
}
?>