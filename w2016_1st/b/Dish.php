<?php
require_once 'Sause.php';
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
