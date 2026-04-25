<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .total-row th { background-color: #f9f9f9; }
        .grand-total { font-size: 14px; font-weight: bold; color: #4e73df; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PURCHASE ORDER</h2>
        <p><strong>{{ config('app.name', 'StockSathi') }}</strong></p>
    </div>

    <table border="0" style="border: none;">
        <tr>
            <td style="border: none; width: 50%;">
                <strong>Supplier:</strong><br>
                {{ $order->supplier->name }}<br>
                {{ $order->supplier->address }}<br>
                {{ $order->supplier->mobile_no }}<br>
                {{ $order->supplier->email }}
            </td>
            <td style="border: none; width: 50%; text-align: right;">
                <strong>Order Info:</strong><br>
                PO No: {{ $order->po_no }}<br>
                Date: {{ $order->date }}<br>
                Status: {{ $order->status }}<br>
                Warehouse: {{ $order->warehouse->name }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Description</th>
                <th class="text-end">Cost</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Tax</th>
                <th class="text-end">Discount</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }} ({{ $item->product->product_code }})</td>
                    <td class="text-end">₹{{ number_format($item->unit_cost, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">₹{{ number_format($item->tax_amount, 2) }}</td>
                    <td class="text-end">₹{{ number_format($item->discount, 2) }}</td>
                    <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-end">Order Tax ({{ $order->tax_rate }}%)</th>
                <td class="text-end">₹{{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            <tr>
                <th colspan="6" class="text-end">Order Discount</th>
                <td class="text-end">₹{{ number_format($order->discount, 2) }}</td>
            </tr>
            <tr>
                <th colspan="6" class="text-end">Shipping</th>
                <td class="text-end">₹{{ number_format($order->shipping, 2) }}</td>
            </tr>
            <tr class="total-row">
                <th colspan="6" class="text-end grand-total">GRAND TOTAL</th>
                <td class="text-end grand-total">₹{{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($order->note)
        <div style="margin-top: 20px;">
            <strong>Note:</strong><br>
            {{ $order->note }}
        </div>
    @endif

    <div class="footer">
        Generated on {{ date('Y-m-d H:i:s') }}
    </div>
</body>
</html>
