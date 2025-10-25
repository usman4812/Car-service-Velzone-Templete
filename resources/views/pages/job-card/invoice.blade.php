<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Samrat Auto</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px 40px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 0;
        }

        .invoice-header img {
            width: 100%;
            height: auto;
            display: block;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }

        .invoice-footer img {
            width: 100%;
            height: auto;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td, table th {
            padding: 6px;
            vertical-align: top;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .print-btn {
            float: right;
            margin-bottom: 10px;
            background-color: #0ab39c;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
            color: #555;
        }

        .footer hr {
            border: 1px solid #ccc;
        }

        @media print {
            .print-btn {
                display: none;
            }

            @page {
                size: A4;
                margin: 0;
            }

            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }

            .invoice-container {
                border: none;
                box-shadow: none;
                margin: 0;
                padding: 15mm 20mm;
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
            }

            .invoice-header img,
            .invoice-footer img {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <img src="{{ asset('assets/images/invoice-banner-new.png') }}" alt="Invoice Header Banner">
    </div>
    <!-- Title -->
    <div style="margin-top: 20px; text-align:center;">
        <h3>TAX INVOICE / <span style="font-family:'Arial';">فاتورة ضريبية</span></h3>
        <button class="print-btn" onclick="window.print()">Print</button>
    </div>

    <!-- Customer + Invoice Details -->
    <table style="margin-top: 20px;">
        <tr>
            <!-- LEFT SIDE -->
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td><strong>السيد/السيدة<br>Mr./Ms.</strong></td>
                        <td>{{ $jobCard->name ?? 'MOHAMMED ALI' }}</td>
                    </tr>
                    <tr>
                        <td><strong>رقم الجوال<br>Mobile No</strong></td>
                        <td>{{ $jobCard->phone ?? '971503345335' }}</td>
                    </tr>
                    <tr>
                        <td><strong>نموذج السيارة<br>Car Model</strong></td>
                        <td>{{ $jobCard->car_model ?? 'RANG ROVER' }}</td>
                    </tr>
                    <tr>
                        <td><strong>رقم لوحة السيارة<br>Car Plate No</strong></td>
                        <td>{{ $jobCard->car_plat_no ?? 'AD 5-7678' }}</td>
                    </tr>
                </table>
            </td>

            <!-- RIGHT SIDE -->
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td><strong>التاريخ<br>Date</strong></td>
                        <td>{{ \Carbon\Carbon::parse($jobCard->date ?? now())->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>رقم الفاتورة<br>Invoice No</strong></td>
                        <td>{{ $jobCard->job_card_no ?? 'TSC-1160' }}</td>
                    </tr>
                    <tr>
                        <td><strong>الفرع<br>Head Branch</strong></td>
                        <td>Time Square Center, Dubai</td>
                    </tr>
                    <tr>
                        <td><strong>مندوب المبيعات<br>Sales Rep</strong></td>
                        <td>{{ $jobCard->salesPerson->name ?? 'AZIZ AHMED' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <div style="margin-top: 30px;">
        <table border="1" style="border-color:#ccc;">
            <thead style="background:#f3f3f3;">
                <tr class="text-center fw-bold">
                    <th>رقم السلعة<br>SL#</th>
                    <th>رمز المنتج<br>Product Code</th>
                    <th>الوصف<br>Description</th>
                    <th>الضمان<br>Warranty</th>
                    <th>سعر الوحدة<br>Unit Price</th>
                    <th>السعر الإجمالي<br>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobCardItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $item->product->code ?? 'PPF G200' }}</td>
                        <td>{{ $item->product->name ?? 'Window Film' }}</td>
                        <td class="text-center">{{ $item->warranty ?? '1 Year' }}</td>
                        <td class="text-end">{{ number_format($item->price, 2) }}</td>
                        <td class="text-end">{{ number_format($item->qty * $item->price, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No items found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Totals Section -->
    <table style="margin-top: 20px;">
        <tr>
            <td style="width:60%; vertical-align:top;">
                <p><strong>Account Title:</strong> Samrat Auto Accessories Fixing</p>
                <p><strong>Account No:</strong> 94528773494 (WIO BANK PJSC)</p>
                <p><strong>TRN (VAT):</strong> 104207872300003</p>
                <p>Five hundred only / خمسة مائة</p>
                <p><strong>Remarks:</strong> {{ $jobCard->remarks ?? '' }}</p>
            </td>
            <td style="width:40%; vertical-align:top;">
                <table style="width:100%;">
                    <tr>
                        <td class="fw-bold">Subtotal (Amount)</td>
                        <td style="width:50px;">AED</td>
                        <td class="text-end">{{ number_format($jobCard->amount ?? 1300, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Net Amount</td>
                        <td style="width:50px;">AED</td>
                        <td class="text-end">{{ number_format($jobCard->net_amount ?? 500, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Discount Amount</td>
                        <td style="width:50px;">AED</td>
                        <td class="text-end">{{ number_format($jobCard->discount_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Discount %</td>
                        <td style="width:50px;">%</td>
                        <td class="text-end">{{ number_format($jobCard->discount_percent ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding:5px 0;"><hr style="border:none; border-top:1px solid #ccc; margin:0;"></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">VAT (5%)</td>
                        <td style="width:50px;">AED</td>
                        <td class="text-end">{{ number_format($jobCard->vat_amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total Payable</td>
                        <td style="width:50px;">AED</td>
                        <td class="text-end">{{ number_format($jobCard->total_payable ?? 0, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- Footer Image -->
    <div class="invoice-footer">
        <img src="{{ asset('assets/images/invoice-footer.jpg') }}" alt="Invoice Footer">
    </div>
</div>

</body>
</html>
