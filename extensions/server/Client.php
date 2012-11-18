<?php

/**
 * Client model 
 */

class Client extends CModel{
    
    public $id;
    public $socket;
    public $name;
    
    public $buffer;
    
    public function attributeNames(){
        return array(
            'id',
            'socket',
            'name',
        );
    }
    
    public function disconnect(){
        socket_close($this->socket);
    }
    
    public function send($msg){
        $msg .= "\n";
        socket_write($this->socket, $msg, strlen($msg));
    }
    
    public function read(){
        $this->buffer = socket_read($this->socket, 2048, PHP_NORMAL_READ);
        
        return $this->buffer;
    }
    
}