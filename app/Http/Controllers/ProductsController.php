<?php namespace CS\Http\Controllers;

use CS\Entities\Product;

class ProductsController extends BaseController {
    /**
     * @var Product
     */
    private $product;

    /**
     * @param Product $product
     */
    public function __construct(Product $product){
        $this->product = $product;
    }

    public function index()
    {
        //
    }
    public function show($uuid)
    {
        $reponse = $this->product->show($uuid);
        return $reponse;
    }

}
