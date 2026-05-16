<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Senior Payout System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --c-bg: #e8edf7;
            --c-ink: #10213f;
            --c-line: #d6deea;
            --c-blue: #123b73;
            --c-blue-dark: #082653;
        }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--c-ink);
            background: var(--c-bg);
            font-size: .9rem;
        }

        .login-screen {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(115deg, rgba(232, 237, 247, .82), rgba(7, 38, 83, .72)),
                url('/s.jpg') center / cover no-repeat;
        }

        .login-screen::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(8, 38, 83, .18);
            backdrop-filter: blur(2px);
        }

        .login-card,
        .login-footer {
            position: relative;
            z-index: 1;
        }

        .login-card {
            width: min(730px, 100%);
            min-height: 396px;
            display: grid;
            grid-template-columns: 304px 1fr;
            overflow: hidden;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 24px 60px -32px rgba(3, 20, 48, .72);
        }

        .login-photo {
            background:
                linear-gradient(180deg, rgba(8, 38, 83, .04), rgba(8, 38, 83, .2)),
                url('/hand.png') center / cover no-repeat;
            min-height: 396px;
        }

        .login-panel {
            padding: 2rem 1.85rem 1.8rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.2rem;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #2f6fb8, #082653);
            color: #fff;
            font-size: 1.55rem;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .2);
        }

        .brand-name {
            color: #10213f;
            font-size: 2rem;
            font-weight: 700;
            line-height: .95;
            letter-spacing: 0;
        }

        .brand-sub {
            color: #5a6880;
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .02em;
            margin-top: .2rem;
        }

        .login-panel h1 {
            margin: 0 0 .55rem;
            color: #10213f;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: 0;
        }

        .login-copy {
            color: #0f172a;
            font-size: .96rem;
            margin: 0 0 1rem;
        }

        .login-field {
            position: relative;
            margin-bottom: .5rem;
        }

        .login-field > i {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-blue);
            font-size: 1rem;
            z-index: 2;
        }

        .form-control {
            min-height: 42px;
            border-radius: 7px;
            border: 1px solid var(--c-line);
            font-size: .92rem;
            padding: .56rem 2.65rem .56rem 2.35rem;
            color: #111827;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #8fb4e6;
            box-shadow: 0 0 0 3px rgba(18, 59, 115, .14);
        }

        .password-toggle {
            position: absolute;
            right: .75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            display: grid;
            place-items: center;
            border: 0;
            background: transparent;
            color: #7b8790;
            padding: 0;
            cursor: pointer;
        }

        .login-submit {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--c-blue);
            border-radius: 7px;
            background: var(--c-blue);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            font-weight: 600;
            margin-top: .35rem;
            transition: background .15s ease, border-color .15s ease, transform .08s ease;
        }

        .login-submit:hover {
            background: var(--c-blue-dark);
            border-color: var(--c-blue-dark);
        }

        .login-submit:active {
            transform: translateY(1px);
        }

        .login-divider {
            height: 1px;
            background: #e5eaf2;
            margin: 1rem 0 .9rem;
        }

        .login-admin {
            color: var(--c-blue);
            text-align: center;
            font-size: .88rem;
            margin-bottom: .8rem;
        }

        .login-badges {
            display: flex;
            justify-content: center;
            gap: .8rem;
        }

        .login-badges span {
            width: 22px;
            height: 22px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            color: var(--c-blue-dark);
            background: #eef4fb;
            font-size: .84rem;
        }

        .login-footer {
            color: rgba(16, 33, 63, .82);
            text-align: center;
            font-size: .9rem;
        }

        .login-footer nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: .9rem;
            color: rgba(16, 33, 63, .62);
            font-size: .76rem;
            margin-top: .25rem;
        }

        .form-error {
            color: #b91c1c;
            font-size: .78rem;
            margin-top: .35rem;
        }

        @media (max-width: 720px) {
            .login-screen {
                justify-content: flex-start;
                padding: 1rem;
            }

            .login-card {
                grid-template-columns: 1fr;
                min-height: 0;
            }

            .login-photo {
                min-height: 180px;
            }

            .login-panel {
                padding: 1.4rem;
            }

            .brand-name {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
