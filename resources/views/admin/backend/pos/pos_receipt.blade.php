<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: 'Courier New', Courier, 'Segoe UI', Arial, sans-serif; font-size: 13px; color: #000; background: #e9ecef; display: flex; flex-direction: column; align-items: center; padding: 20px; }
        .receipt-paper { width: 80mm; max-width: 100%; background: #fff; padding: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); border-radius: 4px; margin-bottom: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        .border-top { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
        .border-bottom { border-bottom: 1px dashed #000; margin-bottom: 5px; padding-bottom: 5px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 4px 0; vertical-align: top; }
        .store-logo { font-size: 20px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 2px; }
        .header-info p { margin: 2px 0; font-size: 11px; }
        .receipt-title { font-size: 16px; margin: 10px 0; border-top: 1px dashed #000; border-bottom: 1px dashed #000; padding: 5px 0; letter-spacing: 1px; }
        .info-line { display: flex; justify-content: space-between; margin: 3px 0; font-size: 12px; }
        .btn-print { display: inline-block; padding: 10px 30px; font-size: 16px; cursor: pointer; background: #0d6efd; color: #fff; border: none; border-radius: 6px; font-family: Arial, sans-serif; margin-bottom: 15px; }
        .btn-print:hover { background: #0b5ed7; }
        .thanks { margin-top: 15px; padding-top: 10px; font-size: 13px; letter-spacing: 1px; }
        @media print {
            body { background: #fff; padding: 0; }
            .receipt-paper { box-shadow: none; border-radius: 0; margin-bottom: 0; padding: 10px; }
            .btn-print { display: none !important; }
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">Print Receipt</button>

    <div class="receipt-paper">
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
            <div class="info-line"><span>Receipt #:</span><span>SALE-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span></div>
            <div class="info-line"><span>Date:</span><span>{{ date('d M Y h:i A', strtotime($sale->created_at)) }}</span></div>
            <div class="info-line"><span>Customer:</span><span>{{ $sale->customer->name ?? 'Walk-in' }}</span></div>
            <div class="info-line"><span>Warehouse:</span><span>{{ $sale->warehouse->name ?? 'Main' }}</span></div>
        </div>

        <table class="table border-top border-bottom" style="margin-top: 8px;">
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
                        <br><small>@ &#8377;{{ number_format($item->net_unit_cost, 2) }}</small>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">&#8377;{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table">
            <tr>
                <td class="text-right fw-bold" style="width: 70%;">Subtotal:</td>
                <td class="text-right">&#8377;{{ number_format($sale->saleItems->sum('subtotal'), 2) }}</td>
            </tr>
            @if($sale->discount > 0)
            <tr>
                <td class="text-right fw-bold">Discount:</td>
                <td class="text-right">-&#8377;{{ number_format($sale->discount, 2) }}</td>
            </tr>
            @endif
            @if($sale->tax_amount > 0)
            <tr>
                <td class="text-right fw-bold">Tax:</td>
                <td class="text-right">&#8377;{{ number_format($sale->tax_amount, 2) }}</td>
            </tr>
            @endif
            <tr style="font-size: 14px;">
                <td class="text-right fw-bold border-top">GRAND TOTAL:</td>
                <td class="text-right fw-bold border-top">&#8377;{{ number_format($sale->grand_total, 2) }}</td>
            </tr>
        </table>

        <table class="table border-top" style="margin-top: 5px;">
            <tr>
                <td class="text-right" style="width: 70%;">Payment Method:</td>
                <td class="text-right">{{ $sale->payment_method ?? 'Cash' }}</td>
            </tr>
            <tr>
                <td class="text-right">Paid Amount:</td>
                <td class="text-right">&#8377;{{ number_format($sale->paid_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right fw-bold">Due Amount:</td>
                <td class="text-right fw-bold">&#8377;{{ number_format($sale->due_amount, 2) }}</td>
            </tr>
        </table>

        <div class="text-center border-top thanks">
            <p>Thank you for your purchase!</p>
            <p>Please visit again.</p>
            <div style="margin-top: 8px;">
                <svg id="barcode"></svg>
            </div>
        </div>
    </div>

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
