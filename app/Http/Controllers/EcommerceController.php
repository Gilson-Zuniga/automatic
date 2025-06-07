<?php

namespace App\Http\Controllers;


class EcommerceController extends Controller
{
    public function index()
    {
        // Puedes retornar una vista de ecommerce
        return view('ecommerce.index');
    }
}
