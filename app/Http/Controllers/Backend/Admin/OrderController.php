<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function create()
    {
        return view('admin.order.create');
    }

    public function edit($id)
    {
        return view('admin.orders.edit', compact('id'));
    }
}
