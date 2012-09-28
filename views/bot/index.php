



<?php

Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.zf2.library.Zend.*'));


// login

$client = new Zend\Http\Client();



$url = 'http://sta1ker.com/login.php';
$client->setUri($url);
$params  = array('nick' => 'fuuu', 'pass'=>'q123q123', 'log'=>'Войти');
$client->setOptions(array('strictredirects' => true));
$client->setMethod('POST');
$client->setParameterPost($params);
$response_google = $client->send();

// main
$url = 'http://sta1ker.com/';
$client->setUri($url);
$response_google2 = $client->send();
// zona
$url = 'http://sta1ker.com/zona.php';
$client->setUri($url);
$response_google2 = $client->send();

// svalka
$url = 'http://sta1ker.com/yantar.php?location=yantar6';
$client->setUri($url);
$response_google2 = $client->send();


$url = 'http://sta1ker.com/yantar.php?location=yantar5';
$client->setUri($url);
$response_google2 = $client->send();

$url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=1718';
$client->setUri($url);
$response_google2 = $client->send();


/*
// attack/
$url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=1719';
$client->setOptions(array('strictredirects' => false));
$client->setUri($url);
$response_google2 = $client->send();
*/



print(Yii::app()->session['connected'].'<p/>');
print($response_google2->getBody());

?>


<html>
<head><title><?=Yii::app()->session['connected'];?></title></head>
<body>

<script language="JavaScript" type="text/javascript">

    function GoNah(){
      location="/bot/index";
    }
    setTimeout( 'GoNah()', 5000 );

</script>

</body>
</html>




