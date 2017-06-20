<?php

class Goods {
	public static $price = 100;
	public static function showPrice() {
		echo static::$price;
	}
}
class Book extends Goods {
	public static $price = 200;
}

// $obj = new Book;
Book::showPrice();

