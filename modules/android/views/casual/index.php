

<script type="text/javascript">
	
	$(function(){
		
		Casual = {
			var1 		: 'val1',
			first_name 	: null,
			last_name 	: null,
			viewer_id	: null
		}
		
		// узнаём flashVars, переданные приложению GET запросом. Сохраняем их в переменную flashVars
		var parts=document.location.search.substr(1).split("&");
		var flashVars={}, curr;
		
		for (i=0; i<parts.length; i++) {
			curr = parts[i].split('=');
			// записываем в массив flashVars значения. Например: flashVars['viewer_id'] = 1;
			flashVars[curr[0]] = curr[1];
		}
	   
		// получаем viewer_id из полученных переменных
		var viewer_id = flashVars['viewer_id'];
	 
		// выполняем запрос получения профиля
		VK.api("getProfiles", {uids:viewer_id,fields:"photo_big"}, function(data) {
			
			Casual.first_name = data.response[0].first_name;
			Casual.last_name  = data.response[0].last_name;
			Casual.viewer_id  = viewer_id;
			
			//// создаем img, для отображения аватарки
			//var image=document.createElement('img');
			//// из полученных данных берем ссылку на фото
			//image.src=data.response[0].photo_big;
			//// добавляем img в блок user_info
			//user_info.appendChild(image);
		});
		
		
		$(".invite").live("click", function(){
			var player_id = $(this).attr('id');
			$.ajax({
				type: 'POST',
				url : '/android/casual/Invite',
				data: 'id='+$(this).attr('id'),
				dataType: 'json',
				success: function(data){
					if(data.status == 'success'){
						var msg = "<span>You are invite "+'Игрок-'+(player_id.substring(0,3))+
							' [<a href="#" class="cancel_inv" id="'+player_id+'">отмена</a>]<br/></span>'
						;
						$("#log").append(msg);
					}
				}
			});
		});
		
		$(".cancel_inv").live("click", function(){
			$(this).parent().remove();
			$.ajax({
				type: 'POST',
				url : '/android/casual/cancelInvite',
				data: 'id='+$(this).attr('id'),
				dataType: 'json',
				success: function(data){
					if(data.status == 'success'){
						console.log('canceled');
					}
				}
			});
		});
		
		$(".accept_inv").live("click", function(){
			$(this).parent().remove();
			$.ajax({
				type: 'POST',
				url : '/android/casual/accept',
				data: 'id='+$(this).attr('id'),
				dataType: 'json',
				success: function(data){
					if(data.status == 'success'){
						console.log('accepted');
					}
				}
			});
		});
		
		
		
		function get_info(){
			
			if(Casual.viewer_id == null){
				return;
			}
			
			$.post('/android/casual/GetInfo', Casual, function(data){
				
					if(data.status == 'start_game'){
						window.location = '/android/play/';
					}
					
					if(data.status == 'awaiting'){
						var players = data.players_list;
						var list = '';
						
						for(player in players){
							var player_id = players[player];
							
							console.log(players[player]);
							if(players[player] == player){
								list += '<a href="#" class="invite" id="'+player+'">Игрок-'+(player_id.substring(0,3))+'<br/>';
							}else{
								list += '<a href="#" class="invite" id="'+player+'">'+(players[player])+'<br/>';
							}
							
							player_id = null;
						}
						
						if(list != ''){
							$("#players_list").html(list);
						}
						/////
						var log = '';
						var suggestions = data.suggestions;
						
						for(player in suggestions){
							var player_id = suggestions[player];
							log +=
								"<span>You are invite "+'Игрок-'+(player_id.substring(0,3))+
								' [<a href="#" class="cancel_inv" id="'+player_id+'">отмена</a>]<br/></span>'
							;
						}
						/////
						var invites = data.invites;
						
						for(player0 in invites){
							var player_id0 = invites[player0];
							log +=
								"<span>You are invited by "+'Игрок-'+(player_id0.substring(0,3))+
								' [<a href="#" class="accept_inv" id="'+player_id0+'">принять</a>]<br/></span>'
							;
						}
						
						$("#log").html(log);
						log = null;
						player_id0 = null;
						suggestions = null;
						player0 = null;
						invites = null;
						data = null;
					}
				},'json'
			);
		}
		
		get_info();
		
		setInterval(function(){	
			get_info();
		}, 2000);
		
		
	});
	
</script>


<style>
#log{
	margin-top: 20px;
	display:inline-block;
	border:1px solid #ccc;
}
</style>

<?php
$this->breadcrumbs=array(
	'Casual',
);?>
<h1>Игроки</h1>

<div id="players_list">
	<img src="http://www.alfdun.co.za/images/preloader.gif" width="20" height="20"> Поиск игроков...
</div>

<div id="log"></div>

<? /*if(isset($keys) && is_array($keys)):?>
	<? foreach($keys as $index => $key):?>
		<? if($key == $uid){continue;}?>
		<?=Yii::app()->RediskaConnection->getConnection()->get($key)?><br/>
	<? endforeach;?>
<? endif;*/?>


