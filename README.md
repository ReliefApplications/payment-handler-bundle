# Relief Applications Payment Handler

This package is here to help you for the payments on Relief Applications' applications.

## Installation

To install this package, just run :
```
composer req relief_applications/payment-handler-bundle
```
This will install the package into your vendors.

## Usage

To use this package, create a method in a controller that will handle the request from the payment server.
Then simply call the method :
```
$payload = SuccessfulPaymentHandler::getPayload($request);
```
This will verify that the data are coming from the payment server and will decrypt it so you can use the payload that was passed by the front of the application as an array.