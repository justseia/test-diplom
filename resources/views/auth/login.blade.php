@extends('layouts.app')
<style>
    .form-control, .btn {
        border-radius: 30px; /* Makes the inputs and button oval */
    }

    .login-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 20%; /* Adjust the width as needed */
        height: 20%;
    }

    .btn-block {
        display: block;
        width: 100px; /* Adjust the width as needed */
        margin: 0 auto; /* Center the button */
    }

    .password-wrapper {
        position: relative;
    }

    #password {
        width: 100%;
        padding-right: 30px; /* Make space for the eye icon */
        font-size: 16px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
    }
</style>

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4 align-items-center">

                            <img src="{{ asset('images/avatar.png') }}" alt="Login Illustration"
                                 class="login-image img-fluid">
                        </div>

                        {{-- Login form --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email field --}}
                            <div class="form-group">
                                <label for="email">Почта</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Password field --}}
                            <div class="form-group">
                                <label for="password">Пароль</label> <br>
                                <div class="password-wrapper">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password">
                                    <span id="togglePassword" class="toggle-password">
                                        🚫️
                                    </span>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Submit button --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Войти') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');

            if (passwordInput && togglePasswordButton) {
                togglePasswordButton.addEventListener('click', function () {
                    // Check if the password is currently visible
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Optionally, change the eye icon or text
                    this.textContent = this.textContent === '👁️' ? '🚫' : '👁️';
                });
            }
        });
    </script>
@endpush

