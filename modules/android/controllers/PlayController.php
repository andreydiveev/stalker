<?php
/**
 * tic-tac-toe
 */
class PlayController extends Controller{
	
	protected $uid;
	protected $Redis;
	
	public $layout = 'casual';
	
	public function actionIndex()
	{
		$this->checkin();
		
		$gid  = $this->Redis->get(Player::getIdWithPrefix());
		$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
		
		$oponent = '';
		
		foreach($game as $player){
			if($player == Player::getId()){continue;}
			$oponent = $this->getPlayerAutoNickById($player);
		}
		
		$this->render('index', array('oponent'=>$oponent));
	}
	
	public function actionExit(){
		Player::exitFromGame();
		
		$this->redirect('/android/casual');
	}
	
	public function actionStroke(){
		if($cell = Yii::app()->request->getParam('cell')){
			$uid = $this->checkin();
			
			$gid = $this->Redis->get(Player::getIdWithPrefix());
			$game_state = $this->getGameState($gid);
			
			if($game_state['id'] == Casual::GAME_STATE_NOBODY_WIN_YET){
				
				$map = $this->getMap($gid);
				
				$cell = explode('_',$cell);
				unset($cell[0]);
				
				if(!isset($map[$cell[1]][$cell[2]])){
					print(json_encode(array('status'=>'index_error')));
					return;
				}
				
				if($map[$cell[1]][$cell[2]] != 0){
					print(json_encode(array('status'=>'not_empty', 'cell_index'=>array($cell[1],$cell[2]), 'cell_owner'=>$uid)));
					return;
				}
				
				$log_id = Casual::STROKES_PREFIX.Casual::GAME_PREFIX.$gid;
				$log = $this->Redis->getlist($log_id);
				
				
				if(count($log) > 0){
					$last_stroke = json_decode($log[count($log)-1]);
					if($last_stroke->uid == Player::getId()){
						print(json_encode(array('status'=>'out_of_turn')));
						return;
					}
				}else{
					$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
					
					foreach($game as $player){
						if($player == Player::getId()){
							print(json_encode(array('status'=>'out_of_turn')));
							return;
						}
						break;
					}
				}
				
				$gid = $this->Redis->get(Casual::PLAYER_PREFIX.$uid);
				$log_id = Casual::STROKES_PREFIX.Casual::GAME_PREFIX.$gid;
				$this->Redis->appendtolist($log_id, array('uid'=>$uid, 'i'=>$cell[1],'j'=>$cell[2]));
				
				$map[$cell[1]][$cell[2]] = $uid;
				$this->Redis->set(Casual::MAP_PREFIX.$gid, $map);
				
				print(json_encode(array(
					'status'=>'success',
					'self_symbol'=>$this->getPlayerSymbol(Player::getId()),
					'game_state'=>$this->gameStatus($gid),
				)));
				
			}else{
				print(json_encode(array(
					'status'=>'game_over',
					'self_symbol'=>$this->getPlayerSymbol(Player::getId()),
					'game_state'=>$this->gameStatus($gid),
				)));
			}
			
			
		}else{
			print(json_encode(array('status'=>'error4')));
		}
	}
	
	public function actionGetInfo(){
		if($var2 = Yii::app()->request->getParam('var2')){
			
			if(!$this->checkin()){
				print(json_encode(array(
					'status'=>'redirect',
					'url'=>'/android/casual',
				)));
				return;
			}
			
			$gid = $this->Redis->get(Player::getIdWithPrefix());
			$log_id = Casual::STROKES_PREFIX.Casual::GAME_PREFIX.$gid;
			$log = $this->Redis->getlist($log_id);
			
			if(count($log) > 0){
				$last_stroke = json_decode($log[count($log)-1]);
				if($last_stroke->uid == Player::getId()){
					$queue = 'waiting_oponent';
				}else{
					$queue = 'ready_for_stroke';
				}
			}else{
				$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
				
				foreach($game as $player){
					if($player == Player::getId()){
						$queue = 'waiting_oponent';
					}else{
						$queue = 'ready_for_stroke';
					}
					break;
				}
			}
			
			$map = $this->Redis->get(Casual::MAP_PREFIX.$gid);
			
			print(json_encode(array(
				'status'=>'success',
				'queue'=>$queue, 
				'map'=>$map,
				'self_uid'=>Player::getId(),
				'self_symbol'=>$this->getPlayerSymbol(Player::getId()),
				'oponent_symbol'=>Player::getSymbol($this->getOponent(Player::getId())),
				'last_stroke'=>$this->getLastStroke($gid),
				'game_state'=>$this->gameStatus($gid),
			)));
			
			
		}else{
			print(json_encode(array('status'=>'error')));
		}
	}
	
