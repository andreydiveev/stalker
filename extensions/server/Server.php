<?php

/**
 * Game server
 * @author Andrey Diveev <andrey.diveev@gmail.com>
 * @version 0.1
 * @date 18.11.2012 4:24
 *
 * @todo config
 * @todo socket server
 */

 require('Daemon.php');
 require('Socket.php');
 
 class Server extends Daemon{
    
    public $name = 'unit1';
    public $host = '178.250.244.82';
    public $port = 13031;
    
    protected $socket = null;
    
    
    protected function do_job(){
        
        $this->say("Register new socket...");
        $this->socket = new Socket($this->host, $this->port);
        
        $this->say("Working job unit1...");
        
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
        
        $sock = $this->socket->resource;
        
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
   
   public function status(){
       if($this->pid_exists()){
           $this->say("Running at ".$this->host.":".$this->port);
       }else{
           $this->say("Not running");
       }
   }
 }