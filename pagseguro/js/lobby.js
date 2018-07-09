var pusher = new Pusher('40415e4e25c159832d51', {
	cluster: 'us2'
});

function conectarLobby(codLobby, codJogador){
	var channel = pusher.subscribe('lobby'+codLobby+'');	
	channel.bind("attEquipe", function(resultado){
		$.ajax({
			type: "POST",
			url: "scripts/funcoes-lobby.php",
			data: "funcao=16&codequipe="+resultado['codequipe'],
			success: function(equipe){
				$(".equipe"+resultado['codequipe']).html(equipe);
			}
		});
	});	
	
	channel.bind("attSlots", function(resultado){
		$(".slotsTxt").html(resultado['atual']+" / "+resultado['max']);
	});	
	
	channel.bind("attPote", function(resultado){
		$(".valorPote").html("<img src='../img/icones/escoin.png' alt='' class='iconeCoin'>"+resultado['valor']);
	});
	
	channel.bind("atualizar", function(resultado){
		setTimeout(function(){
			location.reload();
		}, 500);		
	});	
	channel.bind(""+codJogador+"", function(resultado){
		setTimeout(function(){
			location.reload();
		}, 500);		
	});	
	channel.bind("sair", function(resultado){
		setTimeout(function(){
			window.location.href = "jogar/dota2/";
		}, 500);
	});
}
function conectarChatEquipe(codEquipe, codJogador){
	var channel2 = pusher.subscribe('chatequipe'+codEquipe+'');
	channel2.bind("atualizarChat", function(resultado){
		carregarMsgEquipe(codEquipe, codJogador);
	});
}
function desconectarChatEquipe(codEquipe){
	var channel2 = pusher.unsubscribe('chatequipe'+codEquipe+'');
}

function conectarChatGeral(codLobby, codJogador){
	var channel2 = pusher.subscribe('chatlobby'+codLobby+'');
	channel2.bind("atualizarChat", function(resultado){
		carregarMsgGeral(codLobby, codJogador);
	});	
}
function desconectarChatGeral(codLobby){
	var channel2 = pusher.unsubscribe('chatlobby'+codLobby+'');
}

