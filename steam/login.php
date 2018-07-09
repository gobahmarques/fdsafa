<?
	require "SteamAuthentication/steamauth/steamauth.php";
	require "SteamAuthentication/steamauth/userInfo.php";

	if(isset($_SESSION['steamid'])){
		$id = $_SESSION['steamid'];
		echo "logado";
	}else{
		echo "nao logado";
	}	
?>