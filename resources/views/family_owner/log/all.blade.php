@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Timeline container */
        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        /* Vertical line */
        .timeline::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 2rem;
            width: 3px;
            background: #e9ecef;
            border-radius: 2px;
        }

        /* Each timeline item */
        .timeline-item {
            position: relative;
            margin-left: 4rem;
            margin-bottom: 1.75rem;
            padding-left: 1rem;
        }

        /* Circle icon on the line */
        .timeline-badge {
            position: absolute;
            left: -1.1rem;
            top: 0.25rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.9rem;
            box-shadow: 0 0 0 6px rgba(0, 0, 0, 0.03);
        }

        /* Card slight lift */
        .timeline-card {
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .timeline-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        /* Time label */
        .timeline-time {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Responsive adjustment */
        @media (max-width: 576px) {
            .timeline::before {
                left: 1.25rem;
            }

            .timeline-item {
                margin-left: 3rem;
            }

            .timeline-badge {
                left: -0.9rem;
                width: 1.75rem;
                height: 1.75rem;
                font-size: 0.82rem;
            }
        }
    </style>

    <div class="container py-4">
        <h3 class="mb-4">Activity Timeline</h3>

        <div class="timeline">

            @php
                $colors = colors();
            @endphp
            <!-- ITEM 1 -->
            <div class="timeline-item">

                @if ($logs->count() > 0)
                    @foreach ($logs as $log)
                        @php
                            $randomColor = $colors[array_rand($colors)];
                        @endphp
                        <!-- ITEM 1 -->
                        <div class="timeline-item">
                            <div class="timeline-badge" style="background-color: {{ $randomColor }}">
                                <i class="bi bi-check-lg" style="font-size:1rem"></i>
                            </div>

                            <div class="card timeline-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $log->action_name }}</h6>
                                            <p class="mb-1 text-muted small"><strong>{{ $log->name }}</strong>
                                            </p>
                                            <p class="mb-2">{{ $log->action_desc }}</p>
                                            {{-- <div>
                                                <span class="badge bg-light text-dark me-1"><i class="bi bi-clock"></i>
                                                    Routine</span>
                                                <span class="badge bg-light text-dark"><i class="bi bi-activity"></i> Vitals
                                                    logged</span>
                                            </div> --}}
                                        </div>
                                        <div class="text-end">
                                            <div class="timeline-time">{{ $log->created_at->diffForHumans() }} </div>
                                        </div>
                                    </div>

                                    {{-- <div class="mt-3 d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Add Note</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5>All activities will appear here!</h4>
                @endif

                {{ $logs->links() }}
            </div>

        </div> <!-- /.timeline -->
    </div> <!-- /.container -->

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Icons (for the icon classes used above) -->
    @endpush
@endsection
