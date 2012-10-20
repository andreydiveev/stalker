<?php

Yii::import('application.vendors.Rediska.library.Rediska');

class RediskaConnection
{
    public $options = array();

    private $_rediska;


    public function init()
    {
        $this->_rediska = new Rediska($this->options);
    }

    // create if not exist
    public function getList($name){
        return new Rediska_Key_List($name);
    }


    public function getConnection()
    {
        return $this->_rediska;
    }
}