	protected function checkin(){
		if(Player::getId() === null){
			$this->redirect('/android/casual');
		}else{
			if($this->Redis->get(Player::getIdWithPrefix()) != 0){
				$this->Redis->pipeline()->set(Player::getIdWithPrefix(), $this->Redis->get(Player::getIdWithPrefix()))->expire(Player::getIdWithPrefix(), 10)->execute();
				
			}else{
				return false;
			}
		}
		
		/** @TODO remove */
		return Player::getId();
	}

	public function getPlayerAutoNickById($id){
		$autonick = 'Игрок-'.substr($id, 0, 3);
		return $autonick;
	}
	
	// Uncomment the following methods and override them if needed
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'setRedisAlias',
			/*array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),*/
		);
	}

	public function filterSetRedisAlias($filterChain){
		$this->Redis = Yii::app()->RediskaConnection->getConnection();
		
		$filterChain->run();
	}
	
	
	/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
	
	
	public function getPlayerSymbol($uid){
		$gid = $this->Redis->get(Casual::PLAYER_PREFIX.$uid);
		
		$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
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
	
	public function getOponent($uid){
		$gid = $this->Redis->get(Casual::PLAYER_PREFIX.$uid);
		
		$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
		
		foreach($game as $player){
			if($player != Player::getId()){
				return $player;
			}
		}
	}
	
	
	/**************/
	/* GAME LOGIC */
	/**************/
	
	public function gameStatus($gid){
		$state = $this->getGameState($gid);
		
		switch($state['id']){
			case Casual::GAME_STATE_NOBODY_WIN_YET:{
				$status = 'nobody_win_yet';
				break;
			}
			case Casual::GAME_STATE_PLAYER_WIN:{
				$status = 'Player "'.Player::getSymbol(Player::getId()).'" - win !';
				break;
			}
			case Casual::GAME_STATE_WIN_WIN:{
				$status = 'win_win';
				break;
			}
			default:{
				$status = 'unknown_game_state';
				break;
			}
		}
		
		return $status;
	}
	
	public function getGameState($gid){
		
		$map = $this->getMap($gid);
		
		$last_stroke = $this->getLastStroke($gid);
		
		$win = 0;
		
		/* Check on horizontal nad vertical */
		$game = $this->Redis->getset(Casual::GAME_PREFIX.$gid);
		
		foreach($game as $player){
			if($this->checkMapHorizontalVertial($map, $player) || $this->checkMapDiagonals($map, $player)){
				return array('id'=>Casual::GAME_STATE_PLAYER_WIN, 'uid'=>$player);
			}
		}
		
		$fulfill = true;
		
		foreach($map as $i){
			foreach($i as $j){
				if($j == 0){
					$fulfill = false;
				}
			}
		}
		
		if($fulfill){
			return array('id'=>Casual::GAME_STATE_WIN_WIN);
		}else{
			return array('id'=>Casual::GAME_STATE_NOBODY_WIN_YET);
		}
	}
	
	public function checkMapHorizontalVertial($map, $uid){
		for($i=0;$i<Casual::TABLE_HEIGHT;$i++){
			$hor = 0;
			$ver = 0;
			for($j=0;$j<Casual::TABLE_WIDTH;$j++){
				$h_cell = $map[$i][$j];
				$v_cell = $map[$j][$i];
				
				if($map[$i][$j] === $uid){
					$hor++;
				}
				if($map[$j][$i] === $uid){
					$ver++;
				}
				
				if ($hor == Casual::WIN_CAPACITY || $ver == Casual::WIN_CAPACITY)
                {
                    return true;
                }
			}
		}
		
		return false;
	}
	
	public function checkMapDiagonals($map, $uid){
		$main_diagonal = 0;
		$sub_diagonal  = 0;
		
		for($i=0;$i<Casual::TABLE_HEIGHT;$i++){
			if($map[$i][$i] === $uid){
				$main_diagonal++;
			}
			if($map[$i][(Casual::TABLE_HEIGHT-1) - $i] === $uid){
				$sub_diagonal++;
			}
			
			if ($main_diagonal == Casual::WIN_CAPACITY || $sub_diagonal == Casual::WIN_CAPACITY)
			{
				return true;
			}
		}
		
		return false;
	}
	
	public function getLastStroke($gid){
		
		$log_id = Casual::STROKES_PREFIX.Casual::GAME_PREFIX.$gid;
		$log = $this->Redis->getlist($log_id);
		
		if(count($log) > 0){
			return $log[count($log)-1];
		}else{
			return null;
		}
	}
	
	public function getMap($gid){
		$map = $this->Redis->get(Casual::MAP_PREFIX.$gid);
		
		if($map === null){
			$map = array();
			
			for($i=0;$i<Casual::TABLE_HEIGHT;$i++){
				for($j=0;$j<Casual::TABLE_WIDTH;$j++){
					$map[$i][$j] = 0;
				}
			}
			
			$this->Redis->set(Casual::MAP_PREFIX.$gid, $map);
		}
		
		if(is_string($map)) $map = json_decode($map);
		
		return $map;
	}
}