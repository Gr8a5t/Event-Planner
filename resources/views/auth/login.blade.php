@extends('layouts.app')

@section('title', 'Login - EventFlow')

@section('content')
<section class="container" style="max-width: 400px; padding: 5rem 0;">
    <div class="card">
        <h2 style="margin-bottom: 2rem; text-align: center;">Welcome Back</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p style="color: var(--accent); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <p style="color: var(--accent); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Sign In</button>
        </form>

        <p style="text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.875rem;">
            Don't have an account? <a href="/register" style="color: var(--primary); font-weight: 600;">Create one</a>
        </p>
    </div>
</section>
@endsection
