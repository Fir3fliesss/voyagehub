<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - VoyageHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: #ffffff;
            --foreground: #475569;
            --card: #f1f5f9;
            --card-foreground: #475569;
            --primary: #059669;
            --primary-foreground: #ffffff;
            --secondary: #10b981;
            --secondary-foreground: #ffffff;
            --muted: #f1f5f9;
            --muted-foreground: #4b5563;
            --accent: #10b981;
            --border: #e2e8f0;
            --input: #f1f5f9;
            --radius: 0.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, var(--muted) 0%, var(--background) 100%);
            color: var(--foreground);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container {
            background-color: var(--background);
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 2rem;
            text-decoration: none;
            display: block;
        }

        .auth-form h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 2rem;
            color: var(--foreground);
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--foreground);
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            background-color: var(--input);
            color: var(--foreground);
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .form-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .form-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin: 0 0.5rem;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .divider {
            margin: 1.5rem 0;
            text-align: center;
            color: var(--muted-foreground);
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
        }

        .back-link a {
            color: var(--muted-foreground);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link a:hover {
            color: var(--primary);
        }

        .terms {
            font-size: 0.85rem;
            color: var(--muted-foreground);
            text-align: center;
            margin-top: 1rem;
        }

        .terms a {
            color: var(--primary);
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 0.5rem;
            display: block;
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .auth-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <a href="index.html" class="logo">VoyageHub</a>
        <div class="auth-form">
            <h1>Create Account</h1>
            <form method="POST" action="/signup">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your full name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" placeholder="Enter your NIK" value="{{ old('nik') }}" required>
                    @error('nik')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn">Sign Up</button>
                <div class="divider">
                    <span>Already have an account?</span>
                </div>
                <div class="form-links">
                    <a href="/signin">Sign In</a>
                </div>
            </form>
        </div>
        <div class="back-link">
            <a href="/">← Back to Home</a>
        </div>
    </div>
</body>
</html>
