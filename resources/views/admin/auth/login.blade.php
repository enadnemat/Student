<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>Admin Login</title>
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Jacascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>
<body class="bg-primary">
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-3 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-3">{{__('Admin Login')}}</p>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{route('admin.login')}}" method="post">
                                @csrf
                                <div class="form-outline form-white mb-3">
                                    <input type="email" name="email" placeholder="Email Address" required
                                           class="form-control form-control-lg"/>
                                </div>

                                <div class="form-outline form-white mb-3">
                                    <input type="password" name="password" placeholder="Password" required
                                           class="form-control form-control-lg"/>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5"
                                        type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
