<?php
namespace App\Model;

use Cake\Core\Configure;

class Facebook extends \Facebook\Facebook
{

	public function __construct(array $config = [])
    {
	    
	    return parent::__construct( Configure::read('Facebook') );
	    
    }
    
    public function getLoginUrl( $next = false )
    {
	    
	    $helper = $this->getRedirectLoginHelper();
		$permissions = ['email'];
		
		$callback = Configure::read('Portal.url') . '/users/facebook_callback';
		if( $next )
			$callback .= '?' . http_build_query([
				'next' => $next
			]);
					
		return $helper->getLoginUrl($callback, $permissions);
	    
    }
    
    public function loginCallback()
    {
	    
	    $helper = $this->getRedirectLoginHelper();
		
		try {

			$accessToken = $helper->getAccessToken();

		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
			return [
				'code' => 500,
				'msg' => 'Graph returned an error: ' . $e->getMessage(),
			];
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
			return [
				'code' => 500,
				'msg' => 'Facebook SDK returned an error: ' . $e->getMessage(),
			];
		}
		
		if (! isset($accessToken)) {
			if ($helper->getError()) {
				return [
					'code' => 401,
					'msg' => $helper->getError(),
					'error_code' => $helper->getErrorCode(),
					'get_error_reason' => $helper->getErrorReason(),
					'get_error_description' => $helper->getErrorDescription(),
				];
			} else {
				return [
					'code' => 400,
					'msg' => 'Bad Request',
				];
			}
		}
		
		$oAuth2Client = $this->getOAuth2Client();
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);	
		$tokenMetadata->validateAppId( Configure::read('Facebook.app_id') ); // Replace {app-id} with your app id
		$tokenMetadata->validateExpiration();
		
		if (! $accessToken->isLongLived()) {
			try {
			
				$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
				
			} catch (\Facebook\Exceptions\FacebookSDKException $e) {
				return [
					'code' => 500,
					'msg' => 'Error getting long-lived access token: ' . $helper->getMessage(),
				];
			}			
		}
		
		try {

			$response = $this->get('/me?fields=id,email,name,first_name,last_name,age_range,gender', $accessToken);

		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
			return [
				'code' => 500,
				'msg' => 'Graph returned an error: ' . $e->getMessage(),
			];
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
			return [
				'code' => 500,
				'msg' => 'Facebook SDK returned an error: ' . $e->getMessage(),
			];
		}
				
		return [
			'code' => 200,
			'access_token' => $accessToken,
			'user' => $response->getGraphUser(),
		];
	    
    }

}