<?php

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
    }
    
    public function actionUptime(){
        echo "Server uptime...\n";
    }
    
    public function actionMonitor(){
        echo "Server monitor...\n";
    }
    
    public function actionLog(){
        echo "Server log...\n";
    }
    
    public function actionRestart(){
        echo "Restart server...\n";
    }
    
    public function actionStart(){
        echo "Start server...\n";
    }
    
    public function actionStatus(){
        echo "Server status...\n";
    }
    
    public function actionHelp(){
        echo "Service help info...\n";
    }
}    