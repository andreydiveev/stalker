<?php

/**
 * Game server
 * @author Andrey Diveev <andrey.diveev@gmail.com>
 * @version 0.1
 * @date 18.11.2012 4:24
 */
class Server extends CComponent{
    
    CONST WORK_CYCLE_DELAY = 100000;
    
    protected $log;
    //protected $log_level = 5; /** @todo continue integration*/
    //protected $error_log; /** @todo continue integration*/
    
    public $start_time;
    public $is_running = false;
    protected $pid_file;
    
    public function init(){
        //$this->say("Native init...");
        
        //umask(0);
        //chdir('/');
        
        
        $baseDir = dirname(__FILE__);
        ini_set('error_log',$baseDir.'/log/error.log');
        //fclose(STDIN);
        //fclose(STDOUT);
        //fclose(STDERR);
        $STDIN = fopen('/dev/null', 'r');
        $this->log = fopen($baseDir.'/log/application.log', 'ab');
        //$STDERR = fopen($baseDir.'/log/error.log', 'ab');
        
        //$this->error('Test error');
        
        
        $this->pid_file = dirname(__FILE__).'/server.pid';
        
        if($this->pid_exists()){
            $this->is_running = true;
        }
    }
    
    protected function before_start(){}
    
    public function start(){
        
        if($this->is_running){
            $this->say("Daemon already running.");
            exit;
        }
        
        $this->say("Starting server...");
        
        $pid = pcntl_fork();
        
        if ($pid == -1) {
            echo "Fork error!\n";
            //$this->say("Fork error");
            exit;
        } elseif ($pid > 0) {
            // завершаем работу родительского процесса
            //$MASTER_STDIN = STDIN;
            exit;
        }
        
        
        // Делаем основным процессом дочерний.
        if (posix_setsid() == -1) {
            exit;
        }
        
        //$SECOND_STDIN = STDIN;
        
        $pid = pcntl_fork();
        
        if ($pid == -1) {
            exit;
        } elseif ($pid > 0) {
            exit;
        }
        
        $this->set_pid();
        
        //SIGTERM - $kill -s TERM <pid>
        //SIGKILL
        //SIGSTOP
        
        //pcntl_signal(SIGTERM, 'sigterm_handler');
        //pcntl_signal(SIGTERM, 'sig_handler');
        //pcntl_signal(SIGQUIT, 'sig_handler');
        //pcntl_signal(SIGHUP,  'sig_handler');
        //pcntl_signal(SIGHUP, SIG_IGN);
        //pcntl_signal(SIGHUP, SIG_DFL);
        
        /*
        declare(ticks=1) {
            // Здесь полный сценарий
            
            function sig_handler($signo) {
                switch ($signo) {
                    case SITERM:
                    case SIGQUIT:
                        // удаляем временные файлы
                        delete_all_tmp_files();
                        // завершаем работу приложения
                        exit;
                    break;
                    case SIGHUP:
                        reload_configuration_file();
                    break;
                }
            }
        }
        */
        
        $this->do_job();
     
    }
    
    protected function pid_exists(){
        /** @todo set const */
        
        if (is_readable($this->pid_file)) {
            $pid = (int)file_get_contents($this->pid_file);
            
            if ($pid > 0 && posix_kill($pid, 0)) {
                return true;
                //exit;
            }else{
                return false;
            }
            
        }
    }
    
    protected function set_pid(){
        
        $pid = posix_getpid();
        
        if (!file_put_contents($this->pid_file, $pid)) {
            $this->say("Can't create pid file...");
            //exit;
        }else{
            $this->is_running = true;
            $this->start_time = time();
            $this->say("Pid updated - ".$pid);
        }
        
    }
    
    protected function del_pid(){
        
        
        if (is_writable($this->pid_file)) {
            $pid = (int)file_get_contents($this->pid_file);
            
            
            /** @todo consider split cause*/
            if ($pid > 0 && posix_kill($pid, SIGTERM)) {
                $this->say("Stopped!");
                //exit;
            }else{
                $this->say("Not stopped...");
            }
            
            if (!unlink($this->pid_file)) {
                $this->say("Pid delete failed");
                //exit;
            }else{
                $this->is_running = false;
                $this->say("Pid deleted - ".$pid);
            }
        }else{
            return false;
        }
    }
    
    public function stop(){
        
        if($this->is_running){
            $this->say("Stop server...");
            $this->del_pid();
        }else{
            $this->say("Not running");
            return false;
        }
        
        //fclose($this->log);
        
        return true;
    }
    
    protected function do_job(){
        
        $this->say("Working job...");
        
        while (true) {
            
            // делаем полезную работу
            // и ждём следующую итерацию
            
            $filename = dirname(__FILE__).'/temp';
            $contents = time()."\n";
            if ( is_writable($filename) ) {
              $r = fopen($filename, 'a'); // r|w|a
              if ( $r ) {
                fwrite($r, $contents);
                fclose($r);
              }
            }else{
                // log error 
                exit;
            }   
            usleep(Server::WORK_CYCLE_DELAY);
        }
    }
    
    public function status(){
        if($this->pid_exists()){
            $this->say("Running");
        }else{
            $this->say("Not running");
        }
    }
    
    protected function say($phrase, $logging = true){
        echo "Server: ".$phrase."\n";
        
        if($logging){
            $this->log($phrase);
        }
    }
    
    protected function log($msg){
        $msg = date('[d-M-Y H:i:s] ',time()).$msg;
        fwrite($this->log, $msg."\n");
    }
    
    protected function error($msg){
        
        // Here some actions, for example, send mail.
        
        error_log($msg);
    }
    
}