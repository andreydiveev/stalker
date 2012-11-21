<?php

class Socket{
    
    public $host;
    public $port;
    public $log;

    public $status;
    public $resource;
    
    public $port_modified;

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
        
        
        
        //throw new tes();
        //$obj->dod();
        //throw new CustomException(1,1,1,1);
    }

    static public function util($n,$s,$f,$l){
        echo "1: ".$n."\n";
        echo "2: ".$s."\n";
        echo "3: ".$f."\n";
        echo "4: ".$l."\n";
        //throw new CustomException(1,1,1,1);
    }
    
    static public function handler($errno, $errstr, $errfile, $errline){
        
        if (!(error_reporting() & $errno)) {
            // Этот код ошибки не включен в error_reporting
            echo "not in err reporting\n";
            return true;
        }
        
        switch ($errno) {
            case E_USER_ERROR:
                echo "Завершение работы...<br />\n";
                exit(1);
            break;
            
            case E_USER_WARNING : echo "E_USER_WARNING\n";break;
            case E_USER_NOTICE  : echo "E_USER_NOTICE\n";break;
            case E_ERROR        : echo "E_ERROR\n";break;
            case E_WARNING      : echo "E_WARNING\n";break;
            case E_PARSE        : echo "E_PARSE\n";break;
            case E_CORE_ERROR   : echo "E_CORE_ERROR\n";break;
            case E_NOTICE       : echo "E_NOTICE\n";break;
            case E_DEPRECATED   : echo "E_DEPRECATED\n";break;
            case E_ALL          : echo "E_ALL\n";break;
            case E_STRICT       : echo "E_STRICT\n";break;
            default             : echo "default\n";break;
        }
        
        /* Не запускаем внутренний обработчик ошибок PHP */
        return true;
    }


    protected function get_socket(){
        $this->say("get socket...");
        
        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            $this->say("socket_create() falló: razón: " . socket_strerror(socket_last_error()));
        }
        
        if($this->bind($sock) === false){
            $this->say("socket_bind() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...");
            $this->say("bye...");
            exit;
        }
        
        if (socket_listen($sock, 5) === false) {
            $this->say("socket_listen() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...");
        }
        
        return $sock;
    }
    
    protected function bind($sock, $host = null, $port = null, $attempt = 1){
        
        if($host === null){$host = $this->host;}
        if($port === null){$port = $this->port;}
        
        try {
            $this->say("Try to bind on ".$host.":".$port." (attempt ".$attempt.")");
            
            $is_socket_bound = socket_bind($sock, $host, $port);
            
            $this->say("Bound on ".$host.":".$port." (attempts ".$attempt.")");
            
            if($port != $this->port){
                $this->port_modified = true;
            }else{
                $this->port_modified = false;
            }
            
            $this->host = $host;
            $this->port = $port;
            
            return $is_socket_bound;
            
        } catch (WarningException $e) {
            $max_attempts_count = 100;
            
            if($attempt > $max_attempts_count){
                return false;
            }
            
            $min_port_range = 10000;
            $max_port_range = 99999;
            
            $port = rand($min_port_range, $max_port_range);
            $attempt = $attempt + 1;
            
            $this->bind($sock, $host, $port, $attempt);
        } catch (Exception $e){
           echo "error catched2\n";
        }
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