<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        /* زي ما هو، فقط لتصغير الصور لو موجودة */
        .table img {
            width: 120px;
            height: auto;
            border-radius: 5px;
        }

        .alert {
            margin-top: 15px;
        }

        .btn-sm {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid">
            <h2 class="mb-4">All Messages</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $index => $message)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->phone }}</td>
                                <td>{{ Str::limit($message->message, 50) }}</td>
                                <td>
                                    <form action="{{ route('message_delete', $message->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>

                                    <a href="{{ route('send_mail.form', $message->id) }}"
                                        class="btn btn-primary btn-sm">Send Email</a>
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
