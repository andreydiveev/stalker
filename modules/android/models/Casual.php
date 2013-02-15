<?php

class Casual{
    const PLAYER_PREFIX     = 'player:';
	const SUGESSTION_PREFIX = 'suggest:';
	const OPEROTOR_TO 	    = 'to:';
	const OPEROTOR_FROM 	= 'from:';
	const GAME_PREFIX 	    = 'game:';
	const STROKES_PREFIX	= 'strokes:';
	const MAP_PREFIX		= 'maps:';
	
	const SYMBOL_PLAYER_A 	= 'O';
	const SYMBOL_PLAYER_B 	= 'X';
	
	const TABLE_WIDTH 		= 3;
	const TABLE_HEIGHT 		= 3;
	const WIN_CAPACITY		= 3;
	
	const GAME_STATE_NOBODY_WIN_YET = 'nobody_win_yet';
	const GAME_STATE_PLAYER_WIN 	= 'player_win';
	const GAME_STATE_WIN_WIN		= 'win_win';
	
	const VK_USER_PREFIX	= 'vk_user:';
}

?>