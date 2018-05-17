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

    public function index(Request $request)
    {


        if ($request->q == null && $request->category == null) {
            $products = Product::with(['images', 'category'])->paginate(5);
            return response()->json($products);
        } elseif ($request->q || $request->category) {
            if ($request->q && $request->category) {
                $category = Category::where('name', $request->category)->get();
                if ($category->first()) {
                    $products = Product::with(['images', 'category'])
                        ->where('category_id', $category->first()->id)
                        ->where('name', 'LIKE', '%' . $request->q . '%')
                        ->get();
                    return response()->json($products);
                }
                return response()->json([
                   'message'=>"Category specified not found"
                ]);
            }
            if ($request->q) {
                $products = Product::with(['images', 'category'])
                    ->where('name', 'LIKE', '%' . $request->q . '%')->get();
                return response()->json($products);
            } else if ($request->category) {

                $category = Category::where('name', $request->category)->get();
                if($category->first()) {
                    $products = Product::with(['images', 'category'])
                        ->where('category_id', $category->first()->id)->get();
                    return response()->json($products);
                }
                return response()->json([
                    'message'=>"Category specified not found"
                ]);
            }
        }

    }

    public function fetchCategories()
    {
        $categories = Category::all();
        return $categories;
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);;
    }

    public function store(Request $request)
    {


        $product = $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'photo' => 'mimes:jpeg,bmp,png,jpg,svg,gif' //jpeg, png, bmp, gif, or svg

        ]);

        /*save category must be unique
            $category = new Category();
            $category->name = $request->category;
            $category->save();
         */
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


                $path = $image->store('public/photos');

                $newImage = new Image();
                $newImage->img_path = Storage::url($path);
                $newImage->product_id = $res->id;
                $newImage->save();
            }


        }

        /*$url = Storage::url('design2.jpeg');*/

        return response()->json([
            'message' => 'product added successfully'
        ]);
    }
}
