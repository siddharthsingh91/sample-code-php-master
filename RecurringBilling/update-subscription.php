<?php
  require 'vendor/autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  define("AUTHORIZENET_LOG_FILE", "phplog");
  
  // Common Set Up for API Credentials
  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
  $merchantAuthentication->setName( "556KThWQ6vf2"); 
  $merchantAuthentication->setTransactionKey("9ac2932kQ7kN2Wzq");

  $refId = 'ref' . time();

  $subscription = new AnetAPI\ARBSubscriptionType();

  $creditCard = new AnetAPI\CreditCardType();
  $creditCard->setCardNumber("4111111111111111");
  $creditCard->setExpirationDate("2020-12");

  $payment = new AnetAPI\PaymentType();
  $payment->setCreditCard($creditCard);

  $subscription->setPayment($payment);

  $request = new AnetAPI\ARBUpdateSubscriptionRequest();
  $request->setMerchantAuthentication($merchantAuthentication);
  $request->setRefId($refId);
  $request->setSubscriptionId("100748");
  $request->setSubscription($subscription);

  $controller = new AnetController\ARBUpdateSubscriptionController($request);

  $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
  
  if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
  {
      echo "SUCCESS" . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";
   }
  else
  {
      echo "ERROR :  Invalid response\n";
      echo "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";   
  }
  ?>
