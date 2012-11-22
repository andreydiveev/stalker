<?php

/**
 * Game server
 * @author Andrey Diveev <andrey.diveev@gmail.com>
 * @version 0.1.2
 * @date 18.11.2012 4:24
 *
 * @todo config
 * @todo json parese request
 * @todo control SIGTERM if crashed! Child process stay running!!!
 * @todo include files by config import
 * @todo Cover PHPDoc
 * @todo Cover UnitTests
 * @todo use Redis or another NoSQL or Memcached
 * @todo remove trash code
 */

 require('Daemon.php');
 require('Socket.php');
 require('models/Client.php');
 
 class Server extends Daemon{
    
    public $name = 'unit1';
    public $host = '178.250.244.82';
    public $port = 13031;
    
    protected $socket = null;
    protected $clients = array();
    
    protected $welcome_msg;
    
    protected $port_file;
    
    
    protected function do_job(){
        
        //if(!pcntl_signal(SIGTERM, "Server::signals")){
        //    exit("Could not setup SIGTERM handler.\n");
        //}
      
        
        
      
        
        /** @todo resolve init method !!!! */
        $baseDir = dirname(__FILE__);
        $this->port_file = $baseDir.'/run/'.$this->name.'.port';
        
        $this->remove_stored_port();
        
        $this->say("Register new socket...");
        $this->socket = new Socket($this->host, $this->port, $this->log);
        $this->host = $this->socket->host;
        $this->port = $this->socket->port;
        
        if($this->socket->port_modified){
            $this->save_port();
        }
        
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
            'broadcast',
        );
        
        /** @todo Consider usleep */
        do {
            
            /** @todo Use is_running */
            
            $read = array();
            $read[] = $this->socket->resource; 
            $read = array_merge($read,$this->get_clients_sockets());
            
            try{
                if(socket_select($read,$write = NULL, $except = NULL, $tv_sec = 5) < 1){
                    continue;
                }
            }catch(CustomException $e){
                $this->say("[CustomException] Can't select socket: ".$e->getMessage());
                continue;
            }catch(Exception $e){
                $this->say("[Exception] Can't select socket: ".$e->getMessage());
                continue;
            }
            
            // Handle new Connections
            if (in_array($this->socket->resource, $read)) {
                
                try{
                    if (($new_socket = socket_accept($this->socket->resource)) === false) {
                        $this->socket->log("socket_accept() fail: reazon: " . socket_strerror(socket_last_error($this->socket->resource)));
                        break;
                    }
                }catch(CustomException $e){
                    $this->say("[CustomException] Can't accept socket: ".$e->getMessage());
                }catch(Exception $e){
                    $this->say("[Exception] Can't accept socket: ".$e->getMessage());
                }
                
                $Client = new Client($new_socket);
                $Client->id = count($this->clients)+1;
                $Client->send($this->welcome_msg);
                
                $this->clients[$Client->id] = $Client;
                
                $this->say("New client connected");
                
            }
            
            // Handle Input
            foreach ($this->clients as $Client) { // for each client
                if (in_array($Client->socket, $read)) {
                    
                    if (false === ($buf = $Client->read())) {
                        $this->socket->say("socket_read()00 falló: razón: ".socket_strerror(socket_last_error($Client->socket)));
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
    
    /*public function sig_handler($signo){
        
        $log = fopen(dirname(__FILE__).'/log/debug.application.log', 'ab');
        
        switch ($signo){
            case SIGTERM:
                #15
                $msg = "Daemon: Terminate (SIGTERM - ".SIGTERM.")";
                exit;
            break;
            
            case SIGHUP:
                $msg = "Daemon: Need reload! (SIGHUP - ".SIGHUP.")";
            break;
            
            case SIGUSR1:
                // #10
                $msg = "User signal (SIGUSR1 - ".SIGUSR1.")";
            break;
            
            default:
                $msg = "Daemon: Unknown signal (".$signo.")";
            break;
        }
        
        echo $msg."\n";
        fwrite($log, date('[d-M-Y H:i:s] ',time()).$msg."\n");
    }*/
   
    public function status(){
        if($this->pid_exists()){
            if($this->get_stored_port()){
                $this->say("Running at ".$this->host.":".$this->port." (Stored port)"); 
            }else{
                $this->say("Running at ".$this->host.":".$this->port." (Base port)");
            }
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
    
    protected function broadcastCommand($Client){
        foreach($this->clients as $client){
            if($client->id == $Client->id){continue;}
            $client->send("Message from client: ".$Client->id."\n");
        }
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
            $msg .= "- ".$client->id." [".$client->host.":".$client->port."]\n";
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
        if(isset($this->clients[$id])){
            $Client = $this->clients[$id];
            if(isset($Client->id) && $Client->id == $id){
                unset($this->clients[$id]);
                
                return true;
            }
        }
        
        return false;
    }
    
    protected function get_client_by_id($id){
        if(isset($this->clients[$id])){
            if($Client->id == $id){
                unset($this->clients[$id]);
                
                return true;
            }
        }
        
        return false;
    }
    
    protected function get_stored_port(){
        /** @todo set const
            @todo refactor with Redis
        */
        
        if (is_readable($this->port_file)) {
            $port = (int)file_get_contents($this->port_file);
            if($port > 0){
                $this->port = $port;
                return true;
            }else{
                return false;
            }
            
            //exit;
         
        }else{
            return false;
        }
    }
    
    protected function save_port(){
        
        if (!$this->is_running) {
            $this->say("Can't create pid file. Server not running.");
            //exit;  // Exception!!!!
        }else{
            
            if (!file_put_contents($this->port_file, $this->port)) {
                $this->say("Can't create time file...");
                //exit; // Exception!!!!
            }
            
            $this->say("Port (".$this->port.") saved to file.");
        }
        
    }
    
    protected function remove_stored_port(){
        
        if (is_writable($this->port_file)) {
            
            if (!unlink($this->port_file)) {
                $this->say("Stored port delete failed");
                
                return false;
            }else{
                $this->say("Stored port deleted");
            }
            
            return true;
            
        }else{
            return false;
        }
    }
    
 }