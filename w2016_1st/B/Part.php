<?

require_once 'Dish.php';

class Part extends Dish {
	public function isPartAcceptable($part, $count) {
		return false;
	}
}