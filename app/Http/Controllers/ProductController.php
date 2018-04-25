<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function getAll()
    {
        $products = $this->getJsonData();
        return ['message' => 'All Products.','data'=>$products];
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'product_name' => 'required|string|max:30',
           'product_price' => 'required|numeric',
           'product_quantity' => 'required|numeric',
        ]);

        $products = $this->getJsonData();

        $data = [
            'prodID' => last($products)['prodID']+1,
            'prodName' => $request['product_name'],
            'prodPricePerItem' => (double)$request['product_price'],
            'prodQuantity' => (int)$request['product_quantity'],
            'dateSubmitted' => date('DD-MM-YYY')
        ];

        array_push($products,$data);

        $this->saveJsonData($products);

        return ['message' => 'Product Added.','data'=>$data];
    }

    public function update(Request $request, $productID)
    {
        $this->validate($request,[
            'product_name' => 'required|string|max:30',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|numeric',
        ]);

        $data = [
            'prodID' => $productID,
            'prodName' => $request['product_name'],
            'prodPricePerItem' => (double)$request['product_price'],
            'prodQuantity' => (int)$request['product_quantity'],
            'dateSubmitted' => Carbon::today()
        ];

        array_push($products,$data);

        $this->saveJsonData($products);

        return ['message' => 'Product Updated.',$data];
    }

    public function getJsonData()
    {
        $rawData = file_get_contents('products.json');
        $parsedData = json_decode($rawData,true);
        return $parsedData;
    }

    public function saveJsonData($data)
    {
        $encodedData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('products.json',$encodedData);
    }
}
