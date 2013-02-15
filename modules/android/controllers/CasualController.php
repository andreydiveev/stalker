<?php

/**
 * @TODO Set prefilter with Redis connection property setting
 */

class CasualController extends Controller
{
	const PLAYER_PREFIX 	= 'player:';
	const SUGESSTION_PREFIX = 'suggest:';
	const OPEROTOR_TO 		= 'to:';
	const OPEROTOR_FROM 	= 'from:';
	const GAME_PREFIX 		= 'game:';
	
	public $layout = 'casual';
	public $Redis;
	protected $uid = null;
	
	/**
	 * GUI
	 * Displays players list for choose oponents
	 */
	public function actionIndex()
	{
		
		//Player::$current = new Player;
		
		/*	received params via GET
		 *	
			api_url
			api_id
			api_settings
			viewer_id
			viewer_type
			sid
			secret
			access_token
			user_id
			group_id
			is_app_user
			auth_key
			language
			parent_language
			ad_info
			referrer
			lc_name
			hash
		*/
		
		
		
		
		
		$uid  = $this->checkin();
		$keys = $this->getPlayersList(); 
		
		//Yii::app()->RediskaConnection->getConnection()->addtoset('usuggef:esa:st',array('saf'=>'wefwhhhht'));
		//Yii::app()->RediskaConnection->getConnection()->appendToList('usuggesast',array('wefw'=>'cvsdvsd'));
		//var_dump(Yii::app()->RediskaConnection->getConnection()->getFromList('usuggesast',''));
		//var_dump(Yii::app()->RediskaConnection->getConnection()->getFromList('usuggesast','cvsdvsd'));
		
		//Yii::app()->RediskaConnection->getConnection()->set('tttt:wef:efw','vv_vv_v222');
		//Yii::app()->RediskaConnection->getConnection()->pipeline()->set('tttt','vvvvv')->expire('tttt', 100)->execute();
		//Yii::app()->RediskaConnection->getConnection()->delete('tttt');
		
		
		$this->render('index', array('uid'=>$uid,'keys'=>$keys));
	}

	
	/**
	 * INTERNAL
	 * Loads a list of invites for specified player
	 */
	protected function getInvitesForPlayer($id){
		//select all sugesstions to player
		$pattern =
			CasualController::SUGESSTION_PREFIX.
			CasualController::OPEROTOR_TO.$id
		;
		$records = Yii::app()->RediskaConnection->getConnection()->getkeysbypattern($pattern);
		
		$suggestions = array();
		foreach($records as $s){
			$set = Yii::app()->RediskaConnection->getConnection()->getset($s);
			foreach($set as $i){
				if($this->availablePlayer($i)){
					$suggestions[] = $i;
				}
			}
		}
		
		return $suggestions;
	}
	
	/**
	 * INTERNAL
	 * Loads sended invites from player
	 */
	protected function getSugesstionsFromPlayer($id){
		//select all sugesstions from player
		$pattern =
			CasualController::SUGESSTION_PREFIX.
			CasualController::OPEROTOR_FROM.$id
		;
		$records = Yii::app()->RediskaConnection->getConnection()->getkeysbypattern($pattern);
		
		$suggestions = array();
		foreach($records as $s){
			$set = Yii::app()->RediskaConnection->getConnection()->getset($s);
			foreach($set as $i){
				if($this->availablePlayer($i)){
					$suggestions[] = $i;
				}
			}
		}
		
		return $suggestions;
	}
	
	/**
	 * AJAX
	 * Cancel sended invite by invite id
	 */
	public function actionCancelInvite(){
		if(($id = Yii::app()->request->getParam('id')) && $this->cancelInvite($this->checkin(), $id)){
			print(json_encode(array('status'=>'success')));
		}else{
			print(json_encode(array('status'=>'error')));
		}
	}
	
	/**
	 * AJAX
	 * Do invite
	 */
	public function actionInvite(){
		if(($id = Yii::app()->request->getParam('id')) && $this->invite($this->checkin(), $id)){
			print(json_encode(array('status'=>'success')));
		}else{
			print(json_encode(array('status'=>'error')));
		}
	}
	
	/**
	 * AJAX
	 * Processing invite accepting 
	 */
	public function actionAccept(){
		if(($id = Yii::app()->request->getParam('id')) && $this->acceptInviting($id, $this->checkin())){
			print(json_encode(array('status'=>'success')));
		}else{
			print(json_encode(array('status'=>'error')));
		}
	}
	
