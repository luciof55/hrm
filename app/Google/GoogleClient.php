<?php
namespace App\Google;

use Google_Client;
use Drive;
use Google_Service_Drive;
use App\Google\Exceptions\UnknownServiceException;
use Illuminate\Support\Facades\Log;

class GoogleClient
{
    /**
     * @var array
     */
    protected $config;
    /**
     * @var \Google_Client
     */
    protected $client;
    /**
     * @param array $config
     * @param string $userEmail
     */
    public function __construct(array $config, $userEmail = '')
    {
		Log::debug('GoogleClient - __construct');
        $this->config = $config;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName(array_get($config, 'application_name', ''));
		$this->client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
		$this->client->setAuthConfig(__DIR__.'\..\..\key\client_secret.json');
		$this->client->setAccessType(array_get($this->config, 'access_type', 'offline'));
		$this->client->setIncludeGrantedScopes(true);
		$app_path = array_get($config, 'app_path', '');
		if ($app_path != '') {
			$app_path = '/'. $app_path .'/';
		}
		Log::debug('RedirectUri: '. 'http://' . $_SERVER['HTTP_HOST'] . $app_path . $this->getAuthorizeCallback());
		$this->client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . $app_path . $this->getAuthorizeCallback());
		
		Log::debug('GoogleClient - __construct END');
    }
	
	public function getAuthorizeCallback() {
		return array_get($this->config, 'authorize_callback', '');
	}
	
	public function getAuthorizeInit() {
		return array_get($this->config, 'authorize_init', '');
	}
    
	public function getConfig() {
		return $this->config;
	}
	
	public function generateAccessToken($userName) {
		// Load previously authorized credentials from a file.
		
		$fileName = $this->getFileName($userName);
		$credentialsPath = $this->expandHomeDirectory($fileName);
		
		if (file_exists($credentialsPath)) {
			$accessToken = json_decode(file_get_contents($credentialsPath), true);
			$this->client->setAccessToken($accessToken);

			// Refresh the token if it's expired.
			if ($this->client->isAccessTokenExpired()) {
				// $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
				// file_put_contents($credentialsPath, json_encode($this->client->getAccessToken()));
				$this->revokeToken($userName);
				return null;
			}
			return $accessToken;
		} else {
			return null;
		}
		
	}
	
	public function getAuthUrl() {
		$authUrl = $this->client->createAuthUrl();
		Log::info("authUrl: ". $authUrl);
		return $authUrl;
	}
	
	public function setAuthCode($authCode, $userName) {
		// Exchange authorization code for an access token.
		$accessToken = $this->client->authenticate($authCode);
		$this->client->setAccessToken($accessToken);
		// Store the credentials to disk.
		$fileName = $this->getFileName($userName);
		$credentialsPath = $this->expandHomeDirectory($fileName);
		if (!file_exists(dirname($credentialsPath))) {
			mkdir(dirname($credentialsPath), 0700, true);
		}
		file_put_contents($credentialsPath, json_encode($accessToken));
		Log::info("Credentials saved to: ". $credentialsPath);
	}
	
	public function revokeToken($userName) {
		Log::info($this->client->getAccessToken()['access_token']);
		//$this->client->revokeToken();
		try {
			$credentialsPath = $this->expandHomeDirectory($this->getFileName($userName));
			if (file_exists($credentialsPath)) {
				unlink($credentialsPath);
			}
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
     * Getter for the google client.
     *
     * @return \Google_Client
     */
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * Setter for the google client.
     *
     * @param string $client
     *
     * @return self
     */
    public function setClient(Google_Client $client)
    {
        $this->client = $client;
        
        return $this;
    }
    /**
     * Getter for the google service.
     *
     * @param string $service
     *
     * @throws \Exception
     *
     * @return \Google_Service
     */
    public function make($service)
    {
        $service = 'Google_Service_'.ucfirst($service);
		Log::info('GoogleClient - make: '.$service);
        if (class_exists($service)) {
            $class = new \ReflectionClass($service);
			Log::info('GoogleClient - make - clase encontrada');
            return $class->newInstance($this->client);
        } else {
			Log::info('GoogleClient - make - No se creó');
		}
        throw new UnknownServiceException($service);
    }
	
	/**
	 * Expands the home directory alias '~' to the full path.
	 * @param string $path the path to expand.
	 * @return string the expanded path.
	 */
	function expandHomeDirectory($path)
	{
		$homeDirectory = getenv('HOME');
		if (empty($homeDirectory)) {
			$homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
		}
		return str_replace('~', realpath($homeDirectory), $path);
	}
	
	protected function getFileName($userName) {
		if (isset($userName)) {
			return $userName.'_credentials.json';
		} else {
			return 'credentials.json';
		}
	}
	
    /**
     * Setup correct auth method based on type.
     *
     * @param $userEmail
     * @return void
     */
    protected function auth($userEmail = '')
    {
        // see (and use) if user has set Credentials
        if ($this->useAssertCredentials($userEmail)) {
            return;
        }
        // fallback to compute engine or app engine
        $this->client->useApplicationDefaultCredentials();
    }
    /**
     * Determine and use credentials if user has set them.
     * @param $userEmail
     * @return bool used or not
     */
    protected function useAssertCredentials($userEmail = '')
    {
        $serviceJsonUrl = array_get($this->config, 'service.file', '');
        if (empty($serviceJsonUrl)) {
            return false;
        }
        $this->client->setAuthConfig($serviceJsonUrl);
        
        if (! empty($userEmail)) {
            $this->client->setSubject($userEmail);
        }
        return true;
    }
    /**
     * Magic call method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->client, $method)) {
            return call_user_func_array([$this->client, $method], $parameters);
        }
        throw new \BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }
}