<?php namespace App\Controllers;
use App\Models\ProductModel;

class Home extends BaseController {
    public function index() {
        $productModel = new ProductModel();
        $data['products'] = $productModel->orderBy('id', 'DESC')->findAll();
        
        return view('home/index', $data);
    }
}