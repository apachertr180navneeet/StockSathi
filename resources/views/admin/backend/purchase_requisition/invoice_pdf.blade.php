<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Requisition</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; color: #333; margin: 0; padding: 0; }
        .invoice-container { width: 100%; max-width: 800px; margin: auto; }
        .header { border-bottom: 2px solid #17a2b8; padding-bottom: 10px; margin-bottom: 20px; display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: top; width: 50%; }
        .header-right { display: table-cell; vertical-align: top; width: 50%; text-align: right; }
        .header-right h1 { margin: 0; color: #17a2b8; font-size: 28px; font-weight: bold; text-transform: uppercase; }
        .invoice-details { margin-top: 10px; font-size: 12px; }
        .billing-info { display: table; width: 100%; margin-bottom: 20px; }
        .bill-to { display: table-cell; width: 50%; }
        .ship-from { display: table-cell; width: 50%; text-align: right; }
        .section-title { font-weight: bold; color: #17a2b8; font-size: 14px; margin-bottom: 5px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items th { background: #17a2b8; color: white; text-align: left; padding: 10px; font-size: 13px; }
        table.items td { border-bottom: 1px solid #ddd; padding: 10px; font-size: 12px; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .totals-section { display: table; width: 100%; margin-top: 20px; }
        .totals-space { display: table-cell; width: 60%; }
        .totals { display: table-cell; width: 40%; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals table td { padding: 5px 10px; border-bottom: 1px solid #eee; }
        .totals table td:first-child { font-weight: bold; }
        .grand-total { background: #f4f6f9; font-weight: bold; color: #17a2b8; font-size: 14px; }
        .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="header-left">
                <h2 style="margin:0; color:#333;">StockSathi</h2>
                <p style="margin:5px 0 0; color:#555;">Inventory Management System<br>Internal Requisition Document</p>
            </div>
            <div class="header-right">
                <h1>PURCHASE REQUISITION</h1>
                <div class="invoice-details">
                    <p><strong>Req No:</strong> #{{ $requisition->requisition_no }}</p>
                    <p><strong>Date:</strong> {{ date('d M Y', strtotime($requisition->date)) }}</p>
                    <p><strong>Status:</strong> {{ $requisition->status }}</p>
                    <p><strong>Requested By:</strong> {{ $requisition->user->name ?? 'System' }}</p>
                </div>
            </div>
        </div>

        <div class="billing-info">
            <div class="bill-to">
                <div class="section-title">Supplier (Suggested)</div>
                <p style="margin: 5px 0 2px; font-weight: bold;">{{ $requisition->supplier->name ?? 'N/A' }}</p>
                @if($requisition->supplier)
                    <p style="margin: 0 0 2px;">{{ $requisition->supplier->email }}</p>
                    <p style="margin: 0 0 2px;">{{ $requisition->supplier->phone }}</p>
                @endif
            </div>
            <div class="ship-from">
                <div class="section-title" style="text-align: right;">Target Warehouse</div>
                <p style="margin: 5px 0 2px; font-weight: bold;">{{ $requisition->warehouse->name ?? 'N/A' }}</p>
                @if($requisition->warehouse)
                    <p style="margin: 0 0 2px;">{{ $requisition->warehouse->address }}</p>
                @endif
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Product Description</th>
                    <th class="text-center" style="width: 15%;">Est. Cost</th>
                    <th class="text-center" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisition->requisitionItems as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $item->product->name }}</strong><br>
                            <span style="font-size: 10px; color: #777;">Code: {{ $item->product->code }}</span>
                        </td>
                        <td class="text-center">₹{{ number_format($item->estimated_cost, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <div class="totals-space">
                @if($requisition->note)
                <div style="margin-top: 20px; padding: 10px; background: #f9f9f9; border-left: 3px solid #17a2b8;">
                    <strong style="display: block; margin-bottom: 5px; font-size: 12px;">Notes:</strong>
                    <p style="margin: 0; font-size: 11px;">{{ $requisition->note }}</p>
                </div>
                @endif
            </div>
            <div class="totals">
                <table>
                    <tr class="grand-total">
                        <td style="padding: 10px;">Total Amount</td>
                        <td class="text-right" style="padding: 10px;">₹{{ number_format($requisition->total_amount, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer" style="margin-top: 100px;">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 50%; text-align: left;">
                    <p>_______________________</p>
                    <p>Requested By</p>
                </div>
                <div style="display: table-cell; width: 50%; text-align: right;">
                    <p>_______________________</p>
                    <p>Authorized Approval</p>
                </div>
            </div>
            <p style="margin-top: 30px;">This is a computer-generated internal requisition.</p>
        </div>
    </div>
</body>
</html>
