

<script type="text/javascript" charset="cp1251">
	
	$(function(){
		
		
		
		
		function get_info(){
			$.ajax({
				type: 'POST',
				url: '/android/play/GetInfo',
				data: 'var2=val2',
				dataType: 'json',
				success: function(data){
					
					if(data.status == 'redirect'){
						window.location = data.url;
					}
					
					if(data.queue == 'ready_for_stroke' || data.queue == 'waiting_oponent'){
						var map = eval(data.map);
						$('.btn').each(function(){
							var id = $(this).attr('id');
							var index  = id.split("_");
							var i = index[1];
							var j = index[2];
							if(map[i][j] != 0){
								if(data.self_uid == map[i][j]){
									$(this).html("<span class=\"blue_button\">" + data.self_symbol + "</span>");
								}else{
									$(this).html("<span class=\"red_button\">" + data.oponent_symbol + "</span>");
								}
							}else{
								$(this).html('');
							}
						});
					}
					
					if(data.status == 'awaiting'){
						var players = data.players_list;
						var list = '';
						for(player in players){
							var player_id = players[player];
							
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
				}
			});
		}
		
		get_info();
		
		setInterval(function(){	
			get_info();
		}, 4000);
		
		
	});
	
</script>


<h3>Игра с <?=$oponent?></h3>
<div id="your_symbol">
	Ваш символ: <b><?=Player::getSymbol(Player::getId())?></b>
</div>

<? $this->renderPartial('table');?>

<a href="/android/play/exit" id="clear_game">Выход <span id="close_x">X</span></a>