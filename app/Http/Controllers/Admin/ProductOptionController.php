<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Productoption;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $productId)
    {


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name' => ['required','max:255'],
        'price' => ['required','numeric'],
        'product_id' => ['required','integer']
    ],
    [
        'name.required' => 'Product option name is required',
        'name.max' => 'Product option max is 255 length',
        'price.required' => 'Product option price is required',
        'price.numeric' => 'Product option numeric have to be a number',
    ]);
    $option = new Productoption();
    $option->name = $request->name;
    $option->price = $request->price;
    $option->product_id = $request->product_id;
    $option->save();
    toastr()->success('Created Successfully');
    return redirect()->back();



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        try{
            $size = Productoption::Findorfail($id);
           $size->delete();
           return response(['status' => 'success', 'message' => 'Deleted Successfully']);

        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
    }
}
