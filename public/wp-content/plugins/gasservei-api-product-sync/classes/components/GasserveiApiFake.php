<?php

if (!defined('ABSPATH'))
    exit;

class GasserveiApiFake
{
	const IMAGE_REPOSITORY = "https://gas-servei.shop/wp-content/uploads/imagenes_productos";
	
	public function articles($data)
	{
		$data = [["Client"=>"xxx","EAN"
    =>"8435604111333"],["Client"=>"xxx","EAN"=>"8435604111357"],["Client"=>"xxx","EAN"=>"8435604111371"],["Client"=>"xxx","EAN"=>"8435604111388" ]];
		$response = '"[{\"arti\":\"THUTL2201\",\"pvp\":\"20,25\",\"stkact\":\"0,00\",\"CC\":\"2\",\"pvpe\":\"11,14\",\"ean\":\"8435604111333\"},{\"arti\":\"THUTL2205\",\"pvp\":\"93,25\",\"stkact\":\"0,00\",\"CC\":\"2\",\"pvpe\":\"51,29\",\"ean\":\"8435604111357\"},{\"arti\":\"THUTL32001\",\"pvp\":\"21,35\",\"stkact\":\"0,00\",\"CC\":\"2\",\"pvpe\":\"11,74\",\"ean\":\"8435604111371\"},{\"arti\":\"THUTL32005\",\"pvp\":\"89,50\",\"stkact\":\"0,00\",\"CC\":\"2\",\"pvpe\":\"49,22\",\"ean\":\"8435604111388\"}]"';
		$response = '"[{\"arti\":\"ACCCODO05/8\",\"pvp\":\"0,62\",\"stkact\":\"9,00\",\"CC\":\"4\",\"pvpe\":\"0,28\",\"ean\":\"8435604100061\",\"tipologia_id\":\"0\",\"tipologia_des\":\"\",\"producto_id\":\"356\"}]"';
		$artis = json_decode(trim(stripslashes($response),'"'), true);
		foreach($artis as &$arti) {
			if (!empty($arti['pvp']))
				$arti['pvp'] = str_replace(',', '.', $arti['pvp']);
			if (!empty($arti['pvpe']))
				$arti['pvpe'] = str_replace(',', '.', $arti['pvpe']);
		}
		return $artis;
	}

	public function tenant($client_id, $email='')
	{
		$response = $this->get_data('tenant.json');
		$response = json_decode($response, true);
		if ($email=='')
			return $response;
		foreach($response as $entry)
			if ($entry['Email']==$email)
				return $entry['master'];
		return false;
	}

	public function clients($email=null,$cif=null)
	{
		$response = $this->get_data('clients_single.json');
		// $response = "ko";
		if ($response=='"ko"')
			return null;

		$response = json_decode($response, true);
		return count($response)==1 ? $response[0] : $response;
	}
	
	public function attributes_arti()
	{
		$response = $this->get_data('attributes_prod.json');
		return json_decode($response, true);
	}

	public function attributes_prod()
	{
		$response = $this->get_data('attributes_cat.json');
		return json_decode($response, true);
	}

	public function warehouses($cif)
	{
		$response = $this->get_data('warehouses.json');
		if ($response=='ko')
			return null;

		return json_decode($response, true);
	}

	public function order_cap($order_cap)
	{
		$response = $this->get_data('order_cap.json');
		if ($response=='ko')
			return null;
		return json_decode($response, true);
	}	

	public function order_body($order_body)
	{
		$response = $this->get_data('order_body.json');
		if ($response=='ko')
			return null;
		return json_decode($response, true);
	}	

	public function orders($cod)
	{
		$response = $this->get_data('orders.json');
		return json_decode($response, true);
	}
	
	public function orders_id_keys($cod)
	{
		$response = $this->get_data('orders.json');
		$response = json_decode($response, true);
		$return = [];
		foreach($response as $order) {
			$return[$order['NUMERO']] = $order;
		}
		return $return;
	}

	public function stock()
	{
		$response = $this->get_data('stock.json');
		return json_decode($response, true);
	}

	public function offers()
	{
		$response = $this->get_data('offers.json');
		return json_decode($response, true);
	}

	public function categories()
	{
		$response = $this->get_data('categories.json');
		$cats = json_decode($response, true);
		foreach($cats as &$cat)
			if (!empty($cat['Imagen_destacada']))
				$cat['Imagen_destacada'] = self::IMAGE_REPOSITORY.$cat['Imagen_destacada'];
		return $cats;
	}

	public function categories_translations()
	{
		$response = $this->get_data('categories_translations.json');
		return json_decode($response, true);
	}

	public function categories_translations_id_keys()
	{
		$response = $this->categories_translations();
		$return = [];
		foreach($response as $trans) {
			$id = $trans['categoria_id'];
			if (!isset($return[$id]))
				$return[$id] = [];
			$return[$id][$trans['locale_code']] = $trans;
		}
		return $return;
	}

	public function products_translations()
	{
		$response = $this->get_data('products_translations.json');
		return json_decode($response, true);
	}

	public function products_translations_id_keys()
	{
		$response = $this->products_translations();
		$return = [];
		foreach($response as $trans) {
			$id = $trans['id'];
			if (!isset($return[$id]))
				$return[$id] = [];
			$return[$id][$trans['locale_code']] = $trans;
		}
		return $return;
	}

	public function products()
	{
		$response = $this->get_data('products.json');
		$prods = json_decode($response, true);
		foreach($prods as &$prod)
			if (!empty($prod['Imagen_destacada']))
				$prod['Imagen_destacada'] = self::IMAGE_REPOSITORY.$prod['Imagen_destacada'];
		return $prods;		
	}
	
	public function products_gallery_key_id()
	{
		$response = $this->get_data('products_gallery.json');
		$images = json_decode($response, true);
		$return = [];
		foreach($images as $image) {
			if (!empty($image['fileimg']))
				$image['fileimg'] = self::IMAGE_REPOSITORY.'/'.$image['fileimg'];
			if (!isset($return[$image['producto_id']]))
				$return[$image['producto_id']] = [];
			$return[$image['producto_id']][] = $image;
		}
		return $return;
	}

	private function get_data($filename) {
		return file_get_contents(__DIR__.'/data/'.$filename);
	}
}
