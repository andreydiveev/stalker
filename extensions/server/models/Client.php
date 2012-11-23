<?php

/**
 * Client model 
 */


 
class Client extends CModel{
    
    public $id;
    public $socket;
    public $name;
    
    public $host;
    public $port;
    
    public $buffer;
    
    /**
	 * Constructor.
	 * @param string $scenario name of the scenario that this model is used in.
	 * See {@link CModel::scenario} on how scenario is used by models.
	 * @see getScenario
	 */
	public function __construct($socket = null, $scenario='')
	{
		$this->setScenario($scenario);
		$this->init($socket);
		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();
        
        $this->say("New client created");
	}

	/**
	 * Initializes this model.
	 * This method is invoked in the constructor right after {@link scenario} is set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 */
	public function init($socket = null){
        
        $this->socket = $socket;
        
        if($this->socket !== null){
            try{
                socket_getpeername($this->socket, $this->host, $this->port);
                $this->say("Init client [".$this->host.":".$this->port."]");
            }catch(CustomException $e){
                $this->say("Init client [CustomException] Can't get peer name of client: ".$e->getMessage());
            }catch(Exception $e){
                $this->say("Init client. Can't get peer name of client: ".$e->getMessage());
            }
        }else{
            $this->say("Init client (no socket)");
        }
	}
    
    /**
	 * This method is invoked after a model instance is created by new operator.
	 * The default implementation raises the {@link onAfterConstruct} event.
	 * You may override this method to do postprocessing after model creation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterConstruct($q = null)
	{
	}
    
    public function attributeNames(){
        return array(
            'id',
            'socket',
            'name',
            'host',
            'port',
        );
    }
    
    public function disconnect(){
        try{
            socket_close($this->socket);
        }catch(CustomException $e){
            $this->say("[CustomException] Can't close client socket: ".$e->getMessage());
        }catch (Exception $e){
            $this->say("Can't close client socket: ".$e->getMessage());
        }
    }
    
    public function send($msg){
        $msg .= "\n";
        try{
            socket_write($this->socket, $msg, strlen($msg));
        }catch(CustomException $e){
            $this->say("[CustomException] Can't send message to client: ".$e->getMessage());
        }catch (Exception $e){
            $this->say("Can't send message to client: ".$e->getMessage());
        }
    }
    
    public function read(){
        
        try{
            $this->buffer = socket_read($this->socket, 1024);
        }catch(CustomException $e){
            $this->say("[CustomException] Can't read message from client: ".$e->getMessage());
        }catch (Exception $e){
            $this->say("Can't read message from client: ".$e->getMessage());
        }
        
        return $this->buffer;
    }
    
    public function say($msg){
        echo "Client: ".$msg."\n";
    }
    
}