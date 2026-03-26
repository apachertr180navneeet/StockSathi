<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\WareHouse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function AllCategory(){
        $category = ProductCategory::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));
    }
    //End Method 

    public function StoreCategory(Request $request){
        
        ProductCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
        ]);

        $notification = array(
            'message' => 'ProductCategory Inserted Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
 
    }
     //End Method 

     public function EditCategory($id){
        $category = ProductCategory::find($id);
        return response()->json($category);
     }
      //End Method 

      public function UpdateCategory(Request $request){
        $cat_id = $request->cat_id;

        ProductCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
        ]);

        $notification = array(
            'message' => 'ProductCategory Updated Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);
 
    }
     //End Method 

    public function DeleteCategory($id){

        ProductCategory::find($id)->delete();
        $notification = array(
            'message' => 'ProductCategory Delete Successfully',
            'alert-type' => 'success'
         ); 
         return redirect()->back()->with($notification);

    }
    //End Method 

    // ===============================
    // 🟢 All Products
    // ===============================
    public function AllProduct()
    {
        try {
            $allData = Product::latest()->get();
            return view('admin.backend.product.product_list', compact('allData'));
        } catch (\Exception $e) {
            Log::error('AllProduct Error: ' . $e->getMessage());

            return back()->with([
                'message' => 'Unable to fetch products',
                'alert-type' => 'error'
            ]);
        }
    }


    // ===============================
    // 🟢 Add Product Form
    // ===============================
    public function AddProduct()
    {
        try {
            $categories = ProductCategory::all();
            $brands = Brand::all();
            $suppliers = Supplier::all();
            $warehouses = WareHouse::all();

            return view('admin.backend.product.add_product', compact(
                'categories',
                'brands',
                'suppliers',
                'warehouses'
            ));
        } catch (\Exception $e) {
            Log::error('AddProduct Error: ' . $e->getMessage());

            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }


    // ===============================
    // 🟢 Store Product
    // ===============================
    public function StoreProduct(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:100|unique:products,code',
            'category_id'   => 'required|exists:product_categories,id',
            'brand_id'      => 'nullable|exists:brands,id',
            'warehouse_id'  => 'nullable|exists:ware_houses,id',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'price'         => 'required|numeric|min:0',
            'product_qty'   => 'required|numeric|min:0',
            'stock_alert'   => 'nullable|numeric|min:0',
            'status'        => 'required|in:0,1',
            'image.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            // ✅ Insert Product
            $product = Product::create([
                'name'          => $request->name,
                'code'          => $request->code,
                'category_id'   => $request->category_id,
                'brand_id'      => $request->brand_id,
                'warehouse_id'  => $request->warehouse_id,
                'supplier_id'   => $request->supplier_id,
                'price'         => $request->price,
                'stock_alert'   => $request->stock_alert,
                'note'          => $request->note,
                'product_qty'   => $request->product_qty,
                'status'        => $request->status,
                'created_at'    => now(),
            ]);

            // ✅ Multiple Image Upload
            if ($request->hasFile('image')) {

                $manager = new ImageManager(new Driver());

                foreach ($request->file('image') as $img) {

                    $name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

                    $image = $manager->read($img);
                    $image->resize(150, 150)
                          ->save(public_path('upload/productimg/' . $name));

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => 'upload/productimg/' . $name,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('all.product')->with([
                'message' => 'Product Inserted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('StoreProduct Error: ' . $e->getMessage());

            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }


    // ===============================
    // 🟢 Edit Product
    // ===============================
    public function EditProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $categories = ProductCategory::all();
            $brands = Brand::all();
            $suppliers = Supplier::all();
            $warehouses = WareHouse::all();
            $multiImgs = ProductImage::where('product_id', $id)->get();

            return view('admin.backend.product.edit_product', compact(
                'product',
                'categories',
                'brands',
                'suppliers',
                'warehouses',
                'multiImgs'
            ));
        } catch (\Exception $e) {
            Log::error('EditProduct Error: ' . $e->getMessage());

            return back()->with([
                'message' => 'Product not found',
                'alert-type' => 'error'
            ]);
        }
    }


    // ===============================
    // 🟢 Update Product
    // ===============================
    public function UpdateProduct(Request $request)
    {
        $id = $request->id;

        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'code')->ignore($id),
            ],
            'price' => 'required|numeric|min:0',
            'product_qty' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // ✅ Update Product
            Product::findOrFail($id)->update([
                'name'          => $request->name,
                'code'          => $request->code,
                'category_id'   => $request->category_id,
                'brand_id'      => $request->brand_id,
                'warehouse_id'  => $request->warehouse_id,
                'supplier_id'   => $request->supplier_id,
                'price'         => $request->price,
                'stock_alert'   => $request->stock_alert,
                'note'          => $request->note,
                'product_qty'   => $request->product_qty,
                'status'        => $request->status,
            ]);

            // ✅ New Images Upload
            if ($request->hasFile('image')) {

                $manager = new ImageManager(new Driver());

                foreach ($request->file('image') as $img) {

                    $name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

                    $image = $manager->read($img);
                    $image->resize(150, 150)
                          ->save(public_path('upload/productimg/' . $name));

                    ProductImage::create([
                        'product_id' => $id,
                        'image'      => 'upload/productimg/' . $name,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('all.product')->with([
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('UpdateProduct Error: ' . $e->getMessage());

            return back()->withInput()->with([
                'message' => 'Update failed!',
                'alert-type' => 'error'
            ]);
        }
    }


    // ===============================
    // 🟢 Delete Product
    // ===============================
    public function DeleteProduct($id)
    {
        DB::beginTransaction();

        try {

            $images = ProductImage::where('product_id', $id)->get();

            // ✅ Delete Images from Folder
            foreach ($images as $img) {
                $imgPath = public_path($img->image);
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }

            // ✅ Delete DB Records
            ProductImage::where('product_id', $id)->delete();
            Product::findOrFail($id)->delete();

            DB::commit();

            return back()->with([
                'message' => 'Product Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('DeleteProduct Error: ' . $e->getMessage());

            return back()->with([
                'message' => 'Delete failed!',
                'alert-type' => 'error'
            ]);
        }
    }



}
