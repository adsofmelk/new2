<?php

use Aws\Laravel\AwsServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. The minimum
    | required options are declared here, but the full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */

    'region' => env('AWS_REGION', 'us-east-1'),
    'version' => 'latest',
	//'debug'   => true,
	//'stats'   => true,
    'ua_append' => [
        'L5MOD/' . AwsServiceProvider::VERSION,
    ],
	'credentials' => [
			'key'    => 'AKIAIOR4WKDUN7LDNFKQ',
			'secret' => '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'
	],
];

/*
	
	require './vendor/autoload.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

$params = array(
    'credentials' => array(
        'key' => 'YOUR_KEY_HERE',
        'secret' => 'YOUR_SECRET_HERE',
    ),
    'region' => 'us-east-1', // < your aws from SNS Topic region
    'version' => 'latest'
);
$sns = new \Aws\Sns\SnsClient($params);

$args = array(
    "SenderID" => "SenderName",
    "SMSType" => "Transational",
    "Message" => "Hello World! Visit www.tiagogouvea.com.br!",
    "PhoneNumber" => "FULL_PHONE_NUMBER"
);

$result = $sns->publish($args);
echo "<pre>";
var_dump($result);
echo "</pre>";
	
	*/