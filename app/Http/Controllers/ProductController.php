<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\WpProduct;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $products=Product::getAllProduct();
    //     // return $products;
    //     return view('backend.product.index')->with('products',$products);
    // }

    public function index()
    {
        $products=WpProduct::where('vendor_id',Auth::id())->get();
        // return $products;
        return view('backend.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::get();
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.product.create')->with('categories',$category)->with('brands',$brand);
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

    public function removeGalleryImage(Request $request)
    {
        // dd($request->all());
        $imageUrl = $request->imageUrl;

        // Logic to remove $imageUrl from $product->photo_gallery
        $product = WpProduct::find($request->id); // Adjust this to fetch your product

        $gallery = json_decode($product->photo_gallery);

        // Remove the image URL from the array
        $gallery = array_values(array_diff($gallery, [$imageUrl]));

        // Update the product's photo_gallery field
        $product->photo_gallery = json_encode($gallery);
        $product->save();

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $brand=Brand::get();
        $product=WpProduct::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=WpProduct::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')->with('product',$product)
                    ->with('categories',$category)
                    ->with('items',$items);
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
        // return $request->all();
        $product = WpProduct::findOrFail($id);
        $old_product = clone $product;
        $sku = $old_product->sku;

        // Update main photo
        if ($request->file('photo')) {
            $mainPhotoPath = $request->file('photo')->store('photos', 'public');
            $fullMainPhotoUrl = asset('storage/' . $mainPhotoPath);
            $product->main_photo = $fullMainPhotoUrl;
        }

        // Update photo gallery
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('photos', 'public');
                $fullUrl = asset('storage/' . $path);
                $galleryPaths[] = $fullUrl;
            }
            $product->photo_gallery = json_encode($galleryPaths);
        }

        // Update product fields
        $product->category_id = $request->category_id;
        $product->name = $request->prod_name;
        $product->description = $request->description;
        $product->short_description = $request->short_desc;
        $product->regular_price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->sku;
        $product->stock_status = $request->productStatus;
        $product->igi_certificate = $request->IGI_certificate;
        $product->quantity = $request->quantity;
        $product->document_number = $request->document_number;

        // Update product attributes
        if ($request->has('attributes')) {
            $product->attributes()->delete();
            foreach ($request->input('attributes') as $name => $value) {
                $product->attributes()->create([
                    'name' => $name,
                    'value' => $value,
                ]);
            }
        }

        // Save the product
        $product->save();


        $wooResponse = [];
        // Call the WooCommerce update function
        //  $wooResponse = WooCommerceProductController::editProductInWooCommerce($sku, $product);

        if (isset($wooResponse['error'])) {
            // Handle WooCommerce update error
            return redirect()->route('product.index')->with('error', 'Failed to update product in WooCommerce: ' . $wooResponse['error']);
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=WpProduct::findOrFail($id);

        $mainPhoto=$product->main_photo;
        $gallery=json_decode($product->photo_gallery,true);

        if ($mainPhoto) {
            $mainPhotoPath = parse_url($mainPhoto, PHP_URL_PATH); // Extract path from URL
            Storage::delete('public' . Str::after($mainPhotoPath, 'storage')); // Adjust path as needed
        }

        if ($gallery) {
            foreach ($gallery as $photo) {
                $photoPath = parse_url($photo, PHP_URL_PATH); // Extract path from URL
                Storage::delete('public' . Str::after($photoPath, 'storage')); // Adjust path as needed
            }
        }

        $status=$product->delete();

        if($status){
            request()->session()->flash('success','Product deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }


    public function store(Request $request){
        // dd($request->all());

        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'prod_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lte:price',
            'sku' => 'nullable|string|max:255|unique:wp_products,sku', // Replace 'products' with your actual table name
            'quantity' => 'nullable|integer|min:1',
            'IGI_certificate' => 'nullable|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*' => 'required'
        ], [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'prod_name.required' => 'Product name is required',
            'price.numeric' => 'Price must be a number',
            'sale_price.numeric' => 'Sale price must be a number',
            'sale_price.lt' => 'Sale price must be less than regular price',
            'sku.string' => 'SKU must be a string',
            'sku.max' => 'SKU must not exceed 255 characters',
            'sku.unique' => 'SKU already exists',
            'quantity.integer' => 'Quantity must be an integer',
            'quantity.min' => 'Quantity must be greater than zero',
            'IGI_certificate.string' => 'IGI certificate must be a string',
            'photo.image' => 'Main photo must be an image',
            'photo.mimes' => 'Main photo must be a file of type: jpeg, png, jpg, gif, svg',
            'photo.max' => 'Main photo may not be greater than 2048 kilobytes',
            'gallery.array' => 'Gallery must be an array',
            'gallery.*.image' => 'Gallery images must be images',
            'gallery.*.mimes' => 'Gallery images must be files of type: jpeg, png, jpg, gif, svg',
            'gallery.*.max' => 'Gallery images may not be greater than 2048 kilobytes',
            'attributes.array' => 'Attributes must be an array',
        ]);

        if ($request->hasFile('photo')) {
            $mainPhotoPath = $request->file('photo')->store('photos', 'public');
            $fullMainPhotoUrl = asset('storage/' . $mainPhotoPath);
        } else {
            $fullMainPhotoUrl = null;
        }


        $galleryPaths = [];
        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $galleryImage) {
                // Store the image in the 'public' disk under the 'photos' directory
                $path = $galleryImage->store('photos', 'public');

                // Get the full URL to the stored image
                $fullUrl = asset('storage/' . $path);

                // Store the full URL in the array
                $galleryPaths[] = $fullUrl;
            }
        }



        $wpProduct = WpProduct::create([
            'vendor_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->prod_name,
            'description' => $request->description,
            'short_description' => $request->short_desc,
            'regular_price' => $request->price,
            'sale_price' => $request->sale_price??$request->price,
            'sku' => $request->sku,
            'stock_status' => $request->productStatus,
            'igi_certificate' => $request->IGI_certificate,
            'main_photo' => $fullMainPhotoUrl,
            'photo_gallery' => json_encode($galleryPaths),
            'quantity' => $request->quantity,
            'document_number' => $request->document_number ?? 123,
        ]);


        // Add attributes if any
            if ($request->has('attributes')) {
                foreach ($request->input('attributes') as $name => $value) {
                    $wpProduct->attributes()->create([
                        'name' => $name,
                        'value' => $value,
                    ]);
                }
            }

            return redirect()->route('product.index')->with('success', 'Products imported successfully.');

    }


}
