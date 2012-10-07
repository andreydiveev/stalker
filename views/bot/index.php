



<?php

Yii::setPathOfAlias('Zend',Yii::getPathOfAlias('application.vendors.zf2.library.Zend.*'));


// login

$client = new Zend\Http\Client();

/*
 * circa:circa123123
 *
 */

$url = 'http://sta1ker.com/login.php';
$client->setUri($url);

$nick = 'fuuu';
$pass = 'q123q123';
$lvl = 0;
$response_google2 = 'null';

if(isset(Yii::app()->session['nick']) && isset(Yii::app()->session['pass'])){
    $nick = Yii::app()->session['nick'];
    $pass = Yii::app()->session['pass'];
    $lvl  = Yii::app()->session['lvl'];
}

$params  = array('nick' => $nick, 'pass'=>$pass, 'log'=>'Войти');
$client->setOptions(array('strictredirects' => true));
$client->setMethod('POST');
$client->setParameterPost($params);
$response_google = $client->send();


switch($lvl){

    case 1:{
        // main

        $url = 'http://sta1ker.com/';
        $client->setUri($url);
        $response_google2 = $client->send();

        // zona
        $url = 'http://sta1ker.com/zona.php';
        $client->setUri($url);
        $response_google2 = $client->send();

        // svalka
        $url = 'http://sta1ker.com/base.php';
        $client->setUri($url);
        $response_google2 = $client->send();

        $url = 'http://sta1ker.com/attack.php?rand=0&weapon=pistol&attack=24';
        $client->setUri($url);
        $response_google2 = $client->send();

        break;
    }

    case 10:{

        // main

        $url = 'http://sta1ker.com/';
        $client->setUri($url);
        $response_google2 = $client->send();

        // zona
        $url = 'http://sta1ker.com/zona.php';
        $client->setUri($url);
        $response_google2 = $client->send();

        // svalka
        $url = 'http://sta1ker.com/kordon.php?location=kordon3';
        $client->setUri($url);
        $response_google2 = $client->send();

        // svalka
        $url = 'http://sta1ker.com/kordon.php?location=kordon4';
        $client->setUri($url);
        $response_google2 = $client->send();

        $url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=11';
        $client->setUri($url);
        $response_google2 = $client->send();

        break;
    }

    case 15:{
        break;
    }

    case 20:{
        break;
    }

    case 25:{


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

        // svalka
        $url = 'http://sta1ker.com/attack.php?attack=bp';
        $client->setUri($url);
        $response_google2 = $client->send();

        $url = 'http://sta1ker.com/yantar.php?location=yantar5';
        $client->setUri($url);
        $response_google2 = $client->send();

        $url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=1718';
        $client->setUri($url);
        $response_google2 = $client->send();

        break;
    }

    default:{
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

        // svalka
        $url = 'http://sta1ker.com/attack.php?attack=bp';
        $client->setUri($url);
        $response_google2 = $client->send();


        $url = 'http://sta1ker.com/yantar.php?location=yantar5';
        $client->setUri($url);
        $response_google2 = $client->send();

        $url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=1718';
        $client->setUri($url);
        $response_google2 = $client->send();
    }


}
/*
// attack/
$url = 'http://sta1ker.com/attack.php?rand=0&weapon=avtomat&attack=1719';
$client->setOptions(array('strictredirects' => false));
$client->setUri($url);
$response_google2 = $client->send();
*/



print(Yii::app()->session[Yii::app()->session['nick'].'connected'].'<p/>');
print($response_google2->getBody());

?>


<html>
<head><title><?=Yii::app()->session[Yii::app()->session['nick'].'connected'];?></title></head>
<body>

<script language="JavaScript" type="text/javascript">

    function GoNah(){
      location="/bot/index";
    }
    setTimeout( 'GoNah()', 5000 );

</script>

</body>
</html>




