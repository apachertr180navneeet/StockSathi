<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Order PDF</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; color: #333; margin: 0; padding: 0; }
        .invoice-container { width: 100%; max-width: 800px; margin: auto; }
        .header { border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: top; width: 50%; }
        .header-right { display: table-cell; vertical-align: top; width: 50%; text-align: right; }
        .header-right h1 { margin: 0; color: #0056b3; font-size: 28px; font-weight: bold; text-transform: uppercase; }
        .invoice-details { margin-top: 10px; font-size: 12px; }
        .billing-info { display: table; width: 100%; margin-bottom: 20px; }
        .bill-to { display: table-cell; width: 50%; }
        .ship-from { display: table-cell; width: 50%; text-align: right; }
        .section-title { font-weight: bold; color: #0056b3; font-size: 14px; margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items th { background: #0056b3; color: white; text-align: left; padding: 10px; font-size: 13px; }
        table.items td { border-bottom: 1px solid #ddd; padding: 10px; font-size: 12px; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .totals-section { display: table; width: 100%; margin-top: 20px; }
        .totals-space { display: table-cell; width: 60%; }
        .totals { display: table-cell; width: 40%; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals table td { padding: 5px 10px; border-bottom: 1px solid #eee; }
        .totals table td:first-child { font-weight: bold; }
        .grand-total { background: #f4f6f9; font-weight: bold; color: #0056b3; font-size: 14px; }
        .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px; color: #fff; background-color: #28a745; }
        .status-badge.Pending { background-color: #ffc107; color: #212529; }
        .status-badge.Ordered { background-color: #17a2b8; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="header-left">
                <h2 style="margin:0; color:#333;">StockSathi</h2>
                <p style="margin:5px 0 0; color:#555;">Inventory Management System<br>123 Business Road, Suite 100<br>City, State, 12345</p>
            </div>
            <div class="header-right">
                <h1>SALES ORDER</h1>
                <div class="invoice-details">
                    <p><strong>Sales Order No:</strong> #SO-{{ str_pad($salesOrder->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Date:</strong> {{ date('d M Y', strtotime($salesOrder->date)) }}</p>
                    <p><strong>Status:</strong> <span class="status-badge {{ $salesOrder->status }}">{{ $salesOrder->status }}</span></p>
                </div>
            </div>
        </div>

        <div class="billing-info">
            <div class="bill-to">
                <div class="section-title">Bill To</div>
                <p style="margin: 5px 0 2px; font-weight: bold;">{{ $salesOrder->customer->name }}</p>
                @if($salesOrder->customer->email)<p style="margin: 0 0 2px;">{{ $salesOrder->customer->email }}</p>@endif
                @if($salesOrder->customer->phone)<p style="margin: 0 0 2px;">{{ $salesOrder->customer->phone }}</p>@endif
                @if($salesOrder->customer->address)<p style="margin: 0 0 2px;">{{ $salesOrder->customer->address }}</p>@endif
            </div>
            <div class="ship-from">
                <div class="section-title" style="text-align: right;">Dispatched From</div>
                <p style="margin: 5px 0 2px; font-weight: bold;">{{ $salesOrder->warehouse->name }}</p>
                @if($salesOrder->warehouse->phone)<p style="margin: 0 0 2px;">Tel: {{ $salesOrder->warehouse->phone }}</p>@endif
                @if($salesOrder->warehouse->email)<p style="margin: 0 0 2px;">{{ $salesOrder->warehouse->email }}</p>@endif
                @if($salesOrder->warehouse->address)<p style="margin: 0 0 2px;">{{ $salesOrder->warehouse->address }}</p>@endif
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 35%;">Item Description</th>
                    <th class="text-center" style="width: 15%;">Unit Cost</th>
                    <th class="text-center" style="width: 10%;">Qty</th>
                    <th class="text-center" style="width: 15%;">Discount</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesOrder->salesOrderItems as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $item->product->name }}</strong>
                            @if($item->product->code)
                            <br><span style="font-size: 10px; color: #777;">Code: {{ $item->product->code }}</span>
                            @endif
                        </td>
                        <td class="text-center">₹{{ number_format($item->net_unit_cost, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-center">₹{{ number_format($item->discount, 2) }}</td>
                        <td class="text-right">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <div class="totals-space">
                @if($salesOrder->note)
                <div style="margin-top: 20px; padding: 10px; background: #f9f9f9; border-left: 3px solid #0056b3;">
                    <strong style="display: block; margin-bottom: 5px; font-size: 12px;">Notes/Terms:</strong>
                    <p style="margin: 0; font-size: 11px;">{{ $salesOrder->note }}</p>
                </div>
                @endif
            </div>
            <div class="totals">
                @php
                    $subtotal = $salesOrder->salesOrderItems->sum('subtotal');
                @endphp
                <table>
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-right">₹{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    @if($salesOrder->discount > 0)
                    <tr>
                        <td>Order Discount</td>
                        <td class="text-right" style="color: #dc3545;">-₹{{ number_format($salesOrder->discount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Tax (GST @ {{ number_format($salesOrder->tax_rate, 2) }}%)</td>
                        <td class="text-right">₹{{ number_format($salesOrder->tax_amount, 2) }}</td>
                    </tr>
                    @if($salesOrder->shipping > 0)
                    <tr>
                        <td>Shipping Cost</td>
                        <td class="text-right">₹{{ number_format($salesOrder->shipping, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="grand-total">
                        <td style="padding: 10px;">Grand Total</td>
                        <td class="text-right" style="padding: 10px;">₹{{ number_format($salesOrder->grand_total, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated document and requires no signature.</p>
        </div>
    </div>
</body>
</html>
