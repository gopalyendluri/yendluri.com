<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sucharitha
 * Date: 30/06/2014
 * Time: 07:00
 * To change this template use File | Settings | File Templates.
 */
namespace SOAPClientTest;
class SOAPClientTest
{
static private $AuthURL = '';
static private $WSDL='';
static private $AUTH_USERNAME = '';
static private $AUTH_PASSWORD = '';
private $client;

    public function __construct()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        $options = array();
        //$options['connection-timeout']=300;
       // $options['location']= self::$WSDL;
        //$options['trace']=true;

        try{
            $this->client= new \SoapClient(self::$WSDL);
            $this->setSoapHeader();

          }catch (\SoapFault $fault)
        {
            print_r($fault);
        }

    }

    public function setSoapHeader()
    {
     try{
         $authentication=array(
             "WSUserName"=>self::$AUTH_USERNAME,
             "WSPassword"=>self::$AUTH_PASSWORD);

         $header=new \SoapHeader(self::$AuthURL, 'AuthenticationSoapHeader',$authentication,false);
         $this->client->__setSoapHeaders($header);
     }catch(\SoapFault $fault)
     {
         print_r($fault);

     }
    }

    public function ping()
    {
        $request = array(
            'OTA_PingRQ'=>array(
                'EchoData'=>'Test data'
            )
        );
        //var_dump($this->client->__getFunctions());
        $response=$this->client->Ping($request);
        return $response;
    }

}
$testClient=new SOAPClientTest();
print "<pre>";
var_dump($testClient->ping());