<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in — Senior Payout System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --c-primary: #1d4ed8;
            --c-primary-dark: #1e3a8a;
            --c-ink: #0f172a;
            --c-muted: #64748b;
            --c-line: #e2e8f0;
        }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--c-ink);
            font-size: .9rem;
            background:
                radial-gradient(900px 500px at 100% 0%, #e8efff 0%, transparent 55%),
                radial-gradient(700px 500px at 0% 100%, #eef2f7 0%, transparent 55%),
                #f5f6f8;
        }

        .login-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 880px;
            background: #ffffff;
            border: 1px solid var(--c-line);
            border-radius: 14px;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(15, 23, 42, .04),
                0 16px 48px -12px rgba(15, 23, 42, .14);
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 768px) {
            .login-card { grid-template-columns: 5fr 7fr; }
        }

        /* Photo / brand panel */
        .login-photo {
            position: relative;
            min-height: 240px;
            background:
                linear-gradient(180deg, rgba(15, 23, 42, .15) 0%, rgba(15, 23, 42, .55) 100%),
                url('sctz.jpg') center / cover no-repeat;
            color: #fff;
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .login-photo { min-height: 100%; padding: 2.25rem 2rem; }
        }

        .photo-top {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .photo-mark {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(8px);
            color: #fff;
            font-weight: 700;
            font-size: .72rem;
            letter-spacing: .04em;
            border: 1px solid rgba(255, 255, 255, .2);
        }

        .photo-mark-text {
            font-size: .8rem;
            font-weight: 600;
            line-height: 1.1;
        }

        .photo-mark-sub {
            font-size: .68rem;
            color: rgba(255, 255, 255, .75);
        }

        .photo-foot h3 {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: -.01em;
            line-height: 1.35;
            margin: 0 0 .4rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .2);
        }

        .photo-foot p {
            color: rgba(255, 255, 255, .82);
            font-size: .78rem;
            margin: 0;
            line-height: 1.55;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .2);
        }

        /* Form panel */
        .login-form {
            padding: 2rem 1.75rem;
        }

        @media (min-width: 768px) {
            .login-form { padding: 2.75rem 2.5rem; }
        }

        .form-eyebrow {
            color: var(--c-muted);
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: .35rem;
        }

        .login-form h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--c-ink);
            letter-spacing: -.015em;
            margin: 0 0 .35rem;
        }

        .login-form .lead {
            color: var(--c-muted);
            font-size: .85rem;
            margin: 0 0 1.5rem;
        }

        .form-label {
            font-size: .76rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: .35rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid var(--c-line);
            font-size: .88rem;
            padding: .6rem .8rem;
            background: #fff;
            color: var(--c-ink);
            transition: border-color .12s ease, box-shadow .12s ease;
        }

        .form-control:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, .12);
        }

        .form-control::placeholder { color: #94a3b8; }

        .input-icon { position: relative; }
        .input-icon i {
            position: absolute;
            left: .8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }
        .input-icon .form-control { padding-left: 2.35rem; }

        .toggle-pw {
            position: absolute;
            right: .35rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 0;
            color: #94a3b8;
            padding: .35rem .55rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }
        .toggle-pw:hover { color: var(--c-ink); background: #f1f5f9; }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .form-check-label { font-size: .8rem; color: #475569; }
        .form-check-input { border-color: #cbd5e1; }
        .form-check-input:checked { background-color: var(--c-primary); border-color: var(--c-primary); }

        .btn-signin {
            width: 100%;
            background: var(--c-primary);
            border: 1px solid var(--c-primary);
            color: #fff;
            font-size: .88rem;
            font-weight: 500;
            padding: .65rem 1rem;
            border-radius: 8px;
            transition: background .12s ease, border-color .12s ease, transform .06s ease;
        }
        .btn-signin:hover { background: var(--c-primary-dark); border-color: var(--c-primary-dark); }
        .btn-signin:active { transform: translateY(1px); }

        .auth-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: .8rem;
            padding: .6rem .75rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: .45rem;
            margin-bottom: 1rem;
        }

        .auth-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            font-size: .8rem;
            padding: .6rem .75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .form-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: var(--c-muted);
            font-size: .72rem;
            margin: 1.5rem 0;
        }
        .form-divider::before, .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-line);
        }

        .form-foot {
            text-align: center;
            color: var(--c-muted);
            font-size: .75rem;
        }
    </style>
</head>
<body>
    <main class="login-page">
        <div class="login-card">
            <aside class="login-photo">
                <div class="photo-top">
                    <div class="photo-mark">SPS</div>
                    <div>
                        <div class="photo-mark-text">Senior Payout System</div>
                        <div class="photo-mark-sub">Local government portal</div>
                    </div>
                </div>
                <div class="photo-foot">
                    <h3>Coordinated payouts for every senior citizen.</h3>
                    <p>Plan cycles, schedule barangay rollouts and track every claim from one workspace.</p>
                </div>
            </aside>

            <section class="login-form">
                <div class="form-eyebrow">Sign in</div>
                <h1>Welcome back</h1>
                <p class="lead">Use your administrator credentials to continue.</p>

                @if ($errors->any())
                    <div class="auth-error">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="auth-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="form-control"
                                placeholder="you@davaocity.gov.ph"
                                autocomplete="email"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button" class="toggle-pw" data-target="password" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row-between">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Keep me signed in</label>
                        </div>
                    </div>

                    <button class="btn-signin" type="submit">Sign in</button>
                </form>

                <div class="form-divider">Senior Payout System</div>

                <div class="form-foot">
                    Need access? Contact your OSCA administrator.
                </div>
            </section>
        </div>
    </main>

    <script>
        document.querySelectorAll('.toggle-pw').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.dataset.target);
                if (!input) return;
                var isPw = input.type === 'password';
                input.type = isPw ? 'text' : 'password';
                btn.querySelector('i').className = isPw ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        });
    </script>
</body>
</html>
