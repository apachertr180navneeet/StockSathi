<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
    /**
     * Display all brands
     */
    public function AllBrand()
    {
        try {
            $brand = Brand::latest()->get();
            return view('admin.backend.brand.all_brand', compact('brand'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add brand form
     */
    public function AddBrand()
    {
        return view('admin.backend.brand.add_brand');
    }

    /**
     * Store brand
     */
    public function StoreBrand(Request $request)
    {
        try {

            // ✅ Validation
            $request->validate([
                'name'  => 'required|max:100',
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);

            $imagePath = null;

            if ($request->file('image')) {
                $image = $request->file('image');

                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $img = $manager->read($image);
                $img->resize(100, 90)->save(public_path('upload/brand/' . $name_gen));

                // ✅ FULL URL save
                $imagePath = url('upload/brand/' . $name_gen);
            }

            Brand::create([
                'name'  => $request->name,
                'image' => $imagePath
            ]);

            return redirect()->route('all.brand')->with([
                'message' => 'Brand Inserted Successfully',
                'alert-type' => 'success'
            ]);

        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } 
        catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Edit brand
     */
    public function EditBrand($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            return view('admin.backend.brand.edit_brand', compact('brand'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Brand not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update brand
     */
    public function UpdateBrand(Request $request)
    {
        try {

            // ✅ Proper Validation
            $request->validate([
                'id'    => 'required|exists:brands,id',
                'name'  => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $brand = Brand::findOrFail($request->id);

            // ✅ If Image Uploaded
            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $img = $manager->read($image);
                $img->resize(100, 90)->save(public_path('upload/brand/' . $name_gen));

                $save_url = 'upload/brand/' . $name_gen;

                // ✅ Delete Old Image (safe)
                if (!empty($brand->image) && file_exists(public_path($brand->image))) {
                    unlink(public_path($brand->image));
                }

                $brand->update([
                    'name'  => $request->name,
                    'image' => $save_url
                ]);

                $message = 'Brand Updated with Image Successfully';

            } else {

                // ✅ Only Name Update
                $brand->update([
                    'name' => $request->name
                ]);

                $message = 'Brand Updated Successfully';
            }

            return redirect()->route('all.brand')->with([
                'message' => $message,
                'alert-type' => 'success'
            ]);

        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // ❌ toastr me convert nahi karega
        } 
        catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete brand
     */
    public function DeleteBrand($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Delete image safely
            if (!empty($brand->image) && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }

            $brand->delete();

            return back()->with([
                'message' => 'Brand Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}