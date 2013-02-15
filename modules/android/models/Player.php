<?php

class Player{
    
    const PREFIX     = 'player:';
	static public $current;
	
	// VK data
	static public $viewer_id;
	static public $first_name;
	static public $last_name;
	
    static public function getId(){
        if(isset(Yii::app()->request->cookies['uid'])){
			$uid = Yii::app()->request->cookies['uid']->value;
		}else{
            $uid = null;
        }
        
        return $uid;
    }
    
    static public function getIdWithPrefix($id = null){
        /** @TODO make multiplayer getter */
        return Casual::PLAYER_PREFIX.Player::getId();
    }
    
    /** Check for player is in game */
    static public function getSymbol($uid){
		$Redis = Yii::app()->RediskaConnection->getConnection();
		$gid = $Redis->get(Casual::PLAYER_PREFIX.$uid);
		
		$game = $Redis->getset(Casual::GAME_PREFIX.$gid);
        $symbol = '';
		foreach($game as $player){
			if($player == $uid){
				$symbol = Casual::SYMBOL_PLAYER_A;
			}else{
				$symbol = Casual::SYMBOL_PLAYER_B;
			}
			break;
		}
		
		return $symbol;
	}
    
    static public function exitFromGame(){
		$Redis = Yii::app()->RediskaConnection->getConnection();
        $Redis->deletefromset(Player::getGameWithPrefix(), Player::getId());
        $Redis->set(Player::getIdWithPrefix(), 0);
    }
    
    static public function getGameWithPrefix($id = null){
        if($id === null){
            $id = Player::getIdWithPrefix();
        }
        
		$Redis = Yii::app()->RediskaConnection->getConnection();
        
        return Casual::GAME_PREFIX.$Redis->get($id);
    }
	
	static public function current(){
		return Player::$current;
	}
	
	static public function set_viewer_id($viewer_id){
		
		if(!empty($viewer_id) && Player::$viewer_id == null){
			Player::$viewer_id = $viewer_id;
			
			$Redis = Yii::app()->RediskaConnection->getConnection();
			$Redis->addtoset(Casual::VK_USER_PREFIX.Player::$viewer_id,array('viewer_id'=>$viewer_id));
			$Redis->addtoset(Casual::VK_USER_PREFIX.Player::$viewer_id,array('casual_cookie'=>Player::getId()));
		}
	}
	
	static public function setFirstName($first_name){
		Player::$first_name = $first_name;
		
		if(!empty(Player::$viewer_id)){
			$Redis = Yii::app()->RediskaConnection->getConnection();
			$Redis->addtoset(Casual::VK_USER_PREFIX.Player::$viewer_id,array('first_name'=>$first_name));
		}
	}
	
	static public function setLastName($last_name){
		Player::$last_name = $last_name;
		
		if(isset(Player::$viewer_id)){
			$Redis = Yii::app()->RediskaConnection->getConnection();
			$Redis->addtoset(Casual::VK_USER_PREFIX.Player::$viewer_id,array('last_name'=>$last_name));
		}
	}
	
}