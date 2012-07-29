<?php 
	//Broadcast
	// socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1); 
	$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	      //socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	$msg = $argv[1];
	$len = strlen($msg);
	socket_sendto($sock,$msg,$len,0,"localhost",89);
	socket_close($sock);
?> 