<?php

require_once dirname(__FILE__).'/../extensions/Rediska/library/Rediska.php';

class RediskaConnection
{
        public $options = array();
        
        private $_rediska;
        
        
        public function init()
        {
                $this->_rediska = new Rediska($this->options);                
        }
        
        
        public function getConnection()
        {
                return $this->_rediska;         
        }
}