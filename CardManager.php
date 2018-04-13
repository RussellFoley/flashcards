<?php
Class CardManager
{
	private $_db;

	public function __construct($db)
	{
		$this->_db = $db;
	}

	public function add($card){
		$q = $this->_db->prepare("INSERT into cards (front, back, num_success, due_date) VALUES(:front, :back, :num_success, :due_date)");

		$q->execute(array(
			":front" => $card->front(),
			":back" => $card->back(),
			":num_success" => $card->num_success(),
			":due_date" => $card->due_date()
		));
	}

	public function currentCard()
	{
		$q = $this->_db->query('SELECT * FROM cards WHERE due_date < NOW() ORDER BY due_date ASC');
		$data = $q->fetch();
		$q->closeCursor();
		return new Card($data);


	}

	public function dueCards()
	{
		$q = $this->_db->query('SELECT * FROM cards WHERE due_date < NOW() ORDER BY due_date ASC');
		$array = [];
		while($data = $q->fetch())
		{
			$array[] = new Card($data);
		}
		$q->closeCursor();

		return $array;
	}

	public function countDueCards()
	{
		$q = $this->_db->query('SELECT COUNT(*) FROM cards WHERE due_date < NOW()');
		$result = $q->fetch()[0];
		$q->closeCursor();
		return $result;
	}

	public function update($card){
		$q = $this->_db->prepare('UPDATE cards set num_success = :num_success, due_date = :due_date WHERE id = :id');

		$q->execute(array(
			"num_success" => $card->num_success(),
			"due_date" => $card->due_date(),
			"id" => $card->id()
			));

		$q->closeCursor();

	}
}