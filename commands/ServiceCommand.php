<?php

/**
 * Service for manage the Game Server
 * @author Andrey Diveev <andrey.diveev@gmail.com>
 * @version 0.1
 * @date 18.11.2012 4:24
 */
class ServiceCommand extends CConsoleCommand{
    public function actionIndex(){
        echo "Welcome to service for manage server!\n";
        
        echo "Use options:\n";
            $s = "   - ";
            echo $s."start\n";
            echo $s."stop\n";
            echo $s."restart\n";
            echo $s."status\n";
            echo $s."configtest\n";
            echo $s."ping\n";
            echo $s."uptime\n";
            echo $s."monitor\n";
            echo $s."log\n";
            echo $s."get_servers\n";
            echo $s."help\n";
        echo "\n";
    }
    
    public function actionPing(){
        echo "Ping server...\n";
    }
    
    public function actionGet_Servers(){
        echo "Get servers...\n";
        
    }
    
    public function actionConfigTest(){
        echo "Test server config...\n";
    }
    
    public function actionStop(){
        echo "Stop server...\n";
        
        Yii::app()->server->stop();
    }
    
    public function actionUptime(){
        echo "Servers uptime...";
    }
    
    public function actionMonitor(){
        //var_dump(STDIN);
        echo "Server monitor...\n";
    }
    
    public function actionLog(){
        echo "Server log...\n";
    }
    
    public function actionRestart(){
        if(!Yii::app()->server->is_running){
            echo "Server not running.\n";
            exit;
        }
        
        echo "Restarting server...\n";
        
        echo "Stop server... \n";
        if(!Yii::app()->server->stop()){
            echo "Failure!\n";
        }
        
        if(!Yii::app()->server->is_running){
            echo "Start server... \n";
            Yii::app()->server->start();
            if(Yii::app()->server->is_running){
                echo "Failure!\n";
            }
        }
    }
    
    public function actionStart(){
        echo "Start server...\n";
        
        $server_instance = Yii::app()->server->start();
    }
    
    public function actionStatus(){
        echo "Server status...\n";
        
        print(Yii::app()->server->status());
    }
    
    public function actionHelp(){
        echo "Service help info...\n";
    }
}    