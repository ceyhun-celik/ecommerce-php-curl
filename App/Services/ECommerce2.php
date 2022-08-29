<?php

/**
 * This Controller is managing data of fakeapi.platzi.com
 * fakeapi.platzi.com is providing id, title, price, description, category > (id, name, image), images
 * 
 * @see: https://fakeapi.platzi.com
 * @see: https://api.escuelajs.co/api/v1/products
 */
class ECommerce2
{
    protected $helpers;
    protected $api_url = 'https://api.escuelajs.co/api/v1';

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
                'price' => number_format($value['price'], 2),
                'category' => $value['category']['name']
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

        $json = $this->helpers->createJSONFile('ecommerce2', $products);
        $xml  = $this->helpers->createXMLFile('ecommerce2', $products);
        
        $this->helpers->outputMessage($json, $xml);
    }
}

$ecommerce2 = new ECommerce2();