<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000; margin: 0; padding: 15px; width: 80mm; background: #fff; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        .border-top { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
        .border-bottom { border-bottom: 1px dashed #000; margin-bottom: 5px; padding-bottom: 5px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 3px 0; vertical-align: top; }
        .store-logo { font-size: 20px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .header-info p { margin: 2px 0; }
        .receipt-title { font-size: 16px; margin: 10px 0; border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; }
        @media print {
            body { width: 100%; }
            #print_btn { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div style="text-align: center; margin-bottom: 10px;" id="print_btn">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Print Receipt</button>
    </div>

    <div class="text-center">
        <div class="store-logo">StockSathi</div>
        <div class="header-info">
            <p>123 Business Road, Suite 100</p>
            <p>City, State, 12345</p>
            <p>Tel: +1 234 567 890</p>
        </div>
        
        <div class="receipt-title fw-bold">TAX RECEIPT</div>
    </div>

    <div>
        <p style="margin: 3px 0;"><strong>Receipt #:</strong> SALE-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p style="margin: 3px 0;"><strong>Date:</strong> {{ date('d M Y h:i A', strtotime($sale->created_at)) }}</p>
        <p style="margin: 3px 0;"><strong>Customer:</strong> {{ $sale->customer->name ?? 'Walk-in' }}</p>
        <p style="margin: 3px 0;"><strong>Warehouse:</strong> {{ $sale->warehouse->name ?? 'Main' }}</p>
    </div>

    <table class="table border-top border-bottom" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" style="width: 50%;">Item</th>
                <th class="text-center" style="width: 20%;">Qty</th>
                <th class="text-right" style="width: 30%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td class="text-left">
                    {{ $item->product->name }}
                    <br><small>@ ₹{{ number_format($item->net_unit_cost, 2) }}</small>
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">₹{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table">
        <tr>
            <td class="text-right fw-bold" style="width: 70%;">Subtotal:</td>
            <td class="text-right">₹{{ number_format($sale->saleItems->sum('subtotal'), 2) }}</td>
        </tr>
        @if($sale->discount > 0)
        <tr>
            <td class="text-right fw-bold">Discount:</td>
            <td class="text-right">-₹{{ number_format($sale->discount, 2) }}</td>
        </tr>
        @endif
        @if($sale->tax_amount > 0)
        <tr>
            <td class="text-right fw-bold">Tax:</td>
            <td class="text-right">₹{{ number_format($sale->tax_amount, 2) }}</td>
        </tr>
        @endif
        <tr style="font-size: 14px;">
            <td class="text-right fw-bold border-top">GRAND TOTAL:</td>
            <td class="text-right fw-bold border-top">₹{{ number_format($sale->grand_total, 2) }}</td>
        </tr>
    </table>

    <table class="table border-top" style="margin-top: 5px;">
        <tr>
            <td class="text-right" style="width: 70%;">Payment Method:</td>
            <td class="text-right">{{ $sale->payment_method ?? 'Cash' }}</td>
        </tr>
        <tr>
            <td class="text-right">Paid Amount:</td>
            <td class="text-right">₹{{ number_format($sale->paid_amount, 2) }}</td>
        </tr>
        <tr>
            <td class="text-right fw-bold">Due Amount:</td>
            <td class="text-right fw-bold">₹{{ number_format($sale->due_amount, 2) }}</td>
        </tr>
    </table>

    <div class="text-center border-top" style="margin-top: 15px;">
        <p>Thank you for your purchase!</p>
        <p>Please visit again.</p>
        <div style="margin-top: 10px;">
            <svg id="barcode"></svg>
        </div>
    </div>

    <!-- Generate simple 1D barcode using JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#barcode", "SALE-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}", {
            format: "CODE128",
            lineColor: "#000",
            width: 1.5,
            height: 40,
            displayValue: true
        });
    </script>
</body>
</html>
