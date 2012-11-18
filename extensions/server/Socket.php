<?php

class Socket{
    
    public $host;
    public $port;
    public $log;

    public $status;
    public $resource;

    public function __construct($host, $port, $log){
        $this->host = $host;
        $this->port = $port;
        $this->log  = $log;
        
        $this->initialize();
    }
    
    protected function init(){
        $this->say("Socket init...");
    }

    protected function initialize(){
        $this->say("initialize...");
        $this->prepare();
        $this->resource = $this->get_socket();
    }

    protected function prepare(){
        $this->say("prepare...");
        
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
                echo "Завершение работы...<br />\n";
                exit(1);
            break;
            
            case E_USER_WARNING:break;
            case E_USER_NOTICE:break;
            case E_ERROR:break;
            case E_WARNING:break;
            case E_PARSE:break;
            case E_CORE_ERROR:break;
            case E_NOTICE:break;
            case E_DEPRECATED:break;
            case E_ALL:break;
            case E_STRICT:break;
            default:break;
        }
        
        /* Не запускаем внутренний обработчик ошибок PHP */
        return true;
    }


    protected function get_socket(){
        $this->say("get socket...");
        $address = $this->host;
        $port = $this->port;
        
        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            $this->say("socket_create() falló: razón: " . socket_strerror(socket_last_error()));
        }
        
        $is_socket_bound = socket_bind($sock, $address, $port);
        
        if($is_socket_bound === false){
            $this->say("socket_bind() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...");
            $this->say("bye...");
            exit;
        }else{
            $this->say("bound with ".$address.":".$port."...");
        }
        
        if (socket_listen($sock, 5) === false) {
            $this->say("socket_listen() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...");
        }
        
        return $sock;
    }
    
    public function say($phrase, $logging = true){
        $phrase = "Socket: ".$phrase;
        
        echo $phrase."\n";
        
        if($logging){
            $this->log($phrase);
        }
    }
    
    public function log($msg){
        $msg = date('[d-M-Y H:i:s] ',time()).$msg;
        fwrite($this->log, $msg."\n");
    }
    
    public function close(){
        socket_close($this->resource);
    }
}