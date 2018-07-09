var pusher = new Pusher('40415e4e25c159832d51', {
	cluster: 'us2'
});

function conectarPartida(codPartida){
	var channel = pusher.subscribe('partida'+codPartida+'');	
	channel.bind("atualizar", function(){
		setTimeout(function(){
			location.reload();
		}, 500);
	});
}

function conectarChatEquipe(codEquipe, codJogador, codPartida){
	alert(codEquipe);
	var channel2 = pusher.subscribe('chatequipepartida'+codEquipe+'');
	channel2.bind("atualizarChat", function(resultado){
		carregarMsgEquipe(codEquipe, codJogador, codPartida);
	});
}
function desconectarChatEquipe(codEquipe){
	var channel2 = pusher.unsubscribe('chatequipepartida'+codEquipe+'');
}

function conectarChatOponente(codPartida, codJogador){
	var channel2 = pusher.subscribe('chatpartida'+codPartida+'');
	channel2.bind("atualizarChat", function(resultado){
		carregarMsgOponente(codPartida, codJogador);
	});	
}
function desconectarChatOponente(codPartida){
	var channel2 = pusher.unsubscribe('chatlobby'+codLobby+'');
}