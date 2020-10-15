<?php

use App\GrapElement;
use App\GrapRequestCurl;

include_once 'vendor/autoload.php';
 
$website = 'https://www.website.com/';

$grapRequest = new GrapRequestCurl();
$grapElement = new GrapElement($website, "#href=\"(.*)\"#iU", $grapRequest);
$messages = $grapElement->execute()->getMessages();
