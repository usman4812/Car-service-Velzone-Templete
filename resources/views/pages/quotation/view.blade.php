@extends('layouts.master')
@section('title', 'Quotation View')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Header Image -->
                <div class="text-center">
                    <img src="{{ asset('assets/images/invoice-banner-new.png') }}" alt="Banner" class="img-fluid w-100"
                        style="max-height:180px;object-fit:cover;">
                </div>

                <!-- Title with Print Button -->
                <div style="margin-top: 20px; text-align:center; position:relative;">
                    <h4 class="fw-bold mb-4" style="letter-spacing: 1px;">QUOTATION</h4>
                    <button class="print-btn" onclick="window.print()">Print</button>
                </div>

                <!-- Quotation Info -->
                <div class="quotation-info" style="font-size: 16px; line-height: 2; margin-bottom: 30px;">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <strong>Quotation No :</strong> <span class="dots">{{ $quotation->quotation_no }}</span>
                        </div>
                        <div>
                            <strong>Date :</strong> <span class="dots">{{ \Carbon\Carbon::parse($quotation->date)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Section -->
                <div class="customer-section mb-4" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
                    <h5 class="fw-bold mb-3" style="color: #0ab39c; border-bottom: 2px solid #0ab39c; padding-bottom: 10px;">Customer Details</h5>
                    <div style="line-height: 2.5;">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Customer Name :</strong> <span style="margin-left: 10px;">{{ $quotation->customer_name ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Phone :</strong> <span style="margin-left: 10px;">{{ $quotation->customer_phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Email :</strong> <span style="margin-left: 10px;">{{ $quotation->customer_email ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Car Model :</strong> <span style="margin-left: 10px;">{{ $quotation->car_model ?? 'N/A' }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Car Plate No :</strong> <span style="margin-left: 10px;">{{ $quotation->car_plat_no ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>Chassis No :</strong> <span style="margin-left: 10px;">{{ $quotation->chassis_no ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="items-section mb-4">
                    <h5 class="fw-bold mb-3" style="color: #0ab39c; border-bottom: 2px solid #0ab39c; padding-bottom: 10px;">Items Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size: 14px;">
                            <thead style="background-color: #0ab39c; color: white;">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 40%;">Description</th>
                                    <th style="width: 10%;" class="text-center">Qty</th>
                                    <th style="width: 15%;" class="text-end">Unit Price</th>
                                    <th style="width: 15%;" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotation->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($item->product)
                                                <strong>{{ $item->product->name ?? 'N/A' }}</strong>
                                                @if($item->category)
                                                    <br><small class="text-muted">Category: {{ $item->category->name }}</small>
                                                @endif
                                                @if($item->subCategory)
                                                    <br><small class="text-muted">Sub Category: {{ $item->subCategory->name }}</small>
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->qty ?? 0 }}</td>
                                        <td class="text-end">{{ number_format($item->price ?? 0, 2) }} AED</td>
                                        <td class="text-end"><strong>{{ number_format($item->total ?? 0, 2) }} AED</strong></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No items found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pricing Summary -->
                <div class="pricing-section">
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <table class="table table-borderless" style="font-size: 15px;">
                                <tbody>
                                    <tr>
                                        <td class="text-end"><strong>Subtotal (Amount) :</strong></td>
                                        <td class="text-end" style="width: 150px;">
                                            <strong>{{ number_format($quotation->amount ?? 0, 2) }} AED</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Net Amount :</strong></td>
                                        <td class="text-end">
                                            <strong>{{ number_format($quotation->net_amount ?? 0, 2) }} AED</strong>
                                        </td>
                                    </tr>
                                    @if(($quotation->discount_amount ?? 0) > 0)
                                    <tr>
                                        <td class="text-end text-danger">Discount ({{ number_format($quotation->discount_percent ?? 0, 2) }}%) :</td>
                                        <td class="text-end text-danger">
                                            <strong>- {{ number_format($quotation->discount_amount ?? 0, 2) }} AED</strong>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-end"><strong>VAT (5%) :</strong></td>
                                        <td class="text-end">
                                            <strong>{{ number_format($quotation->vat_amount ?? 0, 2) }} AED</strong>
                                        </td>
                                    </tr>
                                    <tr style="border-top: 2px solid #0ab39c; border-bottom: 2px solid #0ab39c;">
                                        <td class="text-end"><strong style="font-size: 18px; color: #0ab39c;">Total Payable :</strong></td>
                                        <td class="text-end">
                                            <strong style="font-size: 18px; color: #0ab39c;">{{ number_format($quotation->total_payable ?? 0, 2) }} AED</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer Notes -->
                <div class="mt-5 pt-4" style="border-top: 1px solid #ddd;">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-2"><strong>Note:</strong></p>
                            <ul style="font-size: 13px; line-height: 1.8;">
                                <li>This quotation is valid for 30 days from the date of issue.</li>
                                <li>All prices are in AED and include VAT where applicable.</li>
                                <li>Payment terms and conditions apply as per company policy.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Signatures -->
                <div class="d-flex justify-content-between mt-5 pt-4" style="border-top: 1px solid #ddd;">
                    <div>
                        <strong>Customer Signature :</strong>
                        <div style="height: 60px; border-bottom: 1px solid #000; width: 200px; margin-top: 20px;"></div>
                    </div>
                    <div>
                        <strong>Authorized Signature :</strong>
                        <div style="height: 60px; border-bottom: 1px solid #000; width: 200px; margin-top: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dots {
            display: inline-block;
            border-bottom: 1px dotted #000;
            width: 240px;
            height: 20px;
            line-height: 20px;
            vertical-align: middle;
            text-align: left;
            padding-left: 10px;
        }

        .quotation-info div {
            margin-bottom: 10px;
        }

        .print-btn {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #0ab39c;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .print-btn:hover {
            background-color: #099885;
        }

        .table th {
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            html, body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: auto !important;
                background: #fff !important;
            }

            /* Hide all non-printable elements */
            .btn,
            .print-btn,
            .navbar-header,
            #page-topbar,
            .app-menu,
            .navbar-menu,
            .vertical-menu,
            .left,
            footer,
            .footer,
            .page-title-box,
            .breadcrumb,
            header,
            nav,
            [class*="sidebar"],
            [class*="topbar"],
            [id*="sidebar"],
            [id*="topbar"] {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                overflow: hidden !important;
            }

            /* Force main content to be full width */
            #layout-wrapper,
            .main-content,
            .page-content {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Reset container to full width */
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Reset card to full width with proper padding */
            .card {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            /* Card body with proper padding */
            .card-body {
                padding: 10mm 15mm !important;
                margin: 0 !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            /* First element - remove top margin */
            .card-body > *:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            /* Remove margin from header image container */
            .text-center:first-child {
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Ensure images are full width */
            .text-center img,
            img {
                max-width: 100% !important;
                width: 100% !important;
                display: block !important;
                margin: 0 !important;
            }

            /* Remove extra spacing from title */
            h4 {
                margin-top: 10px !important;
                margin-bottom: 20px !important;
            }

            /* Adjust quotation info spacing */
            .quotation-info {
                margin-top: 15px !important;
            }

            /* Print-friendly table */
            .table {
                page-break-inside: avoid;
            }

            .table thead {
                display: table-header-group;
            }

            .table tbody {
                display: table-row-group;
            }

            .customer-section {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }

            .table thead tr {
                background-color: #0ab39c !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection

