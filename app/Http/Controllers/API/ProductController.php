<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products) , 'All products sent');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator=Validator::make($input ,[
            'name' => 'required',
            'price' => 'required',
            'details' => 'required',
            'photo' => 'required|image'
        ]);
        if($validator->fails()){
            return $this->sendError('please validate your data' , $validator->errors());
        }

        $photo = $request->photo;
        $newPhoto = time().$photo->getClientOriginalName();
        $photo->move('uploads/posts',$newPhoto);

        $product=Product::create([
            'name' => $request->name ,
            'price' => $request->price,
            'details' => $request->details,
            'photo' =>  'uploads/posts'.$newPhoto ,
        ]);
        return $this->sendResponse(new ProductResource($product), 'Product created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::find($id);
        if (is_null($product)) {
            return $this->sendError('product not Found');
        }
        return $this->sendResponse(new ProductResource($product)  , 'Product found successfully');
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator=Validator::make($input ,[
            'name' => 'required',
            'price' => 'required',
            'details' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('please validate your data' , $validator->errors());
        }
        $product->name = $input['name'];
        $product->details = $input['details'];
        $product->price = $input['price'];
        $product->save();

        return $this->sendResponse(new ProductResource($product)     , 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       $product->delete();
       $products = Product::all();
       return $this->sendResponse(ProductResource::collection($products) , 'Product deleted successfully');
    }
}
