<?php
return [
	'app_path' => env('APP_PATH', ''),
	/*
	|----------------------------------------------------------------------------
    | authorizeCallback & authorizeInit URL
    |----------------------------------------------------------------------------
	*/
	'authorize_callback' => 'security/authorizeCallback',
	'authorize_init' => 'security/authorizeInit',
    /*
    |----------------------------------------------------------------------------
    | Google application name
    |----------------------------------------------------------------------------
    */
    'application_name' => env('GOOGLE_APPLICATION_NAME', 'Upsales'),
    /*
    |----------------------------------------------------------------------------
    | Google OAuth 2.0 access
    |----------------------------------------------------------------------------
    |
    | Keys for OAuth 2.0 access, see the API console at
    | https://developers.google.com/console
    |
    */
    'client_id'       => env('GOOGLE_CLIENT_ID', '691580593706-1524tukmh9gilu4f91dthl1itkn875ll.apps.googleusercontent.com'),
    'client_secret'   => env('GOOGLE_CLIENT_SECRET', '6BIpCD1XF9EZI5kCV0pU5c4m'),
	'project_id'      => env('GOOGLE_PROJECT_ID', 'upsales-202722'),
    'redirect_uri'    => env('GOOGLE_REDIRECT', ''),
    'scopes'          => [],
    'access_type'     => 'offline',
    'approval_prompt' => 'auto',
    /*
    |----------------------------------------------------------------------------
    | Google developer key
    |----------------------------------------------------------------------------
    |
    | Simple API access key, also from the API console. Ensure you get
    | a Server key, and not a Browser key.
    |
    */
    'developer_key' => env('GOOGLE_DEVELOPER_KEY', 'AIzaSyALsRR7scgUxaPP-TVcnPgOVMa2zNeVWko'),
    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Set the credentials JSON's location to use assert credentials, otherwise
    | app engine or compute engine will be used.
    |
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => env('GOOGLE_SERVICE_ENABLED', false),
        /*
        | Path to service account json file
        */
        'file' => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', '')
    ],
    /*
    |----------------------------------------------------------------------------
    | Additional config for the Google Client
    |----------------------------------------------------------------------------
    |
    | Set any additional config variables supported by the Google Client
    | Details can be found here: 
    | https://github.com/google/google-api-php-client/blob/master/src/Google/Client.php
    | 
    | NOTE: If client id is specified here, it will get over written by the one above.
    |
    */
    'config' => [],
];