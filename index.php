<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sucharitha
 * Date: 30/06/2014
 * Time: 06:22
 * To change this template use File | Settings | File Templates.
 */

include_once 'SOAPConnector.php';

$AmadeusClient = new SOAPConnector();
var_dump($AmadeusClient->ping());

