<?php

	class Calculator {

		public $a = '';

		public $b = '';

		public $operator = '';
		
		public $result = '';
		
		public $error = '';
		
		private $pattern = '/^([\+-]?\d+)\s*([\+-\/\*<>&%]{1})\s*([\+-]?\d+)$/';

		public function __construct($data) {
			if (isset($data['exp'])) {
				if (preg_match($this->pattern, $data['exp'], $matches)) {
					list(, $this->a, $this->operator, $this->b) = $matches;
					$this->result = $this->getResult();
				} else {
					$this->error = 'operator not supported';
				}
			}
		}

		public function getResult() {
			switch ($this->operator) {
				case "+" : return $this->a + $this->b;
				case "-" : return $this->a - $this->b;
				case "*" : return $this->a * $this->b;
				case "/" : 
					if ($this->b * 1 == 0) {
						$this->error = 'division by zero';
						return '';
					} else {
						return  $this->a / $this->b;
					}
				case "<" : return $this->boolToString($this->a < $this->b);
				case ">" : return $this->boolToString($this->a > $this->b);
				case "&" : return $this->boolToString($this->a && $this->b);
				case "%" : return number_format($this->a / $this->b * 100, 2).'%';
			}
		}
		
		private function boolToString($bool) {
			return ($bool) ? 'True' : 'False';
		}

		public function encodeJSON() {
			$jsonoutput = array('a' => $this->a, 'b' => $this->b, 'operator' => $this->operator, 'result' => $this->result, 'error' => $this->error);
			return json_encode($jsonoutput);
		}
	}

	$calculator = new Calculator($_GET);

	echo $calculator->encodeJSON();
?>