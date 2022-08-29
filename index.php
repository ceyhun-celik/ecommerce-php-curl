<?php
/**
 * @author: Ceyhun Celik
 */

# Helpers
require_once(__DIR__ . '/App/Helpers.php');

# Commerces
foreach (glob(__DIR__ . '/App/Services/*.php') as $commerce){
    require_once($commerce);
}

# Routes
switch($_GET['route'] ?? 'home'){
    case 'home':
        require_once(__DIR__ . '/App/Views/home.html');
        break;
    case 'ecommerce1':
        $ecommerce1 = $ecommerce1->setProducts();
        break;

    case 'ecommerce2':
        $ecommerce2 = $ecommerce2->setProducts();
        break;

    case 'ecommerce3':
        $ecommerce3 = $ecommerce3->setProducts();
        break;
    
    default:
        require_once(__DIR__ . '/App/Views/404.html');
        break;
}