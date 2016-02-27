<?php
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