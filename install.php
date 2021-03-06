<?php
// If needed, check the official project on GitHub:
// https://github.com/auino/php-telegram-bot-library

$DELETEEXISTENTWBHOOK = false;
$REGISTERWEBHOOK = true;
$TOKEN = "...";
$SSLCERTIFICATEFILE = "@certificate.pem";
$WEBHOOKURL = "https://www.yourwebsite.org/webhook.php";

$SETUPDB = true;

$SETUPDBQUERIES = [
	"CREATE TABLE `Logs` (`id` bigint(20) NOT NULL AUTO_INCREMENT, `bot` varchar(100) NOT NULL, `action` varchar(100) NOT NULL, `chat` int(11) NOT NULL, `type` varchar(30) NOT NULL, `content` varchar(250) NOT NULL, `date` varchar(30) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `bot` (`bot`,`action`,`chat`,`date`));"
];

include_once("lib/telegram.php");

if($DELETEEXISTENTWBHOOK) {
	echo "Deleting registered webhook...\n";
	$bot = new telegram_bot($TOKEN);
	$bot->set_webhook();
	echo "Deleted!\n";
}
else { // you can register a new webhook only if you're not deleting existent webhook
	if($REGISTERWEBHOOK) {
		echo "Registering webhook...\n";
		$bot = new telegram_bot($TOKEN);
		//$bot->set_webhook();
		$bot->set_webhook($WEBHOOKURL, $SSLCERTIFICATEFILE);
		echo "Registered!\n";
	}
}

if($SETUPDB) {
	echo "Configuring Logs database...\n";
	foreach($SETUPDBQUERIES as $q) {
		db_nonquery($q);
	}
	echo "Configured!\n";
}

echo "Installation completed!\n";
?>
