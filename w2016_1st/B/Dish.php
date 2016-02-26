<? 
class Dish {

	protected $name;
	protected $price;
	protected $acceptable = array();

	private $parts = array();

	public function __construct($name, $price, $acceptable = array()) {
		$this->name = $name;
		$this->price = $price;
		$this->acceptable = $acceptable;
	}

	public function getCosts() {
		$partsPrice = 0;
		foreach ($this->parts as $el) {
			$partsPrice += $el['count']*$el['part']->getCosts();
		}
		return $this->price + $partsPrice;
	}

	public function getName() {
		$partsNames = '';
		foreach ($this->parts as $el) {
			$partsNames .= (strlen($partsNames) ? ' и ' : '').$el['count'].' '.$el['part']->getName();
		}
		return $this->name.(strlen($partsNames) ? ' c '.$partsNames : '');
	}

	public function addPart($part, $count) {
        if(is_null($part)) {
            return $this;
        }
		foreach($this->parts as &$el) {
			if($el['part']->getName() == $part->getName()) {
				if($this->isPartAcceptable($part,$count+$el['count'])) {
					$el['count'] += $count;
				} else {
					throw new Exception('Слишком много добавки');
				}
				return $this;
			}
		}
		if($this->isPartAcceptable($part,$count)) {
			$this->parts[] = array(
					'part' => $part,
					'count' => $count,
 				);
		} else {
			throw new Exception('Такая добавка не поддерживается или её слишком много');
		}
		return $this;
	}

	public function delPart($part, $count = -1) {
        if(is_null($part)) {
            return $this;
        }
		foreach($this->parts as $key => &$el) {
			if($el['part']->getName() == $part->getName()) {
				if($el['count'] >= $count) {
					if($count == -1) {
						$el['count'] = 0;
					} else {
						$el['count'] -= $count;
					}
				} else {
					throw new Exception('Такой добавки в блюде нет или её меньше');
				}
				if($el['count'] == 0) {
					unset($this->parts[$key]);
				}
			}
		}
		return $this;
	}

	public function isPartAcceptable($part, $count) {
        if(is_null($part)) {
            return false;
        }
		foreach($this->acceptable as $name => $max) {
			if($name == $part->getName() && ($max == -1 || $max >= $count)) {
				return true;
			}
		}
		return false;
	}

}