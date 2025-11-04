@extends('layouts.master')
@section('title', 'Job Card View')

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
                    <h4 class="fw-bold mb-4" style="letter-spacing: 1px;">Job Card</h4>
                    <div style="position: absolute; right: 0; top: 0;">
                        @can('view-job-card-invoice')
                            <a href="{{ route('job-card.invoice', $jobCard->id) }}" target="_blank" class="btn btn-sm btn-primary me-2" style="background-color: #0ab39c; color: #fff; border: none; padding: 6px 14px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                <i class="ri-file-text-line"></i> View Invoice
                            </a>
                        @endcan
                        <button class="print-btn" onclick="window.print()">Print</button>
                    </div>
                </div>

                <!-- Job Info Lines -->
                <div class="job-lines" style="font-size: 16px; line-height: 2;">
                    <div class="d-flex justify-content-between">
                        <div>
                            Date : <span class="dots">{{ \Carbon\Carbon::parse($jobCard->date)->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            Job Card No : <span class="dots">{{ $jobCard->job_card_no }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            Car Brand : <span class="dots">{{ $jobCard->carManufacture->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            Manufacturing Year : <span class="dots">{{ $jobCard->manu_year ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            Car Plate No : <span class="dots">{{ $jobCard->car_plat_no ?? 'N/A' }}</span>
                        </div>
                        <div>
                            Chassis No : <span class="dots">{{ $jobCard->chassis_no ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div>
                        Type of Film :
                        <span class="dots">
                            @foreach ($jobCard->items as $item)
                                {{ $item->product->name ?? '' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                </div>

                <!-- Car Image -->
                <div class="text-center my-4">
                    <img src="{{ asset('assets/images/car-img.jpg') }}" alt="Car Image" class="img-fluid"
                        style="max-height:250px;">
                </div>

                <!-- Remarks -->
                <div style="line-height:2;">
                    <b><i>Remarks :</i></b>
                    <span class="dots">{{ $jobCard->remarks ?? '' }}</span>
                </div>

                <!-- Total Consumption -->
                <div style="line-height:2;">
                    <b>Total Consumption (M²) :</b>
                    <span class="dots"></span>
                </div>

                <!-- Quality Assessment -->
                <div class="text-center mt-4 mb-4">
                    <h5 class="fw-bold">Quality Assessment by Manager</h5>
                    <p>
                        <b>Bad</b> <span class="px-4 border-bottom">&nbsp;</span>
                        <b>Fair</b> <span class="px-4 border-bottom">&nbsp;</span>
                        <b>Good</b> <span class="px-4 border-bottom">&nbsp;</span>
                        <b>Perfect</b> <span class="px-4 border-bottom">&nbsp;</span>
                    </p>
                </div>

                <!-- Price Section -->
                <div class="text-center mb-4">
                    <b>Price Charged Details :</b>
                    <span class="dots" style="width:300px;">
                        {{ number_format($jobCard->total_payable, 2) }}
                    </span>
                    &nbsp; AED
                </div>

                <!-- Customer Details -->
                <div style="line-height:2;">
                    <div><b>Customer Name :</b> <span class="dots">{{ $jobCard->name ?? '' }}</span></div>
                    <div><b>Mobile No :</b> <span class="dots">{{ $jobCard->phone ?? '' }}</span></div>
                    <div><b>Email :</b> <span class="dots">{{ $jobCard->email ?? '' }}</span></div>
                </div>

                <!-- Signatures -->
                <div class="d-flex justify-content-between mt-5">
                    <div><b>Customer Signature :</b> <span class="dots"></span></div>
                    <div><b>Sales Person :</b> <span class="dots">{{ $jobCard->salesPerson->name ?? '' }}</span></div>
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

        .job-lines div {
            margin-bottom: 10px;
        }

        .print-btn {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #0ab39c;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-btn:hover {
            background-color: #099885;
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

            /* Adjust job info spacing */
            .job-lines {
                margin-top: 15px !important;
            }
        }
    </style>
@endsection
