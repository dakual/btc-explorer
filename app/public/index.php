<?php
namespace App;

require_once('../vendor/autoload.php');


use Denpa\Bitcoin\Client as BitcoinClient;

$bitcoind = new BitcoinClient([
    'scheme'        => 'http',
    'host'          => 'host.docker.internal',
    'port'          => 18332,
    'user'          => 'admin',
    'password'      => 'admin',
    'ca'            => '/etc/ssl/ca-cert.pem',
    'preserve_case' => false,
]);

$unspent = $bitcoind->listunspent();
$amount = 0;
$i=0;
for(; isset($unspent[$i]); $i++)
{
    $input[$i] = array(
        "txid"=>$unspent[$i]['txid'],
        "vout"=>$unspent[$i]['vout']
    );
    
    $amount += $unspent[$i]['amount'];
}

$fee = (int) ((($i+1) * 181 + 34 + 10) /1024) + 1;
$fee *= 0.0001; //fee per kb

if($amount > $fee AND $fee > 0)
{
    echo "Amount:\t ".($amount - $fee)."\n";
    echo "Fee: \t ".($fee)."\n";
    $output = array("mmGkwmzwVQj2sRsBvjt3mKRuE7R9EXMSHG" => ($amount - $fee));
    print_r($input);
    echo "-------";
    print_r($output);
    $tx = $bitcoind->createrawtransaction($input, $output);
    $signed = $bitcoind->signrawtransactionwithkey($tx->result(), ["cQgCXfF6y8H4rswHR5RWF91QWKeJUhC8ZLb3G6v76ESU4K6y4nG8","cTP72DYYU7RsJEg5sAzsoFGof2DFE4m2tAGw16dw7uQFSC469ow3"]);
    if(!empty($signed->get("hex"))) {
        $res = $bitcoind->sendrawtransaction($signed->get("hex"));
        print_r($res);
    } else {
      echo "failed";
    }
    echo "\n";
}

// print_r($block);

// use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;

// $bitcoinECDSA = new BitcoinECDSA();
// $bitcoinECDSA->setNetworkPrefix('6f');
// // $bitcoinECDSA->generateRandomPrivateKey();
// $bitcoinECDSA->setPrivateKey("ad0ef5b050953cea3379f4eb8a8fdc65d47207f54d2989e23f6c75db1039e87c");
// $private = $bitcoinECDSA->getPrivateKey();
// $wif = $bitcoinECDSA->getWif();
// $address = $bitcoinECDSA->getAddress();
// $address = $bitcoinECDSA->getAddress();
// $getP2SHAddress = $bitcoinECDSA->getP2SHAddress();
// $getUncompressedP2SHAddress = $bitcoinECDSA->getUncompressedP2SHAddress();
// $getPubKey = $bitcoinECDSA->getPubKey();
// $getUncompressedPubKey = $bitcoinECDSA->getUncompressedPubKey();
// echo "Address: " . $address . PHP_EOL . "<br>";
// echo "PrivateKey: " . $private . PHP_EOL . "<br>";
// echo "WIF : " . $wif . PHP_EOL . "<br>";
// echo "getP2SHAddress : " . $getP2SHAddress . PHP_EOL . "<br>";
// echo "getUncompressedP2SHAddress : " . $getUncompressedP2SHAddress . PHP_EOL . "<br>";
// echo "getPubKey : " . $getPubKey . PHP_EOL . "<br>";
// echo "getUncompressedPubKey : " . $getUncompressedPubKey . PHP_EOL . "<br>";

// //import wif
// $bitcoinECDSA = new BitcoinECDSA();
// if($bitcoinECDSA->validateWifKey($wif)) {
//     $bitcoinECDSA->setPrivateKeyWithWif($wif);
//     $address = $bitcoinECDSA->getAddress();
//     echo "imported address : " . $address . PHP_EOL;
// } else {
//     echo "invalid WIF key" . PHP_EOL;
// }

// echo "<br>";



// // Defining host, port, and timeout
// $host = 'electrumx';
// $port = 50002;
// $timeout = 30;
 
// // Setting context options
// $context = stream_context_create();
// stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
// stream_context_set_option($context, 'ssl', 'verify_peer_name', false);
 
// // JSON query for fee estimation in 5 blocks
// $data = "16LU1w8AbU9QCfk8MjNW4kqVgmAAPUvAtd";
// $scripthash = hash('sha256', hex2bin(hash('sha256', $data)));
// $query='{"id": "blk", "method": "blockchain.scripthash.get_balance", "params":["'.$scripthash.'"]}';
// //$query='{"id": "blk", "method": "server.features"}';
// if ($socket = stream_socket_client('ssl://'.$host.':'.$port, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context)) {
//     fwrite($socket, $query."\n");
//     $value=fread($socket,10240);
//     $result=json_decode($value);
//     print_r($result);
//     fclose($socket);
// } else {
//    echo "ERROR: $errno - $errstr\n";
// }

