<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rack;
use App\Models\Bin;
use App\Models\WareHouse;
use Carbon\Carbon;

class BinController extends Controller
{
    // =============================================
    // RACK MANAGEMENT
    // =============================================

    public function AllRack()
    {
        $allRacks = Rack::with('warehouse', 'bins')->latest()->get();
        $warehouses = WareHouse::all();
        return view('admin.backend.bin_rack.all_rack', compact('allRacks', 'warehouses'));
    }

    public function StoreRack(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        Rack::create([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Rack Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function EditRack($id)
    {
        $rack = Rack::findOrFail($id);
        return response()->json($rack);
    }

    public function UpdateRack(Request $request)
    {
        $rack_id = $request->id;

        Rack::findOrFail($rack_id)->update([
            'warehouse_id' => $request->warehouse_id,
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Rack Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function DeleteRack($id)
    {
        Rack::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Rack Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // =============================================
    // BIN MANAGEMENT
    // =============================================

    public function AllBin()
    {
        $allBins = Bin::with('rack.warehouse')->latest()->get();
        $racks = Rack::with('warehouse')->get();
        return view('admin.backend.bin_rack.all_bin', compact('allBins', 'racks'));
    }

    public function StoreBin(Request $request)
    {
        $request->validate([
            'rack_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        Bin::create([
            'rack_id' => $request->rack_id,
            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Bin Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function EditBin($id)
    {
        $bin = Bin::findOrFail($id);
        return response()->json($bin);
    }

    public function UpdateBin(Request $request)
    {
        $bin_id = $request->id;

        Bin::findOrFail($bin_id)->update([
            'rack_id' => $request->rack_id,
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Bin Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function DeleteBin($id)
    {
        Bin::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Bin Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // AJAX: Get bins by rack
    public function GetBinsByRack($rack_id)
    {
        $bins = Bin::where('rack_id', $rack_id)->get();
        return response()->json($bins);
    }
}
