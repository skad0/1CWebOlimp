<?php
/**
 * Я не забивал в файл все возможные значения для чисел,
 * боясь за время. Если не находит слово, он выдаст число
 */
header('Content-Type: text/html; charset=utf-8');
class Captcha {
	private $time;
	private $hours;
	private $minutes;
	private $seconds;
	private $timeToStr;
	private $font = './arial.ttf';

	public function __construct($input, $sizex = 400, $sizey = 400) {
		$this->time = new DateTime();
		$this->hours = $this->time->format('H');
		$this->minutes = $this->time->format('m');
		$this->seconds = $this->time->format('s');
		$this->fillTimeToStr($input);

		$this->sizex = $sizex;
		$this->sizey = $sizey;
	}
	/**
	 * Fill property with specified names from file
	 * @param string $input
	 */
	private function fillTimeToStr($input) {
		$file = file_get_contents($input);
		$strs = explode("\n", $file);
		foreach ($strs as $str) {
			$this->timeToStr[] = explode(';', trim($str));
		}
	}
	/**
	 * Get word representation of number
	 * @param $num
	 */
	private function getWord($num) {
		$num = ltrim($num, '0');
		if (isset($this->timeToStr[(int)$num]))
			return $this->timeToStr[(int)$num][array_rand($this->timeToStr[(int)$num])];
		else
			return $num;
	}
	/**
	 * Return angle of hours arrow
	 */
	private function getHoursAngle() {
		return 0.5 * (60 * $this->hours + $this->minutes);
	}
	/**
	 * Return angle of minutes arrow
	 */
	private function getMinutesAngle() {
		return 6 * $this->minutes;
	}
	/**
	 * Return angle of seconds arrow
	 */
	private function getSecondsAngle() {
		return 6 * $this->seconds;
	}
	/**
	 * Set users defined font
	 */
	public function setFont($fontPath) {
		$this->font = $fontPath;
	}
	/**
	 * Draw captcha and write it into file
	 */
	public function draw() {
		$image = imagecreate($this->sizex, $this->sizey);
		$bgcolor = imagecolorallocate($image, 255, 255, 255);

		$minutesColor = imagecolorallocate($image, 0, 255, 120);
		$hoursColor = imagecolorallocate($image, 120, 255, 2);
		$secondsColor = imagecolorallocate($image, 0, 125, 120);

		imagefilledellipse($image, ceil($this->sizex/2), ceil($this->sizey/2), 10*rand(1,$this->sizex), rand(1,$this->sizey), imagecolorallocate($image, 100, 255, 100));
		imagefilledellipse($image, ceil($this->sizex/2), ceil($this->sizey/2), 10*rand(1,$this->sizex), rand(1,$this->sizey), imagecolorallocate($image, 100, 100, 255));
		imagefilledellipse($image, ceil($this->sizex/2), ceil($this->sizey/2), 10*rand(1,$this->sizex), rand(1,$this->sizey), imagecolorallocate($image, 255, 100, 100));

		imagettftext($image, 20, -$this->getMinutesAngle() + 90, ceil($this->sizex/2), ceil($this->sizey/2), $minutesColor, $this->font, "  " .$this->getWord($this->minutes));
		imagettftext($image, 20, -$this->getHoursAngle() + 90, ceil($this->sizex/2), ceil($this->sizey/2), $hoursColor, $this->font,  "  " .$this->getWord($this->hours));
		imagettftext($image, 20, -$this->getSecondsAngle() + 90, ceil($this->sizex/2), ceil($this->sizey/2), $secondsColor, $this->font,  "  " .$this->getWord($this->seconds));

		return imagepng($image, './captcha.png');
	}
}

$captcha = new Captcha('in.txt');
$captcha->draw();
?>

<img src="captcha.png">