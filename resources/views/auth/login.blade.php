@extends('layouts.guest')
@section('content')
<main class="login-screen">
    <section class="login-card">
        <div class="login-photo" aria-hidden="true"></div>

        <div class="login-panel">
            <div class="brand-row">
                <div class="brand-mark">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="brand-name">SPS</div>
                    <div class="brand-sub">Senior Payout System</div>
                </div>
            </div>

            <h1>Welcome Back!</h1>
            <p class="login-copy">Please sign in using your provided account.</p>

            @if(session('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                @csrf

                <div class="login-field">
                    <i class="bi bi-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="Email address"
                        autocomplete="off"
                        required
                        autofocus
                    >
                </div>

                <div class="login-field">
                    <i class="bi bi-lock"></i>
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        autocomplete="new-password"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePw()" tabindex="-1" aria-label="Show password">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>

                <button type="submit" class="login-submit">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sign in
                </button>
            </form>

            <div class="login-divider"></div>

            <div class="login-admin"></div>

            <div class="login-badges" aria-hidden="true">
                <span><i class="bi bi-bank"></i></span>
                <span><i class="bi bi-person-badge"></i></span>
                <span><i class="bi bi-patch-check"></i></span>
            </div>
        </div>
    </section>

    <footer class="login-footer">
        <div>Senior Payout System</div>
        <nav>
            <span>OSCA Support</span>
            <span>Payout Tracking</span>
            <span>Claims Portal</span>
        </nav>
    </footer>
</main>

<script>
function togglePw() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('pwIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection
