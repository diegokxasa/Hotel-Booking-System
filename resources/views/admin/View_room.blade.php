<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        .table img {
            width: 120px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <h2 class="mb-4">Rooms List</h2>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Room Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Wifi</th>
                            <th>Room Type</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $index => $room)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $room->room_title }}</td>
                                <td>{{ Str::limit($room->description, 50) }}</td>
                                <td>${{ $room->price }}</td>
                                <td>{{ ucfirst($room->wifi) }}</td>
                                <td>{{ ucfirst($room->room_type) }}</td>
                                <td>
                                    @if ($room->image)
                                        <img src="{{ asset($room->image) }}" class="img-thumbnail" alt="Room Image">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- الزرار صح --}}
                                    <a href="{{ route('room_update', $room->id) }}"
                                        class="btn btn-warning btn-sm">Update</a>
                                    <a href="{{ route('room_delete', $room->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this room?')">
                                        Delete
                                    </a>
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
