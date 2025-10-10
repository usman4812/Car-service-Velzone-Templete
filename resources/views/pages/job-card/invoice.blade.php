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
            background: #3a4651;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .invoice-header img {
            height: 80px;
        }

        .invoice-header h3 {
            color: white;
            margin: 5px 0 0;
        }

        .invoice-header p {
            margin: 0;
            color: white;
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

            body {
                margin: 0;
            }

            .invoice-container {
                border: none;
                box-shadow: none;
                margin: 0;
                width: 100%;
                padding: 0 30px;
            }
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <!-- Header -->
   <div class="invoice-header text-center mb-3">
    <img src="{{ asset('assets/images/invoice-banner.png') }}"
         alt="Invoice Header Banner"
         style="width: 100%; height: auto; object-fit: cover;">
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
                        <td>Subtotal / المجموع الفرعي</td>
                        <td class="text-end">{{ number_format($jobCard->amount ?? 1300, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount / الخصم</td>
                        <td class="text-end">{{ number_format($jobCard->discount ?? 800, 2) }}</td>
                    </tr>
                    <tr>
                        <td>VAT / مضافة ({{ $jobCard->vat ?? 5 }}%)</td>
                        <td class="text-end">{{ number_format(($jobCard->vat ?? 5) / 100 * ($jobCard->net_amount ?? 500), 2) }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Net Amount / القيمة الصافية</td>
                        <td class="fw-bold text-end">AED {{ number_format($jobCard->net_amount ?? 500, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>يُطلب من العملاء تحديد موعد مسبق قبل زيارة الفرع لتقديم أي مطالبة بالضمان</strong></p>
        <p style="color:red;"><strong>Note: Customers are advised to schedule an appointment before visiting the branch for any warranty claims.</strong></p>
        <p>Online generated invoice, doesn't require stamp</p>
        <hr>
        <p>email: info@samratauto.com | website: www.samratauto.com | WhatsApp: +971 58 685 1720</p>
    </div>
</div>

</body>
</html>
