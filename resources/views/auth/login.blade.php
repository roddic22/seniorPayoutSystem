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
            --c-ink: #0f172a;
            --c-muted: #64748b;
            --c-line: #e2e8f0;
        }

        * { -webkit-font-smoothing: antialiased; }

        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f6f8;
            color: var(--c-ink);
            font-size: .9rem;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 992px) {
            .auth-shell { grid-template-columns: 1.05fr 1fr; }
        }

        /* Left brand column */
        .auth-brand {
            display: none;
            background: #0f172a;
            color: #cbd5e1;
            padding: 3rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .auth-brand { display: flex; flex-direction: column; justify-content: space-between; }
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(800px 400px at 90% -10%, rgba(29, 78, 216, .25), transparent 60%),
                radial-gradient(600px 400px at -10% 110%, rgba(2, 132, 199, .18), transparent 55%);
            pointer-events: none;
        }

        .auth-brand > * { position: relative; }

        .brand-row { display: flex; align-items: center; gap: .75rem; }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--c-primary);
            color: #fff;
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: .04em;
        }

        .brand-name { font-weight: 600; color: #fff; font-size: .95rem; }
        .brand-tag { color: #94a3b8; font-size: .75rem; }

        .auth-pitch h2 {
            color: #ffffff;
            font-size: 1.85rem;
            font-weight: 600;
            letter-spacing: -.02em;
            line-height: 1.25;
            margin: 0 0 .85rem;
        }

        .auth-pitch p {
            color: #94a3b8;
            font-size: .9rem;
            max-width: 38ch;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 1.75rem 0 0;
            display: grid;
            gap: .75rem;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            color: #cbd5e1;
            font-size: .82rem;
        }

        .feature-list i {
            color: #60a5fa;
            margin-top: 2px;
        }

        .auth-foot { color: #64748b; font-size: .72rem; }

        /* Right form column */
        .auth-form-col {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
        }

        .auth-card-mobile-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 992px) { .auth-card-mobile-brand { display: none; } }

        .auth-card-mobile-brand .brand-mark {
            background: var(--c-primary); color: #fff;
        }

        .auth-card h1 {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--c-ink);
            letter-spacing: -.01em;
            margin: 0 0 .35rem;
        }

        .auth-card .lead {
            color: var(--c-muted);
            font-size: .85rem;
            margin: 0 0 1.75rem;
        }

        .form-label {
            font-size: .76rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: .35rem;
        }

        .form-control {
            border-radius: .5rem;
            border: 1px solid var(--c-line);
            font-size: .88rem;
            padding: .6rem .8rem;
            background: #fff;
        }

        .form-control:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, .12);
        }

        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }
        .input-icon .form-control {
            padding-left: 2.25rem;
        }

        .btn-signin {
            width: 100%;
            background: var(--c-primary);
            border: 1px solid var(--c-primary);
            color: #fff;
            font-size: .88rem;
            font-weight: 500;
            padding: .65rem 1rem;
            border-radius: .5rem;
            transition: background .12s ease;
        }
        .btn-signin:hover { background: #1e40af; border-color: #1e40af; }

        .form-check-label { font-size: .8rem; color: #475569; }
        .form-check-input { border-color: #cbd5e1; }
        .form-check-input:checked { background-color: var(--c-primary); border-color: var(--c-primary); }

        .auth-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: .8rem;
            padding: .6rem .75rem;
            border-radius: .5rem;
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
            border-radius: .5rem;
            margin-bottom: 1rem;
        }

        .footnote {
            text-align: center;
            color: var(--c-muted);
            font-size: .72rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <aside class="auth-brand">
            <div class="brand-row">
                <div class="brand-mark">SPS</div>
                <div>
                    <div class="brand-name">Senior Payout System</div>
                    <div class="brand-tag">City of Davao · Local government portal</div>
                </div>
            </div>

            <div class="auth-pitch">
                <h2>Coordinating senior citizen payouts across every barangay.</h2>
                <p>One workspace for cycle planning, schedule rollouts, claim tracking and audit-ready reports.</p>

                <ul class="feature-list">
                    <li><i class="bi bi-shield-check"></i> Authenticated access for OSCA staff and counter operators.</li>
                    <li><i class="bi bi-clipboard-data"></i> Live claim status across cycles and schedules.</li>
                    <li><i class="bi bi-printer"></i> Print-ready summary and disbursement reports.</li>
                </ul>
            </div>

            <div class="auth-foot">&copy; {{ date('Y') }} Senior Payout System. Internal use only.</div>
        </aside>

        <main class="auth-form-col">
            <div class="auth-card">
                <div class="auth-card-mobile-brand">
                    <div class="brand-mark">SPS</div>
                    <div>
                        <div class="brand-name" style="color: var(--c-ink); font-weight: 600;">Senior Payout System</div>
                        <div class="brand-tag" style="color: var(--c-muted);">Local government portal</div>
                    </div>
                </div>

                <h1>Sign in</h1>
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
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Keep me signed in</label>
                        </div>
                    </div>

                    <button class="btn-signin" type="submit">Sign in</button>
                </form>

                <div class="footnote">
                    Need access? Contact your OSCA administrator.
                </div>
            </div>
        </main>
    </div>
</body>
</html>
