<?php



class CustomException extends Exception {
   public function __construct($message, $errorLevel = 0, $errorFile = '', $errorLine = 0) {
    
    //echo($message);exit;
      parent::__construct($message, $errorLevel, $errorFile, $errorLine);
      $this->file = $errorFile;
      $this->line = $errorLine;
   }
}