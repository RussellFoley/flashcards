<?php

function loadClass($classname)
		{
			require $classname . '.php';
		}

spl_autoload_register('loadClass');

$db = new PDO('mysql:host=localhost;dbname=flashcards','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$manager = new CardManager($db);

if ($manager->countDueCards() != 0)
{
	$card = $manager->currentCard();

	if (isset($_POST['action']))
	{
		switch ($_POST['action']) {
			case "flip":
				require("back.php");
				break;
			case "right":
				$card->incrementNum_success();
				$card->updateDueDate();
				$manager->update($card);
		    	header("refresh:0"); //I am not sure why I had to refresh rather than require front.php here?
		    	break;
	    	case "wrong":
		    	$card->zeroNum_success();
		    	$card->updateDueDate();
		    	$manager->update($card);
		    	header("refresh:0");
		    	break;
	    }
	}
	else
	{
		require("front.php");
	}
}
else //no more cards
{
	echo "No more cards";
}
$db = null;