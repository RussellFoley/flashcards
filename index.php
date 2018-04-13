<?php

function loadClass($classname)
{
	require $classname . '.php';
}

spl_autoload_register('loadClass');

$db = new PDO('mysql:host=localhost;dbname=flashcards','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$manager = new CardManager($db);

print_r($_POST);

if (isset($_POST['front']) && isset($_POST['back']) && !empty($_POST['front']) && !empty($_POST['back']))
{
	$card = new Card(array(
		'front' => $_POST['front'],
		'back' => $_POST['back'],
		'num_success' => 0,
		'due_date' => date("Y-m-d H:i:s")
	));

	echo "FRONT: " . $card->front();

	$manager->add($card);

	echo "Card added.";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="#" method="POST">
		<label for="front">Front</label>
		<textarea accept-charset="UTF-8" name="front" rows="6" cols="50"></textarea>
		<label for="back">Back</label>
		<textarea accept-charset="UTF-8" name="back" rows="6" cols="50"></textarea>
		<button type="submit">Submit</button>
	</form>

</body>
</html>