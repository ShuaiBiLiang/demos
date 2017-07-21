<?php
    require_once('./cart.php');
    $total = 0;
    $a = $_GET['a'];

    $cart = new Cart();
    //添加商品
    if($a == 'add'){
        $goods_info = array('goods_id'=>$_POST['goods_id'],'goods_name'=>$_POST['goods_name'],'goods_price'=>$_POST['goods_price'],'goods_buy_number'=>1,'goods_total_price'=>$_POST['goods_price']);

        $cart -> add($goods_info);
        $number_price = $cart->getNumberPrice();

        echo json_encode($number_price);
    
    //商品数量修改
    } else if ($a == 'changeNumber'){
        
        $goods_id         = $_POST['goods_id'];//被修改商品id
        $goods_buy_number = $_POST['goods_buy_number'];//修改后的数量

        $goods_total_price = $cart -> changeNumber($goods_buy_number,$goods_id);//商品小计价格
        $cart_info = $cart -> getCartInfo();//获得购物车商品信息
        
        //计算商品总价钱
        $total = 0;
        if($cart_info) {
            foreach ($cart_info as $_k => $_v) {
                $total += $_v['goods_total_price']; //购物车商品总价格
            }
        }

        $arr['goods_total_price'] = $goods_total_price;
        $arr['total'] = $total;
        echo json_encode($arr);
    //清空商品
    } else if ($a == "delall"){
        $cart -> delall();
    
    //删除商品
    } else if ($a == "del"){
        $cart -> del($_POST['goods_id']);
        
        //重新获得购物车里边商品总价格
        $cart_info = $cart->getCartInfo();//获得购物车商品的信息
        
        //根据商品信息获得商品的总价格
        //计算商品总价钱
        foreach($cart_info as $_k => $_v){
            $total += $_v['goods_total_price'];//购物车商品一共的价钱
        }
        echo $total;
    }

?>