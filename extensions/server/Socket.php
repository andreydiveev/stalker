<?php

/**
 * Socket class
 * @author Andrey Diveev <andrey.diveev@gamil.com>
 * @version v0.1.2
 * @package Server
 *
 * @todo Cover PHPDoc
 */

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
        $this->log  = $log; // Fix
        
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
    }
    
    protected function get_socket(){
        $this->say("get socket...");
        
        try{
            if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
                $this->say("socket_create() falló: razón: " . socket_strerror(socket_last_error()));
            }
        }catch(CustomException $e){
            $this->say("Can't create socket :".$e->getMessage());
        }
        
        if($this->bind($sock) === false){
            $this->say("Bind failed: " . socket_strerror(socket_last_error($sock)));
            $this->say("bye...");
            exit;
        }
        
        try{
            if (socket_listen($sock, 5) === false) {
                $this->say("socket_listen() falló: razón: " . socket_strerror(socket_last_error($sock)) . "...");
            }
        }catch(CustomException $e){
            $this->say("[CustomException] Can't create socket :".$e->getMessage());
        }catch(Exception $e){
            $this->say("[Exception] Can't create socket :".$e->getMessage());
        }
        
        return $sock;
    }
    
    protected function bind($sock, $host = null, $port = null, $attempt = 1){
        
        if($host === null){$host = $this->host;}
        if($port === null){$port = $this->port;}
        
        try {
            $this->say("Try to bind on ".$host.":".$port." (attempt ".$attempt.")");
            
            $is_socket_bound = socket_bind($sock, $host, $port);
            
            if($is_socket_bound !== false){
                $this->say("Bound on ".$host.":".$port." (attempts ".$attempt.")");
                
                if($port != $this->port){
                    $this->port_modified = true;
                }else{
                    $this->port_modified = false;
                }
                
                $this->host = $host;
                $this->port = $port;
            }else{
                $this->say("Can't bind socket");
            }
            
            return $is_socket_bound;
            
        } catch (CustomException $e) {
            $max_attempts_count = 100;
            
            if($attempt > $max_attempts_count){
                return false;
            }
            
            $min_port_range = 13000;
            $max_port_range = 13999;
            
            $port = rand($min_port_range, $max_port_range);
            $attempt = $attempt + 1;
            
            $this->bind($sock, $host, $port, $attempt);
        } catch (Exception $e){
            $this->say("Can't bind socket ".$e->getMessage());
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
        try {
            socket_close($this->resource); /** @todo try/catch */
        }catch(CustomException $e){
            $this->say("Can't close socket: ".$e->getMessage);
        }
    }
}