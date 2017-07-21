<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
	public function index(){
		$cart = new \Library\Cart();
		// dump( $cart );
	}
} 