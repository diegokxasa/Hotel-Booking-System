<!DOCTYPE html>
<html>

<head>
    <base href="/public">
    @include('admin.css')
    <style>
        /* الكارت */
        .card-dark {
            background-color: #2f3136; /* نفس لون الكارت بتاع Create */
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
        }

        /* الإنبتات */
        .form-control,
        .form-select {
            background-color: #232427 !important;
            color: #f1f1f1 !important;
            border: 1px solid #3e4147 !important;
            border-radius: 4px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #2c2e33 !important;
            color: #fff !important;
            border-color: #555 !important;
            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: #888 !important;
        }

        /* الليبل */
        .form-control-label {
            color: #bbb;
            font-weight: 500;
            margin-bottom: 5px;
        }

        /* الزرار */
        .btn-primary {
            background-color: #e74c3c;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="block card-dark">
                        <div class="title text-center">
                            <strong class="d-block text-light">Update Room</strong>
                            <span class="d-block text-muted">Edit the room details below.</span>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="block-body">
                            <form action="{{ route('room_update_confirm', $room->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label class="form-control-label">Room Title</label>
                                    <input type="text" name="room_title" class="form-control"
                                        value="{{ $room->room_title }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Description</label>
                                    <textarea name="description" class="form-control" required>{{ $room->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Price</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ $room->price }}" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Room Type</label>
                                    <select name="room_type" class="form-select" required>
                                        <option value="regular" {{ $room->room_type == 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="premium" {{ $room->room_type == 'premium' ? 'selected' : '' }}>Premium</option>
                                        <option value="deluxe" {{ $room->room_type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Free WiFi</label>
                                    <select name="wifi" class="form-select" required>
                                        <option value="yes" {{ $room->wifi == 'yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="no" {{ $room->wifi == 'no' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Current Image</label><br>
                                    @if ($room->image)
                                        <img src="{{ asset($room->image) }}" width="150" class="mb-2 rounded">
                                    @endif
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Update Room" class="btn btn-primary">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>

</html>
