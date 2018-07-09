<?php
	include "../session.php";
	require __DIR__ . '/vendor/autoload.php';

use johnleider\BattleNet\Requests\BattleNet;

class Account extends BattleNet{

    /**
     * Get User Information
     *
     * @return Account
     */
    public function user()
    {
        $this->uris[] = "account/user";

        return $this;
    }    
    
}

/**
 * Alterar os dois parâmetros abaixo
 */
$appKey         = 'ayjny43bshwtuwd8umm7sxqsf9b2km2x';
$appSecret      = 'N92cXpgPK9MhSPSM9c8MUfTCE4HteeaQ';

$account = new Account($appKey,$appSecret);

$userId         = $_SESSION['codigo']; // Aqui é ID do seu usuáio, você pode passa-lo como parâmetro na URL "redirectURL"
 
$redirectUrl    = "https://www.esportscups.com.br/battlenet/battle.php?u={$userId}"; // 

if($_GET['u']){
        
    $userId = $_GET['u'];
  
    if(!isset($_GET['code']) || !isset($_GET['state'])){
        
        $error              = (isset($_GET['error'])) ? $_GET['error'] : 'unknow_error';
        $errorDescription   = (isset($_GET['error_description'])) ? $_GET['error_description'] : 'Unknow Error';        
      
        // Aqui o usuário não lhe deu autorização
        
    }else{ // Se o usuário lhe autorizou...

        $authCode       = $_GET['code'];
        $state          = $_GET['state'];  

        echo "Authorization Code: {$authCode}<br>";

        $response = $account->token($redirectUrl, $authCode); // Aqui você vai solicitar um "token"
        $jsonResponse = json_decode($response);

        $accessToken    = $jsonResponse->access_token;
        $expiresIn      = $jsonResponse->expires_in; // Esse token tem uma validade. 
        $scopes         = $jsonResponse->scope;

        echo "Access Token: ".$accessToken."<br>";

        // Cada token tem validade de 30 dias. Mas você pode sempre pedir um novo, não precisa se preocupar em salvá-lo.

        $account->setAccessToken($accessToken); // Use o token

        $userInfo = $account->user()->get(); // Obtenha as informações do usuário

        echo "User ID: ".$userInfo->id."<br>";
        echo "BattleTag: ".$userInfo->battletag."<br>";    
		mysqli_query($conexao, "UPDATE jogador SET battletag = '$userInfo->battletag' WHERE codigo = $userId");
		header("Location: ../ptbr/jogar/hearthstone/");
        }
    
}else{ // Você vai sempre solicitar autorização, mas o usuário só vai confirmar uma vez.
        
    $account->authorize($redirectUrl); // Aqui ele será redirecionado para o formulário de autorização lá na battle.net.
    
    // O usuário poderá autoriza-lo ou não, quando ele confirmar, ou negar..
}
