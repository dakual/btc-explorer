<?php
namespace App;

require_once('../vendor/autoload.php');

use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;

$bitcoinECDSA = new BitcoinECDSA();
$bitcoinECDSA->setNetworkPrefix('6f');
// $bitcoinECDSA->generateRandomPrivateKey();
$bitcoinECDSA->setPrivateKey("ad0ef5b050953cea3379f4eb8a8fdc65d47207f54d2989e23f6c75db1039e87c");
$private = $bitcoinECDSA->getPrivateKey();
$wif = $bitcoinECDSA->getWif();
$address = $bitcoinECDSA->getAddress();
$address = $bitcoinECDSA->getAddress();
$getP2SHAddress = $bitcoinECDSA->getP2SHAddress();
$getUncompressedP2SHAddress = $bitcoinECDSA->getUncompressedP2SHAddress();
$getPubKey = $bitcoinECDSA->getPubKey();
$getUncompressedPubKey = $bitcoinECDSA->getUncompressedPubKey();
echo "Address: " . $address . PHP_EOL . "<br>";
echo "PrivateKey: " . $private . PHP_EOL . "<br>";
echo "WIF : " . $wif . PHP_EOL . "<br>";
echo "getP2SHAddress : " . $getP2SHAddress . PHP_EOL . "<br>";
echo "getUncompressedP2SHAddress : " . $getUncompressedP2SHAddress . PHP_EOL . "<br>";
echo "getPubKey : " . $getPubKey . PHP_EOL . "<br>";
echo "getUncompressedPubKey : " . $getUncompressedPubKey . PHP_EOL . "<br>";

//import wif
$bitcoinECDSA = new BitcoinECDSA();
if($bitcoinECDSA->validateWifKey($wif)) {
    $bitcoinECDSA->setPrivateKeyWithWif($wif);
    $address = $bitcoinECDSA->getAddress();
    echo "imported address : " . $address . PHP_EOL;
} else {
    echo "invalid WIF key" . PHP_EOL;
}

echo "<br>";
 
// Defining host, port, and timeout
$host = 'electrumx';
$port = 50002;
$timeout = 30;
 
// Setting context options
$context = stream_context_create();
stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
 
// JSON query for fee estimation in 5 blocks
$data = "16LU1w8AbU9QCfk8MjNW4kqVgmAAPUvAtd";
$scripthash = hash('sha256', hex2bin(hash('sha256', $data)));
$query='{"id": "blk", "method": "blockchain.scripthash.get_balance", "params":["'.$scripthash.'"]}';
//$query='{"id": "blk", "method": "server.features"}';
if ($socket = stream_socket_client('ssl://'.$host.':'.$port, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context)) {
    fwrite($socket, $query."\n");
    $value=fread($socket,10240);
    $result=json_decode($value);
    print_r($result);
    fclose($socket);
} else {
   echo "ERROR: $errno - $errstr\n";
}

