<?
set_time_limit(0);
ob_implicit_flush();

echo "- Сервер \n\n";

$address = '178.250.244.82';
$port = 5555;

echo "Создание сокета ... ";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if($socket < 0)
{
    echo "Ошибка: ".socket_strerror(socket_last_error())."\n";
} 
else
{
    echo "OK \n";
}

echo "Привязывание сокета... ";
$bind = socket_bind($socket, $address, $port);
if($bind < 0)
{
    echo "Ошибка: ".socket_strerror(socket_last_error())."\n";
}
else
{
    echo "OK \n";
}

echo "Прослушивание сокета... ";
$listen = socket_listen($socket, 5);
if($listen < 0)
{
    echo "Ошибка: ".socket_strerror(socket_last_error())."\n";
}
else
{
    echo "OK \n";
}

while(true)
{ 
    echo "Ожидаем... ";
    $accept = socket_accept($socket);
    if($accept < 0)
    {
        echo "Ошибка: ".socket_strerror(socket_last_error())."\n";
        break;
    }
    else
    {
        echo "OK \n";
    }

    $msg = "Hello, Клиент!";
    echo "Отправить клиенту \"".$msg."\"... ";
    socket_write($accept, $msg, strlen($msg));
    echo "OK \n";

    while(true)
    {
        $awr = socket_read($accept, 1024);
        if (false === $awr)
        {
            echo "Ошибка: ".socket_strerror(socket_last_error())."\n";
            break 2;
        }
        else
        {
            if (trim($awr) == "")
                break;
            else
                echo "Клиент сказал: ".$awr."\n";
        }
        
        if ($awr == 'exit') 
        {
            socket_close($accept);
            break 2;
        }

        echo "Сказать клиенту \"".$msg."\"... ";
        socket_write($accept, $awr, strlen($awr));
        echo "OK \n";
    }

}

if (isset($socket))
{
    echo "Закрываем соединение... ";
    socket_close($socket);
    echo "OK \n";
}
?>