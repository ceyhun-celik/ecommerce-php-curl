<?php

class Helpers
{
    protected $output_path;

    public function __construct()
    {
        date_default_timezone_set('Europe/Istanbul');
        $this->output_path = realpath('.') . '/Output';
    }

    /**
     * Providing GET request with URL variable
     */
    public function curlGet($url)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1
        ]);
        
        $result = curl_exec($ch);

        if(curl_errno($ch)){
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        
        return json_decode($result, true);
    }

    /**
     * Create JSON File
     * 
     * @param string $name
     * @param array $data
     * 
     * @return string
     */
    public function createJSONFile($name, $data)
    {
        $name = date('Y_m_d_H_i_s') . "_{$name}.json";
        $data = json_encode($data);

        $file = fopen("{$this->output_path}/{$name}", 'w');
        fwrite($file, $data);

        return $name;
    }

    /**
     * Create XML File
     * 
     * @param string $name
     * @param array $data
     * 
     * @return string
     */
    public function createXMLFile($name, $data)
    {
        $xml = new DOMDocument();

        $root = $xml->appendChild($xml->createElement('products'));
        
        $root->appendChild($xml->createElement('title', $name));
        $root->appendChild($xml->createElement('totalRows', count($data)));

        $rows = $root->appendChild($xml->createElement('rows'));

        foreach($data as $key => $value){
            $row = $rows->appendChild($xml->createElement('product'));
            foreach ($value as $subKey => $subValue){
                $row->appendChild($xml->createElement($subKey, htmlentities($subValue)));
            }
        }

        $xml->formatOutput = true;

        $name = date('Y_m_d_H_i_s') . "_{$name}.xml";
        $xml->save("{$this->output_path}/{$name}");

        return $name;
    }

    /**
     * Output message for JSON and XML
     */
    public function outputMessage($json, $xml)
    {
        echo 'Please Check:<br>';
        echo "- <strong>Output/{$json}</strong><br>";
        echo "- <strong>Output/{$xml}</strong><br><br>";

        echo "If you are using VS Code, please:<br>";
        echo "- Open and click inside the JSON file and make (CTRL + A) and (CTRL + K) and (CTRL + F) for better format.<br>";
        echo '- For Mac: make (CMD + A) and (CMD + K) and (CMD + F)';
    }
}