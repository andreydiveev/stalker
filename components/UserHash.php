<?php

class UserHash extends Rediska_Key_Hash
{
    public function __construct($id)
    {
        parent::__construct("users:$id");
    }
}
