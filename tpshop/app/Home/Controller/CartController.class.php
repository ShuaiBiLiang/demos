<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {


	public function __construct()
	{
		parent::__construct();
		$this->cart = new \Library\Cart();//实例化购物车类
	}

	public function index()
	{
		// $cart = new \Library\Cart();
		dump( $cart );
	}

	public function add()
	{
		$goods_id = I('post.goods_id');
		$goods_name = I('post.goods_name');
		$goods_price = I('post.goods_price');
		$amount = I('post.amount',0,'intval');

		$data = array(
			'goods_id'	=> $goods_id,
			'goods_name'	=> $goods_name,
			'goods_price'	=> $goods_price,
			'goods_buy_number'	=> $amount,	//商品数量

			'goods_total_price'	=> $goods_price * $amount,	//单个商品总价
		);

		// dump($data);
		
		$this->cart->add($data); //add方法没有返回值

		$cart_info = $this->cart->getCartInfo();//购物中所有的商品信息

		if( isset( $cart_info[$goods_id] ) )
		{
			$result = $this->cart->getNumberPrice();//获取当前购物车的商品数量和总价格
			$result['error_code'] = 0;
			$result['message']='购物车添加商品成功！';
		}else{
			$result = array(
				'error_code'	=>	1,
				'message'		=>'购物车添加商品失败！'
			);
		}

		//把结果转换js格式的字符串，打印出来
		echo json_encode( $result );
	}


	//显示购物车商品
	public function flow1()
	{
		//获取当前购物车的所有商品
		$cart_info = $this->cart->getCartInfo();

		//用循环把购物车中的各种商品的缩略图获取到
		foreach( $cart_info as $key=>$item )
		{
			$goods_id = $item['goods_id'];

			//从数据库中查询对应的商品缩略图
			$res = D('Goods')->field('goods_small_logo')->find($goods_id);
			$cart_info[$key]['thumb'] = $res['goods_small_logo'];

		}


		// dump( $cart_info );
		$this->cart_info = $cart_info;
		$this->display();
	}


	// 订单结算页面
	public function flow2()
	{
		//获取当前购物车的所有商品
		$cart_info = $this->cart->getCartInfo();

		//用循环把购物车中的各种商品的缩略图获取到
		foreach( $cart_info as $key=>$item )
		{
			$goods_id = $item['goods_id'];

			//从数据库中查询对应的商品缩略图
			$res = D('Goods')->field('goods_small_logo')->find($goods_id);
			$cart_info[$key]['thumb'] = $res['goods_small_logo'];

		}


		// dump( $cart_info );
		$this->cart_info = $cart_info;

		//获取当前购物车中商品的总价格
		$this->getNumberPrice = $this->cart->getNumberPrice();
		$this->display();
	}


	public function buy()
	{
		echo 'a';
	}
} 