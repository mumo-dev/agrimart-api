<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //

    public function store(Request $request)
    {


        $product = $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',

        ]);

        /*save category*/
        $category = new Category();
        $category->name = $request->category;
        $category->save();

        /*save product*/
        $res = Product::create([
            'name' => $product['name'],
            'category_id' => $category->id,
            'description' => $product['description'],
            'price' => $product['price'],
            'user_id' => Auth::id()
        ]);

        /*save image*/
        if ($request->has('photo') && $request->file('photo') != null) {
            $images = $request->file('photo');

            foreach ($images as $image) {


                $path =$image->store('public/photos');

                $newImage = new Image();
                $newImage->img_path = Storage::url($path) ;
                $newImage->product_id = $res->id;
                $newImage->save();
            }


        }

        /*$url = Storage::url('design2.jpeg');*/

        return $res->with(['images'])->get();
    }
}
