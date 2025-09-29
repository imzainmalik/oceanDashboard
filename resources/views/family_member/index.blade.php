@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4">

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Total Documents</h5>
                        <h3>{{ $totalDocuments }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Bills (Paid / Pending)</h5>
                        <h3>{{ $paidBills }} / {{ $pendingBills }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Contributions (This Month)</h5>
                        <h3>${{ number_format($contributionsThisMonth, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>Reimbursements</h5>
                        <h3>{{ $reimbursements }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Bills Status</div>
                    <div class="card-body">
                        <canvas id="billStatusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Contributions Over Time</div>
                    <div class="card-body">
                        <canvas id="contributionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Recent Bills</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBills as $bill)
                                    <tr>
                                        <td>{{ $bill->title }}</td>
                                        <td><span
                                                class="badge bg-{{ $bill->status == 'approved' ? 'success' : ($bill->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($bill->status) }}</span>
                                        </td>
                                        <td>${{ number_format($bill->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Recent Contributions</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Bill</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentContributions as $c)
                                    <tr>
                                        <td>{{ $c->bill?->title ?? 'N/A' }}</td>
                                        <td>${{ number_format($c->amount_paid, 2) }}</td>
                                        <td>{{ $c->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Upcoming Events -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">Upcoming Vacations & Outings</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Start</th>
                                    <th>End</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ ucfirst($event->type) }}</td>
                                        <td>{{ $event->start_date->format('M d, Y') }}</td>
                                        <td>{{ $event->end_date ? $event->end_date->format('M d, Y') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No upcoming events.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bills Pie Chart
        new Chart(document.getElementById('billStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Paid', 'Pending', 'Declined'],
                datasets: [{
                    data: [{{ $billStatus['paid'] }}, {{ $billStatus['pending'] }},
                        {{ $billStatus['declined'] }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            }
        });

        // Contributions Line Chart
        new Chart(document.getElementById('contributionsChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($contributions->toArray())) !!},
                datasets: [{
                    label: 'Contributions',
                    data: {!! json_encode(array_values($contributions->toArray())) !!},
                    fill: true,
                    borderColor: '#007bff',
                    tension: 0.3
                }]
            }
        });
    </script>
@endpush
