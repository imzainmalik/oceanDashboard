@extends('layouts.app')

@section('content')
    {{-- <div class="container">
        <h3>📅 My Daily Updates</h3> 
        @if ($updates->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($updates as $update) 
                        <tr>
                            <td>{{ $update['title'] }}</td>
                            <td>{{ $update['description'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($update['date'])->format('d M, Y h:i A') }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $update['status'] == 'completed' ? 'success' : ($update['status'] == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($update['status']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        @else
            <p class="text-muted">No daily updates yet.</p>
        @endif
    </div> --}}

    <div class="content-card">
        <div class="container-fluid p-0">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="content">
                            <h3>Daily activity timeline</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="primary-card ">
                        <div id="month-buttons"></div>
                        <div id='calendar'></div>

                        <div id="noteModal">
                            <div class="modal-content">
                                <h3>Add Note</h3>
                                <input type="text" id="noteText" placeholder="Enter note" />
                                <h5>Choose Color</h5>
                                <input type="color" id="noteColor" value="#3788d8" />
                                <br />
                                <button onclick="saveNote()">Add Note</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('js')
    @php
        $colors = colors();
    @endphp
    <!-- FullCalendar   -->
    <script>
        let calendar;
        let selectedInfo = null;

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    @foreach ($updates as $update)
                        @php
                            $randomColor = $colors[array_rand($colors)];
                        @endphp {
                            title: '{{ $update['title'] }}',
                            start: '{{ $update['created_at']->format('Y-m-d') }}',
                            end: '{{ $update['created_at']->format('Y-m-d') }}',
                            allDay: true,
                            backgroundColor: '{{ $randomColor }}',
                            borderColor: '{{ $randomColor }}'
                        },
                    @endforeach
                ],
                selectable: true,
                select: function(info) {
                    selectedInfo = info;
                    document.getElementById('noteText').value = '';
                    document.getElementById('noteColor').value = '#3788d8';
                    document.getElementById('noteModal').style.display = 'block';
                }
            });

            calendar.render();

            // Month Buttons
            const monthNames = [
                "January", "February", "March", "April",
                "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];


            const monthButtonsContainer = document.getElementById('month-buttons');
            const currentYear = new Date().getFullYear();

            monthNames.forEach((month, index) => {
                const btn = document.createElement('div');
                btn.className = 'month-btn';
                btn.textContent = month;
                btn.addEventListener('click', () => {
                    const newDate = new Date(currentYear, index, 1);
                    calendar.gotoDate(newDate);
                });
                monthButtonsContainer.appendChild(btn);
            });
        });

        function saveNote() {
            const note = document.getElementById('noteText').value.trim();
            const color = document.getElementById('noteColor').value;

            if (note && selectedInfo) {
                calendar.addEvent({
                    title: note,
                    start: selectedInfo.startStr,
                    end: selectedInfo.endStr,
                    allDay: true,
                    backgroundColor: color,
                    borderColor: color
                });
            }

            // calendar.addEvent({
            //         title: 'test event',
            //         start: selectedInfo.startStr,
            //         end: selectedInfo.endStr,
            //         allDay: true,
            //         backgroundColor: color,
            //         borderColor: color
            //     });

            document.getElementById('noteModal').style.display = 'none';
        }

        // Close modal on background click
        window.onclick = function(event) {
            const modal = document.getElementById('noteModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>
@endpush
