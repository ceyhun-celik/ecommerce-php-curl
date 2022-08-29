<?php

/**
 * This Controller is managing data of fakestoreapi.com
 * fakestoreapi.com is providing id, title, price, description, category, image and rating
 * 
 * @see: https://fakestoreapi.com
 * @see: https://fakestoreapi.com/products
 */
class ECommerce1
{
    protected $helpers;
    protected $api_url = 'https://fakestoreapi.com';

    public function __construct()
    {
        $this->helpers = new Helpers();
    }

    /**
     * Get Products by cURL
     * 
     * @return array
     */
    public function getProducts()
    {
        $response = $this->helpers->curlGet("{$this->api_url}/products");

        $products = [];
        foreach($response as $key => $value){
            $products[] = [
                'id' => $value['id'],
                'name' => $value['title'],
                'price' => $value['price'],
                'category' => $value['category']
            ];
        }

        return $products;
    }

    /**
     * Convert Products format from array variable to JSON and XML file
     */
    public function setProducts()
    {
        $products = self::getProducts();

        $json = $this->helpers->createJSONFile('ecommerce1', $products);
        $xml  = $this->helpers->createXMLFile('ecommerce1', $products);
        
        $this->helpers->outputMessage($json, $xml);
    }
}

$ecommerce1 = new ECommerce1();