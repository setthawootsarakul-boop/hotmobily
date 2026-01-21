<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Hotmobily</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; }
        .login-card { width: 100%; max-width: 400px; border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); overflow: hidden; }
        .login-header { background: #000; color: #fff; padding: 40px 20px; text-align: center; }
        .login-header img { max-width: 150px; margin-bottom: 15px; filter: brightness(0) invert(1); }
        .btn-dark { border-radius: 10px; padding: 12px; font-weight: 600; background: #000; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #eee; }
        .form-control:focus { box-shadow: none; border-color: #000; }
    </style>
</head>
<body>
    <div class="login-card card">
        <div class="login-header">
            <h5 class="mb-0 text-uppercase" style="letter-spacing: 2px;">Hotmobily | Admin Panel</h5>
        </div>
        <div class="card-body p-4">
            @if($errors->has('login_error'))
                <div class="alert alert-danger border-0 small py-2">{{ $errors->first('login_error') }}</div>
            @endif

            <form action="{{ url('/admin/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="small fw-bold text-muted mb-1">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="ระบุชื่อผู้ใช้งาน" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold text-muted mb-1">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="ระบุรหัสผ่าน" required>
                </div>
                <button type="submit" class="btn btn-dark w-100 mb-3 shadow-sm">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</body>
</html>