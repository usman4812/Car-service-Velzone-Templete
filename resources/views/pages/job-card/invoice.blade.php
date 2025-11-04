@extends('layouts.master')
@section('title', 'Job Card Invoice')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Samrat Auto</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #000;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .invoice-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .invoice-container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: calc(100vh - 150px);
        }

        .invoice-content {
            flex: 1;
            padding-bottom: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 0;
        }

        .invoice-header img {
            width: 100%;
            height: auto;
            display: block;
            max-width: 100%;
        }

        .invoice-footer {
            text-align: center;
            margin-top: auto;
            padding-top: 30px;
            padding-bottom: 20px;
            width: 100%;
            display: block;
        }

        .invoice-footer img {
            width: 100%;
            height: auto;
            display: block;
            max-width: 100%;
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

        /* Hide layout footer on invoice page */
        .footer {
            display: none !important;
        }

        /* Hide layout elements on invoice page */
        #layout-wrapper,
        .main-content {
            padding: 0 !important;
            margin: 0 !important;
        }

        .page-content {
            padding: 0 !important;
            margin: 0 !important;
            min-height: auto !important;
            overflow: visible !important;
        }

        /* Ensure invoice is scrollable and visible */
        .invoice-wrapper {
            margin-top: 70px;
            padding-bottom: 20px;
        }

        .invoice-container {
            position: relative;
            z-index: 1;
        }

        @media print {
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .print-btn {
                display: none;
            }

            /* Hide layout footer in print */
            .footer {
                display: none !important;
            }

            /* Hide all layout elements in print */
            nav, aside, .navbar, .sidebar, header:not(.invoice-header),
            footer:not(.invoice-footer), .main-header, .page-header,
            .btn:not(.print-btn), .navbar-header, #page-topbar, .app-menu, .navbar-menu,
            .vertical-menu, .left, .page-title-box, .breadcrumb,
            [class*="sidebar"], [class*="topbar"], [id*="sidebar"], [id*="topbar"],
            #layout-wrapper > .app-menu,
            #layout-wrapper > .vertical-overlay {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                overflow: hidden !important;
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
                overflow: visible;
            }

            body {
                display: block;
            }

            .invoice-wrapper {
                width: 100%;
                margin: 0 !important;
                padding: 0 !important;
                margin-top: 0 !important;
            }

            .invoice-container {
                max-width: 100%;
                width: 100%;
                margin: 0;
                padding: 15mm 20mm 50mm 20mm;
                border: none;
                box-shadow: none;
                page-break-after: avoid;
                display: block;
                position: relative;
                min-height: 100vh;
            }

            .invoice-content {
                margin-bottom: 0;
                padding-bottom: 20px;
            }

            .invoice-header {
                margin-bottom: 15px;
            }

            .invoice-header img,
            .invoice-footer img {
                width: 100%;
                max-width: 100%;
                height: auto;
            }

            .invoice-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                padding: 10mm 20mm;
                margin-top: 0;
                page-break-inside: avoid;
                background: #fff;
                z-index: 1000;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>
<body>

<div class="invoice-wrapper">
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <img src="{{ asset('assets/images/invoice-banner-new.png') }}" alt="Invoice Header Banner">
        </div>

        <!-- Content Section -->
        <div class="invoice-content">
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
                                <td>{{ $jobCard->customer->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>رقم الجوال<br>Mobile No</strong></td>
                                <td>{{ $jobCard->phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>نموذج السيارة<br>Car Model</strong></td>
                                <td>{{ $jobCard->car_model ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>رقم لوحة السيارة<br>Car Plate No</strong></td>
                                <td>{{ $jobCard->car_plat_no ?? '' }}</td>
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
                                <td>{{ $jobCard->job_card_no ?? '' }}</td>
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
                        <p><strong>Account Title:</strong>SAMRAT AUTO ACCESSORIES FITTING LLC
                            DUBAI, UNITED ARAB EMIRATES
                            </p>
                        <p><strong>Account No:</strong>14353261920001</p>
                        <p><strong>TRN (VAT):</strong>104207872300003</p>
                        <p>{{ ucwords(numberToWords($jobCard->total_payable ?? 0)) }} / {{ numberToWordsArabic($jobCard->total_payable ?? 0) }}</p>
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
        </div>

        <!-- Footer Image -->
        <div class="invoice-footer">
            <img src="{{ asset('assets/images/footer.jpg') }}" alt="Invoice Footer">
        </div>
    </div>
</div>


</body>
</html>
@endsection
