<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    Task Summary -
    {{ \Carbon\Carbon::parse(request('start_date'))->format('F d, Y') }}
    to
    {{ \Carbon\Carbon::parse(request('end_date'))->format('F d, Y') }}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Total Tasks</th>
                <th>Completed</th>
                <th>Pending</th>
                <th>Cancelled</th>
            </tr>
        </thead>
        <tbody>
            @if ($report->count() > 0 && $report != null)
                @foreach ($report as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->total_tasks }}</td>
                        <td style="color: green;">{{ $member->completed_tasks }}</td>
                        <td style="color: orange;">{{ $member->pending_tasks }}</td>
                        <td style="color: red;">{{ $member->cancelled_tasks }}</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td>No tasks found.</td>
            </tr>

            @endif
        </tbody>
    </table>
</body>

</html>
