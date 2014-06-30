<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sucharitha
 * Date: 30/06/2014
 * Time: 05:48
 * To change this template use File | Settings | File Templates.
 */

namespace SOAPConnector;

use SoapClient;
use SoapFault;
use SoapHeader;

class SOAPConnector {
    static private $AuthURL = '';
    static private $WSDL = '';
    static private $AUTH_USERNAME = '';
    static private $AUTH_PASSWORD = '';
    private $client;

    public function __construct(){
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        $options = array();

        $options["connection_timeout"] = 300;
        $options["location"] = self::$WSDL;//WSDL URL
        $options['trace'] = true;
        try {
            $this->client = new SoapClient(self::$WSDL, $options);
            $this->setSOAPHeader();


        } catch (SoapFault $fault) {
            trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
        }

    }


    private function setSOAPHeader(){
        try {
           $auth = array(
               'WSUserName' => self::$AUTH_USERNAME,
               'WSPassword' => self::$AUTH_PASSWORD,
           );

           $header =  new SoapHeader(self::$AuthURL, 'AuthenticationSoapHeader', $auth, false);

            $this->client->__setSoapHeaders($header);
        }
        catch (SoapFault $fault) {
           throw $fault;
        }
    }


    public function ping(){
        try {
            $request = array(
                'OTA_PingRQ' => array(
                    'EchoData' => 'I am testing you for Da-Travel'
                )
            );
            var_dump($this->client->__getFunctions());
            $response =  $this->client->Ping($request);
            return (array)$response->OTA_PingRS;
        }
        catch (SoapFault $fault) {
            throw $fault;
        }

    }

    public function currency(){

        $request = array(
            'OTA_CurrencyConversionRQ' => array(
                'FromCurrency' => 'EUR',
                'ToCurrency' => 'GBP',
                'Amount' => '120'
            )
        );



        $response =  $this->client->CurrencyConversion($request);

       // var_dump($this->client->__getLastRequest());
       // var_dump($this->client->__getLastResponse());
        return $response;

    }


}


$AmadeusClient = new SOAPConnector();
print '<pre>';

var_dump($AmadeusClient->ping());
var_dump($AmadeusClient->currency());


