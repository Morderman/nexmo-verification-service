# Nexmo verification service

Service, that provides phone number verification with the help of Nexmo client.
More about Nexmo client can be found here: https://www.nexmo.com.

## Installation

Install the service package with the help of composer - edit your `composer.json` to require the package.

```json
"require": {
    "Morderman/nexmo-verification-service": "1.0.*"
}
```
Run `composer update` in your terminal to install it.

OR

Run `composer require Morderman/nexmo-verification-service`

Install Nexmo client package.

```
composer require nexmo/client
```

Register the service provider. Open `config\app.php` and find the `providers` key.
```
'providers' => [
    ...
    App\Providers\NexmoVerificationProvider::class,
    ...
]
```
## Usage

1. Use the POST `/verification/request` to send the verification code to mobile device. 
In request parameters specify the `number` value. Don't forget to remember the `request_id` value that will come in response, as it is needed for further verification.
2. Use the POST `verification/verify` to verify the code. In request parameters specify the received on your mobile device verification `code` and previously obtained `request_id`.

Whenever you want to use Nexmo verification object, add `use App\Library\Services\NexmoVerification;`.

Include your Nexmo account API key here:

```
$basic  = new \Nexmo\Client\Credentials\Basic(NEXMO_API_KEY, NEXMO_API_SECRET);
```
