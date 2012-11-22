<?php

/**
 * Daemon component
 * @author Andrey Diveev <andrey.diveev@gamil.com>
 * @version v0.1.2
 *
 * @todo cover PHPDoc
 * @todo include files by config import
 * @todo split errors and messages to different logs
 */

require('Daemonic.php');
 
abstract class Daemon extends CComponent implements Daemonic{
    
    CONST WORK_CYCLE_DELAY = 100000;
    
    public $name; /** @todo create name pattern */
    protected $log;
    //protected $log_level = 5; /** @todo continue integration*/
    //protected $error_log; /** @todo continue integration*/
    
    public $is_running = false;
    public $start_time;
    protected $pid_file;
    protected $time_file;
    
    public function init(){
        //$this->say("Native daemon init...");
        
        //umask(0);
        //chdir('/');
        
        // Регистрируем сигналы
        declare(ticks = 1);
        //pcntl_signal(SIGTERM, "self::sig_handler");
        pcntl_signal(SIGUSR1, function ($signal) { 
            echo "usr\n"; 
        });
        
        error_reporting(E_ALL);  
        ob_implicit_flush();
        
        set_time_limit(0);
        set_error_handler("self::error_handler", E_ALL);
        
        $this->init_log();
        
        $baseDir = dirname(__FILE__);
        ini_set('error_log',$baseDir.'/log/'.$this->name.'.error.log');
        $STDIN = fopen('/dev/null', 'r');
        
        
        $this->time_file = $baseDir.'/run/'.$this->name.'.time';
        $this->pid_file = $baseDir.'/run/'.$this->name.'.pid';
        
        if($this->pid_exists()){
            $this->is_running = true;
        }
    }
    
    protected function init_log(){
        $this->log = fopen(dirname(__FILE__).'/log/'.$this->name.'.application.log', 'ab');
    }
    
    //protected function before_start(){}
    
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
        
        //pcntl_signal(SIGHUP, SIG_IGN);
        //pcntl_signal(SIGHUP, SIG_DFL);
        
        
        
        
        
        $this->do_job();
     
    }
    
    
    protected function pid_exists(){
        /** @todo set const */
        
        if (is_readable($this->pid_file)) {
            $pid = (int)file_get_contents($this->pid_file);
            
            if ($pid > 0 && posix_kill($pid, 0)) {
                if (is_readable($this->time_file)) { 
                    $this->start_time = (int)file_get_contents($this->time_file);
                }
                
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
            
            if (!file_put_contents($this->time_file, time())) {
                $this->say("Can't create time file...");
                //exit;
            }
            
            $this->say("Started  - pid ".$pid." ".date('[d-M-Y H:i:s]', time()));
        }
        
    }
    
    protected function del_pid(){
        
        /** @todo Compare deleted .pid file with posix_getpid()*/
        
        if (is_writable($this->pid_file)) {
            $pid = (int)file_get_contents($this->pid_file);
            
            /** @todo consider split cause*/
            if ($pid > 0 && posix_kill($pid, SIGTERM)) {
                $this->say("Stopped!");
                
                if (!unlink($this->pid_file)) {
                    $this->say("Pid delete failed");
                    //exit;
                }
                
                if (!unlink($this->time_file)) {
                    $this->say("Timefile delete failed");
                    //exit;
                }else{
                    $this->say("Timefile deleted - ".$pid);
                }
                
                $this->is_running = false;
                //exit;
            }else{
                $this->say("Not stopped...");
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
    
    abstract protected function do_job();
    
    public function status(){
        if($this->pid_exists()){
            $this->say("Running");
        }else{
            $this->say("Not running");
        }
    }
    
    protected function say($phrase, $logging = true){
        $phrase = "Daemon: ".$phrase;
        
        echo $phrase."\n";
        
        if($logging){
            $this->log($phrase);
        }
    }
    
    protected function log($msg){
        $msg = date('[d-M-Y H:i:s] ',time()).$msg;
        
        if(!is_resource($this->log)){$this->init_log();}
        
        fwrite($this->log, $msg."\n");
    }
    
    protected function error($msg){
        
        // Here some actions, for example, send mail.
        
        error_log($msg);
    }
    
    public function error_handler($errorCode, $errorMessage, $errorFile, $errorLine) {
        throw new CustomException($errorMessage, $errorLine, $errorFile, $errorCode);
    }
    
    public function sig_handler($signo){
        echo "usr sig\n";
    }
    
}