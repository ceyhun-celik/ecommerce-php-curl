<?php

/**
 * This Controller is managing data of storerestapi.com
 * storerestapi.com is providing _id, title, price, category > (_id, name, slug), description, createdAt, updatedAt, slug, image under the “data”
 * 
 * @see: https://storerestapi.com/
 * @see: https://api.storerestapi.com/products
 */
class ECommerce3
{
    protected $helpers;
    protected $api_url = 'https://api.storerestapi.com';

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
        $response = $this->helpers->curlGet("{$this->api_url}/products")['data'];

        $products = [];
        foreach($response as $key => $value) {
            $products[] = [
                'id' => $value['_id'],
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

        $json = $this->helpers->createJSONFile('ecommerce3', $products);
        $xml  = $this->helpers->createXMLFile('ecommerce3', $products);
        
        $this->helpers->outputMessage($json, $xml);
    }
}

$ecommerce3 = new ECommerce3();