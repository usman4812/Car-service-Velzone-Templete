@extends('layouts.master')
@section('title', 'Job Card View')

@section('content')
    <div class="container-fluid py-4">
        <div class="text-end mb-3">
            <button onclick="window.print()" class="btn btn-success btn-sm">
                <i class="ri-printer-line align-middle me-1"></i> Print Job Card
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Header Image -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/invoice-banner.png') }}" alt="Banner" class="img-fluid w-100"
                        style="max-height:180px;object-fit:cover;">
                </div>

                <!-- Title -->
                <h4 class="text-center fw-bold mb-4" style="letter-spacing: 1px;">Job Card</h4>

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
                        {{ number_format($jobCard->net_amount, 2) }}
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

        @media print {
            .btn {
                display: none !important;
            }

            .card {
                border: none;
                box-shadow: none;
            }

            body {
                background: #fff !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection
