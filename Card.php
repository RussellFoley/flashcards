<?php
Class Card
{
	const DELAY_FACTOR = 2;

	private $_id;
	private $_front;
	private $_back;
	private $_num_success;
	private $_due_date;

	public function __construct(array $data)
	{
		$this->hydrate($data);
	}

	//GETTERS

	public function id()
	{
		return $this->_id;
	}

	public function front()
	{
		return $this->_front;
	}

	public function back()
	{
		return $this->_back;
	}

	public function num_success()
	{
		return $this->_num_success;
	}

	public function due_date()
	{
		return $this->_due_date;
	}

	//SETTERS

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function setFront($front)
	{
		$this->_front = $front;
	}

	public function setBack($back)
	{
		$this->_back = $back;
	}

	public function setNum_success($num_success)
	{
		$this->_num_success = $num_success;
	}

	public function setDue_date($due_date)
	{
		$this->_due_date = $due_date;
	}

	//control

	public function incrementNum_success()
	{
		$this->_num_success += 1;
	}

	public function zeroNum_success()
	{
		$this->_num_success = 0;
	}

	public function updateDueDate()
	{
		if ($this->_num_success == 0)
		{
			$this->_due_date = date("Y-m-d H:i:s");
		}
		else
		{
			$interval = (self::DELAY_FACTOR ** $this->_num_success)/self::DELAY_FACTOR;
			$dueTime = time() + $interval*24*60*60;
			$this->_due_date = date("Y-m-d H:i:s", $dueTime);
		}
	}


	public function hydrate(array $data)
  	{
  		foreach ($data as $key => $value)
  		{
  			$method = 'set'.ucfirst($key);

  			if (method_exists($this, $method))
  			{
  				$this->$method($value);
  			}
  		}

  	}
}