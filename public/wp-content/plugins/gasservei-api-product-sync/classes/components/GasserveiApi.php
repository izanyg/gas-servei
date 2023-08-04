<?php

if (!defined('ABSPATH'))
    exit;

class GasserveiApi 
{
	const API_HOST = "83.48.15.203:53634";
	const IMAGE_REPOSITORY = "https://gas-servei.shop/wp-content/uploads/imagenes_productos";

	public function clients($email=null,$cif=null)
	{
		$params = [];
		if ($email) {
			$params[] = 'CORREU'; $params[] = $email;
		}
		if ($cif) {
			$params[] = 'CIF'; $params[] = $cif;
		}
		$params = implode(';', $params);
		$response = $this->get('/api/clients/'.$params);
		if ($response=='"ko"')
			return null;
		$response = json_decode($response, true);
		return count($response)==1 ? $response[0] : $response;		
	}
	
	public function tenant($client_id, $email='')
	{
		$response = $this->get('/api/emilio/'.$client_id);
		$response = json_decode($response, true);
		if ($email=='')
			return $response;
		foreach($response as $entry)
			if ($entry['Email']==$email)
				return $entry['master'];
		return false;
	}
	
	public function attributes_arti()
	{
		$response = $this->get('/api/atributospro/');
		return json_decode($response, true);
	}

	public function attributes_prod()
	{
		$response = $this->get('/api/atributoscat/');
		return json_decode($response, true);
	}

	public function warehouses($cif)
	{
		$response = $this->get('/api/almacen9/CIF;'.$cif);
		return json_decode($response, true);
	}

	public function put_warehouse($warehouse)
	{
		$response = $this->post('/api/ALM', [$warehouse]);
		return json_decode($response, true);
	}

	public function order_cap($order_cap)
	{
		$response = $this->post('/api/CAP', [$order_cap]);
		return json_decode($response, true);
	}

	public function order_body($order_body)
	{
		$response = $this->post('/api/POST', $order_body);
		return json_decode($response, true);
	}

	public function orders($cod)
	{
		$response = $this->get('/api/pedidos/ID;'.$cod);
		return json_decode($response, true);
	}

	public function orders_id_keys($cod)
	{
		$response = $this->get('/api/pedidos/ID;'.$cod);
		$response = json_decode($response, true);
		$return = [];
		foreach($response as $order) {
			$return[$order['NUMERO']] = $order;
		}
		return $return;
	}

	public function articles($cif, $eans)
	{
        $payload = [];
        foreach ($eans as $ean) {
            $payload[] = ['Client' => $cif, 'EAN' => $ean];
        }		
		$response = $this->post('/api/articles9', $payload);
		$artis = json_decode(trim(stripslashes($response),'"'), true);
		if ($artis==0)
		    return null;
		foreach($artis as &$arti) {
			if (!empty($arti['pvp']))
				$arti['pvp'] = str_replace(',', '.', $arti['pvp']);
			if (!empty($arti['pvpe']))
				$arti['pvpe'] = str_replace(',', '.', $arti['pvpe']);
			if (!empty($arti['stkact']))
				$arti['pvpe'] = str_replace(',', '.', $arti['pvpe']);
		}
		return $artis;
	}

	public function stock()
	{
		$response = $this->get('/api/stkalm9/20');
		return json_decode($response, true);
	}

	public function offers()
	{
		$response = $this->get('/api/ofertas');
		return json_decode($response, true);
	}

	public function categories()
	{
		$response = $this->get('/api/categorias');
		$cats = json_decode($response, true);
		foreach($cats as &$cat)
			if (!empty($cat['Imagen_destacada']))
				$cat['Imagen_destacada'] = self::IMAGE_REPOSITORY.$cat['Imagen_destacada'];
		return $cats;
	}

	public function categories_translations()
	{
		$response = $this->get('/api/CategoriasTrad');
		$cats = json_decode($response, true);
		return $cats;
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
		$response = $this->get('/api/productosTrad');
		$cats = json_decode($response, true);
		return $cats;
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
		$response = $this->get('/api/productos');
		$prods = json_decode($response, true);
		foreach($prods as &$prod)
			if (!empty($prod['Imagen_destacada']))
				$prod['Imagen_destacada'] = self::IMAGE_REPOSITORY.$prod['Imagen_destacada'];
		return $prods;		
	}

	public function products_gallery_key_id()
	{
		$response = $this->get('/api/productosGaleria');
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

	protected function get($endpoint)
	{
		$options = [
		    'timeout' => 60,
   		];
		$response = wp_remote_get( 'http://'.self::API_HOST.$endpoint, $options);
		if ((is_array($response) && isset($response['response']) && $response['response']['code']==500) ||
			(is_wp_error($response)))
			throw new Exception("Error Processing Request", 1);
		return $response['body'];
	}
	
	protected function post($endpoint, $data)
	{
		$json_data = wp_json_encode($data);
		$options = [
		    'headers' => [
		        'Content-Type' => 'application/json',
		    ],
		    'timeout' => 60,
		    'body' => $json_data,
   		];
		// var_dump(wp_json_encode($data));die();
		$response = wp_remote_post( 'http://'.self::API_HOST.$endpoint, $options);
		if (is_array($response) && isset($response['response']) && $response['response']['code']==500) {
            error_log("Error Processing Request, body: ".$json_data);
            error_log("Error Processing Request, response: ".print_r($response['response'], true));
			throw new Exception("Error Processing Request", 1);
		}
		return $response['body'];
	}
}
