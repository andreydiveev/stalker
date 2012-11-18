<?php

class Socket{
    
    public $host;
    public $port;

    public $status;
    public $resource;

    public function __construct($host, $port){
        $this->host = $host;
        $this->port = $port;
        
        $this->initialize();
    }
    
    protected function init(){
        echo "Socket init...\n";
    }

    protected function initialize(){
        echo "initialize...\n";
        $this->prepare();

        $this->resource = $this->get_socket();
        
        //return $socket;

        //$this->process($socket);

    }

    protected function prepare(){
        echo "prepare...\n";
        error_reporting(E_ALL); // Show all errors
        set_time_limit(0); // Permitir al script esperar para conexiones.
        ob_implicit_flush();  // Activar el volcado de salida implícito, así veremos lo que estamo obteniendo mientras llega.

        //set_error_handler(create_function('$c, $m, $f, $l', 'throw new MyException($m, $c, $f, $l);'), E_ALL);

        /*  E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR |
            E_CORE_WARNING | E_ALL | E_NOTICE | E_STRICT | E_DEPRECATED |
        */

        //set_error_handler(create_function('$n,$s,$f,$l', 'ServerCommand::handler($n,$s,$f,$l);'), E_ALL);
    }

    static protected function handler($errno, $errstr, $errfile, $errline){
        return true;

        if (!(error_reporting() & $errno)) {
            // Этот код ошибки не включен в error_reporting
            return true;
        }

        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
                echo "  Фатальная ошибка в строке $errline файла $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Завершение работы...<br />\n";
                exit(1);
                break;

            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>My NOTICE1</b> [$errno] $errstr<br />\n";
                break;

            case E_ERROR:
                echo "<b>My NOTICE2</b> [$errno] $errstr<br />\n";
                break;

            case E_WARNING:
                echo "<b>My NOTICE3</b> [$errno] $errstr<br />\n";
                break;
            case E_PARSE:
                echo "<b>My NOTICE4</b> [$errno] $errstr<br />\n";
                break;
            case E_CORE_ERROR:
                echo "<b>My NOTICE5</b> [$errno] $errstr<br />\n";
                break;

            case E_NOTICE:
                echo "<b>My NOTICE6</b> [$errno] $errstr<br />\n";
                break;

            case E_DEPRECATED:
                echo "<b>My NOTICE7</b> [$errno] $errstr<br />\n";
                break;

            case E_ALL:
                echo "<b>My NOTICE8</b> [$errno] $errstr<br />\n";
                break;

            case E_STRICT:
                echo "<b>My NOTICE9</b> [$errno] $errstr<br />\n";
                break;


            default:
                echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
                break;
        }

        /* Не запускаем внутренний обработчик ошибок PHP */
        return true;
    }


    protected function get_socket(){
        echo "get socket...\n";
        $address = $this->host;
        $port = $this->port;

        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() falló: razón: " . socket_strerror(socket_last_error()) . "\n";
        }

        $is_socket_bound = socket_bind($sock, $address, $port);

        if($is_socket_bound === false){
            echo /*"socket_bind() falló: razón: " . */socket_strerror(socket_last_error($sock)) . "...\n";
            echo "bye...\n";
            exit;
        }else{
            echo "bound with ".$address.":".$port."...\n";
        }



        if (socket_listen($sock, 5) === false) {
            echo "socket_listen() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...\n";
        }

        return $sock;
    }

    
    public function process($sock){
        echo "process...\n";
        //clients array
        $clients = array();

        do {
            $read = array();
            $read[] = $sock;

            $read = array_merge($read,$clients);

            // Set up a blocking call to socket_select
            if(socket_select($read,$write = NULL, $except = NULL, $tv_sec = 5) < 1)
            {
                //    SocketServer::debug("Problem blocking socket_select?");
                continue;
            }

            // Handle new Connections
            if (in_array($sock, $read)) {

                if (($msgsock = socket_accept($sock)) === false) {
                    echo "socket_accept() falló: razón: " . socket_strerror(socket_last_error($sock)) . "\n";
                    break;
                }
                $clients[] = $msgsock;
                $key = array_keys($clients, $msgsock);
                /* Enviar instrucciones. */
                $msg = "\nBienvenido al Servidor De Prueba de PHP. \n" .
                    "Usted es el cliente numero: {$key[0]}\n" .
                    "Para salir, escriba 'quit'. Para cerrar el servidor escriba 'shutdown'.\n";
                socket_write($msgsock, $msg, strlen($msg));

            }

            // Handle Input
            foreach ($clients as $key => $client) { // for each client
                if (in_array($client, $read)) {
                    if (false === ($buf = socket_read($client, 2048, PHP_NORMAL_READ))) {
                        echo "socket_read() falló: razón: " . socket_strerror(socket_last_error($client)) . "\n";
                        break 2;
                    }
                    if (!$buf = trim($buf)) {
                        continue;
                    }
                    if ($buf == 'quit') {
                        unset($clients[$key]);
                        socket_close($client);
                        break;
                    }
                    if ($buf == 'shutdown') {
                        socket_close($client);
                        break 2;
                    }
                    $talkback = "Cliente {$key}: Usted dijo '$buf'.\n";
                    socket_write($client, $talkback, strlen($talkback));
                    echo "$buf\n";
                }

            }
        } while (true);


        socket_close($sock);

        return false;
    }
    
    
}