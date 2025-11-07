@extends('layouts.master')
@section('title', 'Earnings Details - ' . $date)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="ri-calendar-line me-2"></i>Earnings Details for {{ $date }}
                        </h5>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ri-arrow-left-line me-1"></i> Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-primary bg-soft rounded">
                                                <span class="avatar-title bg-primary rounded-circle">
                                                    <i class="ri-file-list-3-line fs-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0">Total Job Cards</p>
                                            <h4 class="mb-0">{{ number_format($totalJobCards, 0) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-success bg-soft rounded">
                                                <span class="avatar-title bg-success rounded-circle">
                                                    <i class="ri-money-dollar-circle-line fs-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0">Total Earnings</p>
                                            <h4 class="mb-0 text-success">{{ number_format($totalEarnings, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-info bg-soft rounded">
                                                <span class="avatar-title bg-info rounded-circle">
                                                    <i class="ri-discount-percent-line fs-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0">Total Discount</p>
                                            <h4 class="mb-0 text-info">{{ number_format($totalDiscount, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm bg-warning bg-soft rounded">
                                                <span class="avatar-title bg-warning rounded-circle">
                                                    <i class="ri-percent-line fs-20"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-muted mb-0">Total VAT</p>
                                            <h4 class="mb-0 text-warning">{{ number_format($totalVat, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Cards Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>SR No.</th>
                                    <th>Job Card No.</th>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    <th>Car Plate No</th>
                                    <th>Sales Rep</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>VAT</th>
                                    <th>Total Payable</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobCards as $index => $jobCard)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $jobCard->job_card_no ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            {{ $jobCard->customer->name ?? 'N/A' }}
                                        </td>
                                        <td>{{ $jobCard->phone ?? 'N/A' }}</td>
                                        <td>{{ $jobCard->car_plat_no ?? 'N/A' }}</td>
                                        <td>{{ $jobCard->salesPerson->name ?? 'N/A' }}</td>
                                        <td class="text-end">{{ number_format($jobCard->amount ?? 0, 2) }}</td>
                                        <td class="text-end text-info">{{ number_format($jobCard->discount_amount ?? 0, 2) }}</td>
                                        <td class="text-end text-warning">{{ number_format($jobCard->vat_amount ?? 0, 2) }}</td>
                                        <td class="text-end">
                                            <strong class="text-success">{{ number_format($jobCard->net_amount ?? 0, 2) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('job-card.show', $jobCard->id) }}" target="_blank" class="dropdown-item">
                                                            <i class="ri-eye-line align-bottom me-2 text-muted"></i> View Job Card
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('job-card.invoice', $jobCard->id) }}" target="_blank" class="dropdown-item">
                                                            <i class="ri-file-text-line align-bottom me-2 text-muted"></i> View Invoice
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-inbox-line fs-48 mb-3 d-block"></i>
                                                No job cards found for this date.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end">Total:</th>
                                    <th class="text-end">{{ number_format($totalAmount, 2) }}</th>
                                    <th class="text-end text-info">{{ number_format($totalDiscount, 2) }}</th>
                                    <th class="text-end text-warning">{{ number_format($totalVat, 2) }}</th>
                                    <th class="text-end">
                                        <strong class="text-success">{{ number_format($totalEarnings, 2) }}</strong>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

