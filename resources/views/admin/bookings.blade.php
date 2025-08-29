<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        /* Compact Table Style */
        .table-compact {
            font-size: 14px; /* خط أصغر */
            border-collapse: collapse;
        }

        .table-compact th,
        .table-compact td {
            padding: 6px 10px; /* مسافة أصغر */
            vertical-align: middle;
        }

        .table-compact img {
            width: 80px; /* صورة أصغر */
            height: auto;
            border-radius: 5px;
        }

        /* تحسين الأزرار */
        .action-btns form {
            display: inline-block;
            margin: 2px;
        }

        .action-btns button {
            border-radius: 5px;
            padding: 3px 8px;
            font-size: 12px;
            transition: all 0.2s;
        }

        .action-btns button:hover {
            transform: scale(1.05);
        }

        .btn-approve { background-color: #1abc9c; color: #fff; border: none; }
        .btn-approve:hover { background-color: #16a085; }

        .btn-reject { background-color: #e74c3c; color: #fff; border: none; }
        .btn-reject:hover { background-color: #c0392b; }

        .btn-delete { background-color: #34495e; color: #fff; border: none; }
        .btn-delete:hover { background-color: #2c3e50; }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <h2 class="mb-4">Bookings List</h2>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table class="table table-bordered table-striped table-compact align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Room ID</th>
                            <th>Room</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Room Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->room_id }}</td>
                            <td>{{ $booking->room->room_type ?? 'Deleted Room' }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->start_date }}</td>
                            <td>{{ $booking->end_date }}</td>
                            <td>${{ $booking->room->price ?? 'N/A' }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($booking->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($booking->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->room && $booking->room->image)
                                    <img src="{{ asset($booking->room->image) }}" alt="{{ $booking->room->room_title }}">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="action-btns">
                                @if($booking->status == 'pending')
                                    <form action="{{ route('booking_approve', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-approve">Approve</button>
                                    </form>
                                    <form action="{{ route('booking_reject', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-reject">Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('booking_delete', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>
