<?php

if (!defined('ABSPATH'))
    exit;

class GasserveiApiCache extends GasserveiApi {

	public function attributes_arti()
	{
		if ($attributes_arti = get_transient('gs_api_attributes_arti'))
			return $attributes_arti;
		$attributes_arti = parent::attributes_arti();
		set_transient('gs_api_attributes_arti', $attributes_arti, GS_TRANSIENT_EXPIRATION);
		return $attributes_arti;
	}

	public function products_gallery_key_id()
	{
		return $this->cached_api_call('gs_api_gallery', function() {
			return parent::products_gallery_key_id();
		});
	}	

	// Incremental cache
	public function articles($cif, $eans)
	{
		if (($articles = get_transient('gs_api_articles_'.$cif)) && 
		    $this->has_all_eans($articles, $eans))
		{
			return $articles;
		}
		$old_articles = $articles ? $articles : [];
		$articles = parent::articles($cif, $eans);
		if (!$articles)
			$articles = [];
		$articles = $this->merge_articles($old_articles, $articles);
		$ean_articles = [];
        foreach($articles as $article) {
            $ean_articles[$article['ean']] = $article;
        }
		set_transient('gs_api_articles_'.$cif, $ean_articles, GS_TRANSIENT_EXPIRATION);
		return $articles;		
	}

	public function clear_articles_cache($cif)
	{
		delete_transient('gs_api_articles_'.$cif);		
	}

	// True if all eans are present in the articles array
	private function has_all_eans($articles, $eans)
	{
		foreach($eans as $ean) {
			if (!$this->has_ean($articles, $ean))
				return false;
		}
		return true;
	}

	private function has_ean($articles, $ean)
	{
		foreach($articles as $article)
			if ($article['ean']==$ean)
				return true;
		return false;
	}

	private function merge_articles($articles1, $articles2)
	{
		foreach($articles1 as $arti) {
			if (!$this->has_ean($articles2, $arti['ean']))
				$articles2[] = $arti;		
		}
		return $articles2;
	}

	private function cached_api_call($key, $callback) {
		if ($value = get_transient($key))
			return $value;
		$value = $callback();
		set_transient($key, $value, GS_TRANSIENT_EXPIRATION);
		return $value;
	}
}