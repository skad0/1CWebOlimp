<?

header('Content-type: text/plain; charset=utf-8');

require_once 'Order.php';

Order::init();
$order = new Order();
$order->addDish(Order::getDish('борщ')->addPart(Order::getPart('сметана'), 1)->addPart(Order::getPart('хлеб'), 4));
$order->addDish(Order::getDish('салат оливье'));
$order->addDish(Order::getDish('шашлык')->addPart(Order::getPart('кетчуп'), 1));
$order->addDish(Order::getDish('картофель фри')->addPart(Order::getPart('кетчуп'), 1));
$order->addDish(Order::getDish('кофе')->addPart(Order::getPart('сливки'), 5));

$order->printOrder();