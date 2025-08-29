<!DOCTYPE html>
<html>

<head>
    <base href="/public">
    @include('admin.css')
    <style>
        /* الكارت */
        .card-dark {
            background-color: #2f3136;
            /* نفس لون الكارت بتاع Basic Form */
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
        }

        /* الإنبتات */
        .form-control {
            background-color: #232427 !important;
            /* غامق أكتر عشان يبان */
            color: #f1f1f1 !important;
            /* خط فاتح */
            border: 1px solid #3e4147 !important;
            /* بوردر غامق */
            border-radius: 4px;
            padding: 10px 12px;
        }

        .form-control:focus {
            background-color: #2c2e33 !important;
            color: #fff !important;
            border-color: #555 !important;
            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: #888 !important;
            /* Placeholder باهت */
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
                            <strong class="d-block text-light">Add New Room</strong>
                            <span class="d-block text-muted">Fill out the form to create a new room.</span>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="block-body">
                            <form action="{{ url('upload_room') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Room Title</label>
                                    <input type="text" name="room_title" class="form-control"
                                        placeholder="Enter room title" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Room Type</label>
                                    <input type="text" name="room_type" class="form-control"
                                        placeholder="Single, Double, Suite..." required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Price</label>
                                    <input type="number" name="price" class="form-control" placeholder="Enter price"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Add Room" class="btn btn-primary">
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
