<?php

class CustomException extends Exception {
    
    public function __construct($errorMessage, $errorLine, $errorFile, $errorCode = 0, Exception $previous = null) {
        parent::__construct($errorMessage, $errorCode, $previous);
        $this->file = $errorFile;
        $this->line = $errorLine;
    }
    
    public function __toString() {
        $standardMessage = " [".$this->code."]: ".$this->message." in file ".$this->file." on line ".$this->line."\n";
        
        switch($this->code){
            case E_USER_ERROR   : $toString = "E_USER_ERROR".$standardMessage; break;
            case E_USER_WARNING : $toString = "E_USER_WARNING".$standardMessage; break;
            case E_USER_NOTICE  : $toString = "E_USER_NOTICE".$standardMessage; break;
            case E_ERROR        : $toString = "E_ERROR".$standardMessage; break;
            case E_WARNING      : $toString = "E_WARNING".$standardMessage; break;
            case E_PARSE        : $toString = "E_PARSE".$standardMessage; break;
            case E_CORE_ERROR   : $toString = "E_CORE_ERROR".$standardMessage; break;
            case E_NOTICE       : $toString = "E_NOTICE".$standardMessage; break;
            case E_DEPRECATED   : $toString = "E_DEPRECATED".$standardMessage; break;
            case E_ALL          : $toString = "E_ALL".$standardMessage; break;
            case E_STRICT       : $toString = "E_STRICT".$standardMessage; break;
            default             : $toString = "Unknown error number".$standardMessage; break;
        }
      
        return  $toString;
    }
}