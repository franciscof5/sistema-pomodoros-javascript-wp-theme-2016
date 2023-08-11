<?php
require_once (dirname(__FILE__) . "/vendor-old/autoload.php");
function instamatic_new_login($user, $pass, $proxy)
{
		\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
		$igp = new \InstagramAPI\Instagram(false, true, [
    		'storage' 	 => 'mysql',
    		'dbhost'     => DB_HOST,
			'dbname'     => DB_NAME,
			'dbusername' => DB_USER,
			'dbpassword' => DB_PASSWORD,
		]);
		
		try {
		    if ( $proxy != "" )
            {
		    	$igp->setProxy($proxy);
            }
			$loginResponse = $igp->login($user, $pass);
			if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) {
        		$twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();
        		update_option( 'instamatic_twoFactorIdentifier', $twoFactorIdentifier );
        		return array('success' => 2, 'igp' => $igp );

        	} else {
				return array('success' => 1, 'igp' => $igp );
        	}
		} catch (\Exception $e) {
			instamatic_log_to_file('Failed to log in to Instagram (new method) ' . $e->getMessage());
			return array('success' => 0, 'igp' => $igp);
		}
}

function instamatic_ig_post($igp, $photoFilename, $message)
{
    try
    {
		$photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
    	$igp->timeline->uploadPhoto($photo->getFile(), ['caption' => $message]);
    }
    catch (\Exception $e) {
        instamatic_log_to_file('Failed to post to Instagram (new method) ' . $e->getMessage());
		return false;
    }
}
function instamatic_submit_verification_code($verificationCode, $instaUsername, $instaPassword) {
			\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
	        $igpt = new \InstagramAPI\Instagram(false, false, [
	    		'storage' 	 => 'mysql',
	    		'dbhost'     => DB_HOST,
				'dbname'     => DB_NAME,
				'dbusername' => DB_USER,
				'dbpassword' => DB_PASSWORD,
			]);
	        $twoFactorIdentifier = get_option( 'instamatic_twoFactorIdentifier' );
    	    $igpt->finishTwoFactorLogin($instaUsername, $instaPassword, $twoFactorIdentifier, $verificationCode);
}
?>