<?

require_once 'Dish.php';
require_once 'Part.php';

class Order {

	private static $availableDishes = array();

	private static $availableParts = array();

	private $dishes = array();

	public static function init() {
		self::$availableDishes = array(
			new Dish('борщ', 50, array(
				'сметана' 			=>  1,
				'хлеб' 				=> -1,
			)),
			new Dish('шашлык', 50, array(
				'кетчуп' 			=>  1,
			)),
			new Dish('картофельное пюре', 25, array(
				'кетчуп' 			=>  1,
				'хлеб' 				=> -1, 
			)),
			new Dish('картофель фри', 30, array(
				'кетчуп' 			=>  1,
				'сырный соус' 		=>  1,
			)),
			new Dish('блины', 30, array(
				'сметана' 			=>  1,
				'сгущённое молоко' 	=>  1,
				'джем' 				=>  1,
			)),
			new Dish('салат оливье', 20, array(

			)),
			new Dish('чёрный чай', 20, array(
				'лимон' 			=> -1,
				'молоко' 			=>  1,
				'джем' 				=>  1,
			)),
			new Dish('кофе', 30, array(
				'сливки' 			=> -1,
			)),
		);
		self::$availableParts = array(
			new Part('сметана',			3),
			new Part('хлеб',			5),
			new Part('кетчуп',			3),
			new Part('сырный соус',		3),
			new Part('сгущённое молоко',4),
			new Part('джем',			5),
			new Part('лимон',			2),
			new Part('молоко',			5),
			new Part('сливки',			6),
		);
	}

	public function addDish($dish) {
        if(!is_null($dish)) {
            $this->dishes[] = $dish;
        }

		return $this;
	}

	public function printOrder() {
		foreach($this->dishes as $dish) {
			echo "Блюдо: ".$dish->getName()."\tЦена: ".$dish->getCosts().PHP_EOL;
		}
		return $this;
	}

    /**
     * @param $name
     * @return Dish|null
     */
	public static function getDish($name) {
		foreach(self::$availableDishes as $dish) {
			if($dish->getName() == $name) {
				return $dish;
			}
		}
		return null;
	}

	public static function getPart($name) {
		foreach(self::$availableParts as $part) {
			if($part->getName() == $name) {
				return $part;
			}
		}
		return null;
	}

}