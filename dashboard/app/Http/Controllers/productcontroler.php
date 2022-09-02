<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productcontroler extends Controller
{
    public function all()
    {
        return view('products.allproducts');
    }
    public function index()
    {
        $products = DB::table('products')->get();
        return view('products.allproducts', compact('products'));
    }

    public function create()
    {
        $brands = DB::table('brands')->select('id', 'name')->orderBy('name')
            ->orderBy('id')->get();
        $subcategories = DB::table('subcategories')->select('id', 'name_en', 'name_ar')->orderBy('name_en')
            ->orderBy('id')->get();
        return view('products.create', compact('brands', 'subcategories'));
    }
    public function delete($id){
        $deletepos = DB::table('products')->where('id','=',$id)->delete();
        $products = DB::table('products')->get();
        $success = "Product Deleted Successfully";
        return view('products.allproducts',compact('success','products'));
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', '=', $id)->first();
        $brands = DB::table('brands')->select('id', 'name')->orderBy('name')
            ->orderBy('id')->get();
        $subcategories = DB::table('subcategories')->select('id', 'name_en', 'name_ar')->orderBy('name_en')
            ->orderBy('id')->get();
        return view('products.edit', compact('product', 'brands', 'subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'image');
        $request->validate([
            'name_en' => ['required', 'max:255'],
            'name_ar' => ['required', 'max:255'],
            'price' => ['required', 'numeric', 'between:1,999999.99'],
            'quantity' => ['nullable', 'integer', 'between:1,999'],
            'status' => ['nullable', 'in:0,1'],
            'code' => ['required', 'integer', 'digits:6', 'unique:products,code'],
            'details_en' => ['required'],
            'details_ar' => ['required'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'subcategory_id' => ['required', 'integer', 'exists:subcategories,id'],
            'image' => ['required', 'max:1024', 'mimes:jpg,jpeg,png']
        ]);
        $photoName = $request->image->hashName();
        $photoPath = public_path('images\product');
        $request->image->move($photoPath, $photoName);
        $data['image'] = $photoName;
        // insert into db
        DB::table('products')->insert($data);
        return redirect()->back()->with('success', 'Product Created Successfully');
    }
}
