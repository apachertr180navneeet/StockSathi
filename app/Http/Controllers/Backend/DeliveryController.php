<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function AllDelivery()
    {
        $allData = Delivery::with('sale.customer', 'sale.warehouse')->latest()->get();
        return view('admin.backend.delivery.all_delivery', compact('allData'));
    }

    public function AddDelivery($sale_id)
    {
        $sale = Sale::with('customer')->findOrFail($sale_id);
        
        // Check if delivery already exists
        $existing = Delivery::where('sale_id', $sale_id)->first();
        if($existing) {
            $notification = array(
                'message' => 'Delivery already created for this sale.',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        return view('admin.backend.delivery.add_delivery', compact('sale'));
    }

    public function StoreDelivery(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'delivery_date' => 'required',
        ]);

        $delivery_id = Delivery::insertGetId([
            'sale_id' => $request->sale_id,
            'delivery_no' => 'TEMP-' . time(),
            'courier_name' => $request->courier_name,
            'tracking_no' => $request->tracking_no,
            'status' => 'Pending',
            'delivery_date' => $request->delivery_date,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'created_at' => Carbon::now(),
        ]);

        // Update delivery_no with ID for professional look
        Delivery::findOrFail($delivery_id)->update([
            'delivery_no' => '#DEL-' . str_pad($delivery_id, 5, '0', STR_PAD_LEFT)
        ]);

        $notification = array(
            'message' => 'Delivery Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.delivery')->with($notification);
    }

    public function EditDelivery($id)
    {
        $delivery = Delivery::with('sale.customer')->findOrFail($id);
        return view('admin.backend.delivery.edit_delivery', compact('delivery'));
    }

    public function UpdateDelivery(Request $request)
    {
        $delivery_id = $request->id;

        Delivery::findOrFail($delivery_id)->update([
            'courier_name' => $request->courier_name,
            'tracking_no' => $request->tracking_no,
            'status' => $request->status,
            'delivery_date' => $request->delivery_date,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Delivery Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.delivery')->with($notification);
    }

    public function DeleteDelivery($id)
    {
        Delivery::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Delivery Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
