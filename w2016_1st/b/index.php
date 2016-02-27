<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * По хорошему просто require нужные классы
 * Но так как в задании выходной файл подразумевается 1, то вот так
 * Копии в файлах сохранены
 * 
 * Кстати входные данные расходятся с выходными
 */
class Sause {
	private $price;
	private $name;

	public function __construct($name, $price) {
		$this->name = $name;
		$this->price = $price;
	}
	/**
	 * Getter name
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * Getter price
	 */
	public function getPrice() {
		return $this->price;
	}
}

class Dish 
{
	protected $name;
	protected $price;
	/**
	 * @var contains array
	 * key - sause name
	 * value - sause max count
	 */
	protected $acceptedSauses = array();
	/**
	 * @var contains array
	 * key - sause name
	 * value - array[sause object, count]
	 */
	protected $definedSauses = array();

	public function __construct($name, $price) {
		$this->name = $name;
		$this->price = $price;
	}
	/**
	 * @param string $sauseName
	 * @return bool
	 */
	private function isSauseDefined($sauseName) {
		if (array_key_exists($sauseName, $this->definedSauses)) {
			return true;
		}
		return false;
	}
	/**
	 * @param Sause $sause
	 * @param int $count
	 * @return bool
	 */
	private function isSauseAccepted(Sause $sause, $count) {
		if ($this->isSauseDefined($sause->getName()))
			return false;

		if (!array_key_exists($sause->getName(), $this->acceptedSauses))
			return false;

		if ($this->getSauseMaxCount($sause) !== 0 && $this->getSauseMaxCount($sause) < $count)
			return false;

		return true;
	}
	/**
	 * @param Sause $sause
	 * @param int $count maximum count
	 * @return void
	 */
	public function addAcceptableSause(Sause $sause, $count = 0) {
			$this->acceptedSauses[$sause->getName()] = $count;
	}
	/**
	 * Remove sause from dish
	 * @param Sause $sause
	 * @return bool
	 */
	public function removeSause(Sause $sause) {
		if ($this->isSauseDefined($sause->getName())) {
			unset($this->definedSauses[$sause->getName()]);
			return true;
		}
		return false;
	}
	/**
	 * Set sause maximum count
	 * @param Sause $sause
	 * @param int $count
	 * @return bool
	 */
	public function setSauseMaxCount(Sause $sause, $count) {
		if (array_key_exists($sause->getName(), $this->acceptedSauses)) {
			$this->acceptedSauses[$sause->getName()] = $count;
			return true;
		}
		return false;
	}

	/**
	 * @param Sause $sause
	 * @return bool
	 */
	public function getSauseMaxCount(Sause $sause) {
		if (array_key_exists($sause->getName(), $this->acceptedSauses)) {
			return $this->acceptedSauses[$sause->getName()];
		}
		return false;
	}
	/**
	 * @param Sause $sause
	 * @param int count
	 * @return bool
	 */
	public function addSause(Sause $sause, $count) {
		if (!$this->isSauseAccepted($sause, $count)) {
			return false;
		} else {
			$this->definedSauses[$sause->getName()] = array('instance' => $sause, 'count' => $count); 
			return true;
		}
	}
	/**
	 * Get full dish name with sauses
	 * @return string
	 */
	public function getName() {
		$resultName = $this->name;
		if (count($this->definedSauses) > 0) {
			$resultName .= ' c';
		}
		foreach ($this->definedSauses as $sause) {
			$resultName .= ' ' . $sause['count'] . ' ';
			$resultName .= $sause['instance']->getName();
		}
		return $resultName;
	}
	/**
	 * getter of price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Dish full price
	 * @return int
	 */
	public function getCost() {
		$sum = $this->getPrice();
		foreach ($this->definedSauses as $sause) {
			$sum += $sause['instance']->getPrice() * $sause['count'];
		}
		return $sum;
	}
}

class Order {
	/**
	 * @var address
	 */
	private $address;
	/**
	 * @var array
	 * key - dish name, dish object
	 */
	private $dishes;

	public function __construct($address) {
		$this->address = $address;
	}
	/**
	 * Add dish to order
	 * @param Dish $dish
	 * @param int $count
	 */
	public function addDish(Dish $dish, $count = 1) {
		$this->dishes[$dish->getName()] = array('instance' => $dish, 'count' => $count);
	}
	/**
	 * Return array with name, count and price of each dish in order
	 * @return array
	 */
	public function takeOrder() {
		$result = array();
		if (count($this->dishes) === 0) return array();
		foreach ($this->dishes as $key => $value) {
			$result[] = array(
				'name' => $value['instance']->getName(),
				'count' => $value['count'],
				'price' => $value['instance']->getCost()
			);
		}
		return $result;
	}
}


// добавки
$sourCream = new Sause('Сметана', 3);
$milk = new Sause('Сливки', 6);
$ketchup = new Sause('Кетчуп', 3);
$bread = new Sause('Хлеб', 5);

// борщ
$borsh = new Dish('Борщ', 50);

$borsh->addAcceptableSause($sourCream, 1);
$borsh->addAcceptableSause($bread);

$borsh->addSause($bread, 3);
$borsh->addSause($sourCream, 3);

// кофе
$coffee = new Dish('Кофе', 30);

$coffee->addAcceptableSause($milk);

$coffee->addSause($milk, 2);

// котлета
$beef = new Dish('Котлета', 20);

// пюре
$pot = new Dish('Пюре', 25);
$pot->addAcceptableSause($ketchup, 1);
$pot->addAcceptableSause($bread, 2);

$pot->addSause($ketchup, 1);
$pot->addSause($bread, 2);

$order = new Order('');

$order->addDish($beef);
$order->addDish($pot);
$order->addDish($borsh, 2);
$order->addDish($coffee, 2);

foreach ($order->takeOrder() as $value) {
	echo ($value['count'] > 1) ? $value['count'] . ' ' : '';
	echo $value['name'] . ' - за единицу: ' . $value['price'] . ' сумма: ' . $value['price'] * $value['count'];
	echo "<br>";
}