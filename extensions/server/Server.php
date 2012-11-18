<?php

/**
 * Game server
 * @author Andrey Diveev <andrey.diveev@gmail.com>
 * @version 0.1
 * @date 18.11.2012 4:24
 *
 * @todo config
 * @todo json parese request
 */

 require('Daemon.php');
 require('Socket.php');
 require('Client.php');
 
 class Server extends Daemon{
    
    public $name = 'unit1';
    public $host = '178.250.244.82';
    public $port = 13031;
    
    protected $socket = null;
    protected $clients = array();
    
    protected $welcome_msg;
    
    
    protected function do_job(){
        
        $this->say("Register new socket...");
        $this->socket = new Socket($this->host, $this->port, $this->log);
        
        $this->socket->say("Working job unit1...");
        
        $this->welcome_msg = "\n".
            "Welcome to Socket Server!\n" .
            "Enter 'quit' for close connection.\n".
            "Enter 'shutdown' fom stop Socket Server."
        ;
        
        $commands = array(
            'quit',
            'shutdown',
            'whoami',
            'who_online',
        );
        
        do {
            $read = array();
            $read[] = $this->socket->resource; 
            $read = array_merge($read,$this->get_clients_sockets());
            
            if(socket_select($read,$write = NULL, $except = NULL, $tv_sec = 5) < 1){
                continue;
            }
            
            // Handle new Connections
            if (in_array($this->socket->resource, $read)) {
                
                if (($new_socket = socket_accept($this->socket->resource)) === false) {
                    $this->socket->log("socket_accept() fail: reazon: " . socket_strerror(socket_last_error($this->socket->resource)));
                    break;
                }
                
                $Client = new Client($new_socket);
                $Client->id = count($this->clients)+1;
                $Client->socket = $new_socket;
                
                $this->clients[] = $Client;
                
                $Client->send($this->welcome_msg);
                
                $this->socket->log("New client connected");
                
            }
            
            // Handle Input
            foreach ($this->clients as $Client) { // for each client
                if (in_array($Client->socket, $read)) {
                    
                    if (false === ($buf = $Client->read())) {
                        $this->socket->say("socket_read() falló: razón: ".socket_strerror(socket_last_error($Client->socket)));
                        break 2;
                    }
                    
                    if (!$buf = trim($buf)) {
                        continue;
                    }
                    
                    if(strpos($buf, ' ')){
                        $command_name = substr($buf, 0, strpos($buf, ' '));
                    }else{
                        $command_name = $buf;
                    }
                    
                    /*
                    if ($buf == 'shutdown') {
                        socket_close($Client->socket); // for each!!
                        break 2;
                    }*/
                    
                    if(in_array($command_name, $commands)){
                        $msg = "Command '".$command_name."' given\n";
                        $command_hendler = $command_name."Command";
                        $this->$command_hendler($Client);
                        break;
                    }else{
                        $msg = "Unknown command '".$command_name."'\n";
                    }
                    
                    $Client->send($msg);
                    $Client->send("Client {$Client->id}: Usted dijo '$buf'.\n");
                    
                    $this->socket->say($buf);
                }
                
            }
        } while (true);
        
        
        $this->socket->close();
        
        return false;
    }
   
    public function status(){
        if($this->pid_exists()){
           $this->say("Running at ".$this->host.":".$this->port);
        }else{
           $this->say("Not running");
        }
    }
    
    protected function test_job(){
        //while (true) {
        //    
        //    // делаем полезную работу
        //    // и ждём следующую итерацию
        //    
        //    $filename = dirname(__FILE__).'/temp';
        //    $contents = time()."\n";
        //    if ( is_writable($filename) ) {
        //      $r = fopen($filename, 'a'); // r|w|a
        //      if ( $r ) {
        //        fwrite($r, $contents);
        //        fclose($r);
        //      }
        //    }else{
        //        // log error 
        //        exit;
        //    }   
        //    usleep(Server::WORK_CYCLE_DELAY);
        //}
    }
    
    protected function whoamiCommand($Client){
        echo "Handler 'whoami' called:\n";
        
        $Client->send("Your id: ".$Client->id);
    }
    
    protected function quitCommand($Client){
        echo "Handler 'quit' called:\n";
        
        $Client->disconnect();
        $this->detach_client_by_id($Client->id);
    }
    
    protected function who_onlineCommand($Client){
        echo "Handler 'quit' called:\n";
        
        $msg = "";
        foreach($this->clients as $client){
            $msg .= "- ".$client->id."\n";
        }
        
        $Client->send($msg);
    }
    
    protected function get_clients_sockets(){
        $sockets = array();
        foreach($this->clients as $Client){
            $sockets[] = $Client->socket;
        }
        
        return $sockets;
    }
    
    protected function detach_client_by_id($id){
        foreach($this->clients as $key => $Client){
            if($Client->id == $id){
                unset($this->clients[$key]);
            }
        }
    }
    
    protected function get_client_by_id($id){
        foreach($this->clients as $key => $Client){
            if($Client->id == $id){
                unset($this->clients[$key]);
            }
        }
    }
    
 }