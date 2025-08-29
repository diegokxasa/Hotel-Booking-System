<!DOCTYPE html>
<html>

<head>
    <base href="/public">
    @include('admin.css')
    <style>
/* الكارت */
.card-dark {
    background-color: #2f3136; /* نفس لون الكارت بتاع Basic Form */
    border-radius: 8px;
    padding: 25px;
    margin-top: 30px;
}

/* الإنبتات */
.form-control {
    background: #2f3136;   /* نفس لون الكارت */
    color: #f1f1f1;        /* خط فاتح */
    border: 1px solid #3e4147; /* بوردر غامق */
    border-radius: 4px;
    padding: 10px 12px;
}

.form-control:focus {
    background: #2f3136;
    color: #fff;
    border-color: #555;   /* يفتح شوية عند الفوكس */
    box-shadow: none;
}

.form-control::placeholder {
    color: #777; /* Placeholder باهت زي الصورة */
}

/* الليبل */
.form-control-label {
    color: #bbb;
    font-weight: 500;
    margin-bottom: 5px;
}}

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

.form-control,
input[type="text"],
input[type="url"],
input[type="email"],
textarea {
    background: #2f3136 !important;  /* نفس لون الكارت */
    color: #f1f1f1 !important;       /* خط فاتح */
    border: 1px solid #3e4147 !important;
    border-radius: 4px;
    padding: 10px 12px;
}

/* في حالة الكتابة جوه input */
.form-control:focus,
input[type="text"]:focus,
input[type="url"]:focus,
input[type="email"]:focus,
textarea:focus {
    background: #2f3136 !important;
    color: #fff !important;
    border-color: #555 !important;
    box-shadow: none !important;
}

/* Placeholder */
.form-control::placeholder,
input[type="text"]::placeholder,
input[type="url"]::placeholder,
input[type="email"]::placeholder,
textarea::placeholder {
    color: #777 !important;
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
                            <strong class="d-block text-light">Send Message to {{ $message->name }}</strong>
                            <span class="d-block text-muted">Fill out the form below to send an email.</span>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="block-body">
                            <form action="{{ route('send_mail.send', $message->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Name</label>
                                    <input type="text" class="form-control" value="{{ $message->name }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $message->email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Greeting</label>
                                    <input type="text" name="greeting" class="form-control" placeholder="Hello, John!" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Body</label>
                                    <textarea name="body" class="form-control" rows="4" placeholder="Write your main message here..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Action Text</label>
                                    <input type="text" name="action_text" class="form-control" placeholder="Click Here" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Action URL</label>
                                    <input type="url" name="action_url" class="form-control" placeholder="https://example.com" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">End Line</label>
                                    <input type="text" name="end_line" class="form-control" placeholder="Thanks & Regards" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Send Email" class="btn btn-primary">
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
