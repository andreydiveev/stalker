<?php

interface Daemonic {
    
    public function start();
    public function stop();
    public function status();
    
}