<?php

/**
 * Client model 
 */


 
class Client extends CModel{
    
    public $id;
    public $socket;
    public $name;
    
    public $buffer;
    
    /**
	 * Constructor.
	 * @param string $scenario name of the scenario that this model is used in.
	 * See {@link CModel::scenario} on how scenario is used by models.
	 * @see getScenario
	 */
	public function __construct($scenario='')
	{
		$this->setScenario($scenario);
		$this->init();
		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();
	}

	/**
	 * Initializes this model.
	 * This method is invoked in the constructor right after {@link scenario} is set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 */
	public function init()
	{
	}
    
    /**
	 * This method is invoked after a model instance is created by new operator.
	 * The default implementation raises the {@link onAfterConstruct} event.
	 * You may override this method to do postprocessing after model creation.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterConstruct()
	{
		echo "Client: New client created\n";
	}
    
    public function attributeNames(){
        return array(
            'id',
            'socket',
            'name',
        );
    }
    
    public function disconnect(){
        socket_close($this->socket);
    }
    
    public function send($msg){
        $msg .= "\n";
        try{
            socket_write($this->socket, $msg, strlen($msg));
        }catch(WarningException $e){
            echo "can't write..\n";
        }catch (Exception $e){
           echo "error catched2200\n";
        }
    }
    
    public function read(){
        
        try{
            $this->buffer = socket_read($this->socket, 2048, PHP_NORMAL_READ);
        }catch(WarningException $e){
            echo "can't read..\n";
        }catch (Exception $e){
           echo "error catched22\n";
        }
        
        return $this->buffer;
    }
    
}