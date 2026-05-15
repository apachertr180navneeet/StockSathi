<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Imports\BrandsImport;
use App\Exports\SampleBrandExport;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
    /**
     * Display all brands
     */
    public function AllBrand(Request $request)
    {
        try {
            $query = Brand::query();

            // 🔍 SEARCH
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $brand = $query->orderBy('name', 'asc')->paginate(10);

            // ✅ AJAX RESPONSE (IMPORTANT)
            if ($request->ajax()) {
                return view('admin.backend.brand.partials.brand_table', compact('brand'))->render();
            }
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
                'name'  => 'required|max:100|unique:brands,name',
                'image' => 'nullable|mimes:jpg,jpeg,png',
            ]);

            $imagePath = null;

            if ($request->file('image')) {
                $image = $request->file('image');

                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $img = $manager->read($image);
                $img->resize(100, 90)->save(public_path('upload/brand/' . $name_gen));

                // ✅ Store only relative path
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
                'name'  => 'required|string|max:100|unique:brands,name,' . $request->id,
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

                // ✅ STORE FULL URL HERE
                $save_url = url('upload/brand/' . $name_gen);

                // ⚠️ Delete Old Image (handle both cases)
                if (!empty($brand->image)) {

                    // If old value is full URL → convert to path
                    $oldPath = str_replace(url('/') . '/', '', $brand->image);

                    if (file_exists(public_path($oldPath))) {
                        unlink(public_path($oldPath));
                    }
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

            return response()->json([
                'status' => 'success',
                'message' => 'Brand Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download sample CSV for import
     */
    public function DownloadSampleBrand()
    {
        return Excel::download(new SampleBrandExport, 'sample_brands.xlsx');
    }

    /**
     * Import brands from CSV/Excel
     */
    public function ImportBrand(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|mimes:csv,xlsx,xls',
            ]);

            $import = new BrandsImport();
            Excel::import($import, $request->file('import_file'));

            $imported = $import->imported;
            $failures = $import->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            $msg = $imported . ' brand(s) imported successfully.';
            $type = 'success';

            if (!empty($errors)) {
                $msg .= ' ' . count($errors) . ' row(s) skipped: ' . implode(' | ', $errors);
                $type = 'warning';
            }

            return redirect()->route('all.brand')->with([
                'message' => $msg,
                'alert-type' => $type
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Import failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show trashed brands
     */
    public function TrashList(Request $request)
    {
        try {
            $query = Brand::onlyTrashed();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $brand = $query->orderBy('deleted_at', 'desc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.brand.partials.brand_trash_table', compact('brand'))->render();
            }

            return view('admin.backend.brand.brand_trash', compact('brand'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Restore soft deleted brand
     */
    public function RestoreBrand($id)
    {
        try {
            $brand = Brand::withTrashed()->findOrFail($id);
            $brand->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Brand Restored Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Permanently delete brand
     */
    public function BulkDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Brand::whereIn('id', $ids)->delete();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' brand(s) deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkStatusChange(Request $request)
    {
        try {
            $ids = $request->ids;
            $status = $request->status;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Brand::whereIn('id', $ids)->update(['status' => $status]);
            $label = $status == 1 ? 'active' : 'inactive';
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' brand(s) set to ' . $label
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ChangeStatus($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->status = $brand->status ? 0 : 1;
            $brand->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Status changed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ParmanentDeleteBrand($id)
    {
        try {
            $brand = Brand::withTrashed()->findOrFail($id);

            // Delete image safely
            if (!empty($brand->image) && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }

            $brand->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Brand Permanently Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkRestore(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Brand::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' brand(s) restored successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkForceDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            $brands = Brand::withTrashed()->whereIn('id', $ids)->get();
            foreach ($brands as $brand) {
                if (!empty($brand->image) && file_exists(public_path($brand->image))) {
                    unlink(public_path($brand->image));
                }
                $brand->forceDelete();
            }
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' brand(s) permanently deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}