	public function acceptInviting($from, $to){
		if($this->availablePlayer($to) && $this->has_invite($from, $to)){
			
			$gid = md5(time().rand(1,10000));
			
			$Redis = Yii::app()->RediskaConnection->getConnection();
			
			$Redis->addtoset(CasualController::GAME_PREFIX.$gid,$from);
			$Redis->addtoset(CasualController::GAME_PREFIX.$gid,$to);
			
			
			$Redis->set(CasualController::PLAYER_PREFIX.$from, $gid); 
			$Redis->set(CasualController::PLAYER_PREFIX.$to, $gid); 
			
			$this->cancelInvite($from, $to);
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * @TODO Refactor - use single place for saving suggestions. Add method for removing data from user set
	 */
	protected function cancelInvite($from, $to){
		if($this->availablePlayer($to) && $this->has_invite($from, $to)){
			$pattern =
				CasualController::SUGESSTION_PREFIX.
				CasualController::OPEROTOR_FROM.$from
			;
			
			$records = Yii::app()->RediskaConnection->getConnection()->getkeysbypattern($pattern);
			
			foreach($records as $s){
				$set = Yii::app()->RediskaConnection->getConnection()->getset($s);
				foreach($set as $i){
					if(($i == $to) && Yii::app()->RediskaConnection->getConnection()->deletefromset($s, $i)){
						if(Yii::app()->RediskaConnection->getConnection()->getsetlength($s) == 0){
							Yii::app()->RediskaConnection->getConnection()->delete($s);
						}
						
						$_from_deleted = true;
					}
				}
			}
			
			$pattern =
				CasualController::SUGESSTION_PREFIX.
				CasualController::OPEROTOR_TO.$to
			;
			
			$records = Yii::app()->RediskaConnection->getConnection()->getkeysbypattern($pattern);
			
			foreach($records as $s){
				$set = Yii::app()->RediskaConnection->getConnection()->getset($s);
				foreach($set as $i){
					if($_from_deleted && ($i == $from) && Yii::app()->RediskaConnection->getConnection()->deletefromset($s, $i)){
						if(Yii::app()->RediskaConnection->getConnection()->getsetlength($s) == 0){
							Yii::app()->RediskaConnection->getConnection()->delete($s);
						}
						
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	
	protected function invite($from, $to){
		if($this->availablePlayer($to) && !$this->has_invite($from, $to)){
			$key =
				CasualController::SUGESSTION_PREFIX.
				CasualController::OPEROTOR_FROM.$from
			;
			
			Yii::app()->RediskaConnection->getConnection()->addtoset($key,$to);
			
			$key =
				CasualController::SUGESSTION_PREFIX.
				CasualController::OPEROTOR_TO.$to
			;
			Yii::app()->RediskaConnection->getConnection()->addtoset($key,$from);
			
			return true;
		}else{
			return false;
		}
	}
	
	protected function has_invite($from, $to){
		//select invite from player to player
		$pattern =
			CasualController::SUGESSTION_PREFIX.
			CasualController::OPEROTOR_FROM.$from
		;
		$rec = Yii::app()->RediskaConnection->getConnection()->getkeysbypattern($pattern);
		
		if(count($rec) > 0){
			foreach($rec as $k){
				if(($set = Yii::app()->RediskaConnection->getConnection()->getset($k)) && count($set) > 0){
					foreach($set as $i){
						if($i == $to){
							return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * AJAX
	 * Requests info object with currently state
	 */
	public function actionGetInfo(){
		if($var1 = Yii::app()->request->getParam('var1')){
			
			$this->checkin();
			
			$first_name = Yii::app()->request->getParam('first_name');
			$last_name  = Yii::app()->request->getParam('last_name');
			
			
			if(!empty($first_name) && !empty($last_name)){
				Player::setFirstName($first_name);
				Player::setLastName($last_name);
			}
			
			if(Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$this->uid) == 0){
				print(json_encode(array(
					'status'=>'awaiting',
					'players_list'=>(array)$this->getPlayersList(),
					'uid'=>$this->uid, // @TODO unused
					'suggestions' => $this->getSugesstionsFromPlayer($this->uid),
					'invites' => $this->getInvitesForPlayer($this->uid),
					'uid_val' => Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$this->uid),
				)));
			}else{
				print(json_encode(array(
					'status'=>'start_game',
					'gid'=>Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$this->uid),
					'uid_val' => Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$this->uid),
				)));
			}
		}else{
			print(json_encode(array('status'=>'error')));
		}
	}
	
	protected function checkin(){
		if(!isset(Yii::app()->request->cookies['uid'])){
			Yii::app()->request->cookies['uid'] = new CHttpCookie('uid', md5(time().rand(1,10000)));
			$uid = Yii::app()->request->cookies['uid']->value;
			Yii::app()->RediskaConnection->getConnection()->pipeline()->set(CasualController::PLAYER_PREFIX.$uid, 0)->expire(CasualController::PLAYER_PREFIX.$uid, 10)->execute();
		}else{
			$uid = Yii::app()->request->cookies['uid']->value;
			
			if(Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$uid) !== null){
				Yii::app()->RediskaConnection->getConnection()->pipeline()->set(CasualController::PLAYER_PREFIX.$uid, Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$uid))->expire(CasualController::PLAYER_PREFIX.$uid, 10)->execute();
			}else{
				Yii::app()->RediskaConnection->getConnection()->pipeline()->set(CasualController::PLAYER_PREFIX.$uid, 0)->expire(CasualController::PLAYER_PREFIX.$uid, 10)->execute();
			}
		}
		
		$this->uid = $uid;
		
		return $uid;
	}
	
	protected function getPlayersList(){
		// select all players
		$records  = $this->Redis->getkeysbypattern(Player::PREFIX.'*');
		$vk_users = $this->Redis->getkeysbypattern(Casual::VK_USER_PREFIX.'*');
		
		$pairs = array();
		foreach($vk_users as $v){
			$t = $this->Redis->getset($v);
			
			$f_name = null;
			$l_name = null;
			$cookie = null;
			
			foreach($t as $tc){
				$prop = json_decode($tc);
				
				if(isset($prop->first_name)){
					$f_name = $prop->first_name;
				}
				
				if(isset($prop->last_name)){
					$l_name = $prop->last_name;
				}
				
				if(isset($prop->casual_cookie)){
					$cookie = $prop->casual_cookie;
				}
			}
			
			if(!is_null($f_name) && !is_null($l_name) && !is_null($cookie)){
				$name = $f_name.' '.$l_name;
				$pairs[$cookie] = $name;
			}
		}
		
		
		
		$keys = array();
		foreach($records as $key=>$val){
			if($val == CasualController::PLAYER_PREFIX.$this->uid){continue;}
			if(Yii::app()->RediskaConnection->getConnection()->get(Player::PREFIX.$val) != 0){continue;}
			$keys[$this->getPlayerIdByAutoNick($val)] = $this->getPlayerIdByAutoNick($val);
		}
		
		foreach($keys as $uid){
			if(isset($pairs[$uid])){
				$keys[$uid] = $pairs[$uid];
			}else{
				continue;
			}
		}
		
		return $keys;
	}
	
	protected function getPlayerIdByAutoNick($val){
		if(($ins = strpos($val, CasualController::PLAYER_PREFIX)) !== false){
			$val = substr($val, $ins+strlen(CasualController::PLAYER_PREFIX), strlen($val));
		}
		return $val;
	}
	
	public function getPlayerAutoNickById($id){
		$autonick = 'Игрок-'.substr($id, 0, 3);
		return $autonick;
	}
	
	public function actionPlayWith(){
		if(($id = Yii::app()->request->getQuery('id')) && $this->availablePlayer($id)){
			$this->render('play', array('oponent'=>$this->getPlayerAutoNickById($id)));
		}else{
			print('error');
		}
	}
	
	protected function availablePlayer($id){
		if(Yii::app()->RediskaConnection->getConnection()->get(CasualController::PLAYER_PREFIX.$id) !== null){
			return true;
		}else{
			return false;
		}
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

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
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'setRedisAlias',
			'setViewerId',
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
	
	
	public function filterSetViewerId($filterChain){
		$viewer_id = Yii::app()->request->getParam('viewer_id');
		
		
		if(!Yii::app()->request->isAjaxRequest && is_numeric($viewer_id)){
			Player::set_viewer_id($viewer_id);
		}elseif(Yii::app()->request->isAjaxRequest && ($viewer_id != "null")){
			Player::set_viewer_id($viewer_id);
		}
		
		$filterChain->run();
	}
}