<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Product::with('galleries')->get();
        return view('backend.product.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $data['ThumbnailPhoto'] = $request->file('ThumbnailPhoto')->store('assets/product', 'public',$request->file('ThumbnailPhoto')->GetClientOriginalName());

        $product =  Product::create($data);


        $gallery = [
            'Products_id' => $product -> id,
            'Photos' =>  $request->file('ThumbnailPhoto')->store('assets/product', 'public'),
        ];

        ProductGallery::create($gallery);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('backend.product.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Product::findOrFail($id);
        $data = $request -> all();
        $data['ThumbnailPhoto'] = $request->file('ThumbnailPhoto')->store('assets/product', 'public',$request->file('ThumbnailPhoto')->GetClientOriginalName());

        $insert =  $item -> update($data);

        return redirect()->route('product.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductGallery::with('Product')->where('Products_id',$id)->delete();
        Product::findOrFail($id)->delete();
        
        return redirect()->route('product.index');
    }
}
