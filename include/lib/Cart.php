<?php
class Cart{
	public function cart() {
		if(!isset($_SESSION['goods_list'])){
			$_SESSION['goods_list'] = array();
		}
	}

	/*
	添加商品
	param int $id 商品主键
		  string $name 商品名称
		  float $price 商品价格
		  int $goods_num 购物数量
	*/
	public  function addItem($id,$name,$price,$goods_num,$img) {
		//如果该商品已存在则直接加其数量
		if (isset($_SESSION['goods_list'][$d])) {
			$this->incgoods_num($id,$goods_num);
			return;
		}
		$item = array();
		$item['id'] = $id;
		$item['name'] = $name;
		$item['price'] = $price;
		$item['goods_num'] = $goods_num;
		$item['img'] = $img;
		$_SESSION['goods_list'][$d] = $item;
	}

	/*
	修改购物车中的商品数量
	int $id 商品主键
	int $goods_num 某商品修改后的数量，即直接把某商品
	的数量改为$goods_num
	*/
	public function modgoods_num($id,$goods_num=1) {
		if (!isset($_SESSION['goods_list'][$d])) {
			return false;
		}
		$_SESSION['goods_list'][$d]['goods_num'] = $goods_num;
	}

	/*
	商品数量+1
	*/
	public function incgoods_num($id,$goods_num=1) {
		if (isset($_SESSION['goods_list'][$id])) {
			$_SESSION['goods_list'][$id]['goods_num'] += $goods_num;
		}
	}

	/*
	商品数量-1
	*/
	public function decgoods_num($id,$goods_num=1) {
		if (isset($_SESSION['goods_list'][$id])) {
			$_SESSION['goods_list'][$id]['goods_num'] -= $goods_num;
		}

		//如果减少后，数量为0，则把这个商品删掉
		if ($_SESSION['goods_list'][$id]['goods_num'] <1) {
			$this->delItem($id);
		}
	}

	/*
	删除商品
	*/
	public function delItem($id) {
		unset($_SESSION['goods_list'][$id]);
	}
	
	/*
	获取单个商品
	*/
	public function getItem($id) {
		return $_SESSION['goods_list'][$id];
	}

	/*
	查询购物车中商品的种类
	*/
	public function getCnt() {
		return count($_SESSION['goods_list']);
	}
	
	/*
	查询购物车中商品的个数
	*/
	public function getgoods_num(){
		if ($this->getCnt() == 0) {
			//种数为0，个数也为0
			return 0;
		}

		$sum = 0;
		$data = $_SESSION['goods_list'];
		foreach ($data as $item) {
			$sum += $item['goods_num'];
		}
		return $sum;
	}

	/*
	购物车中商品的总金额
	*/
	public function getPrice() {
		//数量为0，价钱为0
		if ($this->getCnt() == 0) {
			return 0;
		}
		$price = 0.00;
		foreach ($this->items as $item) {
			$price += $item['goods_num'] * $item['price'];
		}
		return sprintf("%01.2f", $price);
	}

	/*
	清空购物车
	*/
	public function clear() {
		$_SESSION['goods_list'] = array();
	}
}
?>