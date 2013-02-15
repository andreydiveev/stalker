

<script type="text/javascript">
    $(function(){
        $(".btn").click(function(){
			var cell = $(this);
			$.ajax({
				type: 'POST',
				url : '/android/play/stroke',
				data: 'cell='+cell.attr('id'),
				dataType: 'json',
				success: function(data){
					if(data.status == 'success'){
						cell.html(data.self_symbol);
					}
				}
			});
		});
    });
</script>
<style type="text/css">
	#game_table{
		width:100px;
		margin:0px auto;
	}
	#game_table tr td{
		padding:4px;
	}
	.btn{
		outline:none;
		border:none;
		box-shadow:0px 0px 2px 0px rgba(0, 0, 0, 0.3);
		text-decoration:none;
		background: 
		-webkit-transition: 400ms all ease;
		-moz-transition: 400ms all ease;
		-ms-transition: 400ms all ease;
		-o-transition: 400ms all ease;
		transition: 400ms all ease;
		width:30px;
		height:30px;
		cursor:pointer;
		font-family: Verdana;
		font-size:17pt;
		font-weight:bold;
	}
	.btn:hover{
		box-shadow:0px 0px 5px 1px rgba(0, 0, 0, 0.3);
		-webkit-transition: 400ms all ease;
		-moz-transition: 400ms all ease;
		-ms-transition: 400ms all ease;
		-o-transition: 400ms all ease;
		transition: 400ms all ease;
		background:white;
	}
	h3{
		text-align:center;
		font-size:12pt;
		font-family:Verdana;
		padding-top:10px;
		text-shadow:0px 0px 3px rgba(3, 215, 255, 0.5);
	}
	.red_button{
		color:rgb(173, 21, 21);
		text-shadow:0px 0px 4px rgba(173, 21, 21, 0.5);
		-webkit-transition: 700ms all ease;
		-moz-transition: 700ms all ease;
		-ms-transition: 700ms all ease;
		-o-transition: 700ms all ease;
		transition: 700ms all ease;
	}
	.blue_button{
		color:rgb(28, 28, 136);
		text-shadow:0px 0px 4px rgba(28, 28, 136, 0.5);
		-webkit-transition: 700ms all ease;
		-moz-transition: 700ms all ease;
		-ms-transition: 700ms all ease;
		-o-transition: 700ms all ease;
		transition: 700ms all ease;
	}
	#clear_game{
		text-align:center;
		font-family: Verdana;
		font-size:17pt;
		font-weight:bold;
		display:block;
		margin:20px auto 10px auto;
		text-decoration:none;
		color:#ccc;
	}
	#close_x{
		font-weight:bold;
		color:rgb(173, 21, 21);
		font-family:Comic sans ms;
	}
	#your_symbol{
		text-align:center;
		font-size:10pt;
		font-family:Verdana;
		text-shadow:0px 0px 3px rgba(3, 215, 255, 0.5);
		margin-bottom:10px;
	}
</style>
<table cellpadding="0" cellspacing="0" id="game_table">
    <? for($i=0;$i<Casual::TABLE_HEIGHT;$i++):?>
        <tr>
            <? for($j=0;$j<Casual::TABLE_WIDTH;$j++):?>
                <td>
                    <button class="btn" id="index_<?=$i?>_<?=$j?>"></button>
                </td>
            <? endfor;?>
        </tr>
    <? endfor;?>
</table>