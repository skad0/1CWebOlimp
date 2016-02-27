<?php
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