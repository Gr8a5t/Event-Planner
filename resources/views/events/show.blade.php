@extends('layouts.app')

@section('title', $event->title . ' - EventFlow')

@php
    $font    = $event->font_family ?? 'Outfit';
    $theme   = $event->theme_color ?? '#ffffff';
    $bg      = '#131b31'; // Deep navy background as seen in mockup
    $fontSlug = urlencode(str_replace(' ', '+', $font));
@endphp

@section('styles')
<link href="https://fonts.googleapis.com/css2?family={{ $fontSlug }}:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    .event-show-body {
        @if($event->background_image)
            background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('{{ $event->background_image }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        @else
            background-color: {{ $bg }};
        @endif
        color: #ffffff;
        font-family: '{{ $font }}', 'Outfit', system-ui, sans-serif;
        min-height: 100vh;
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    .reg-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }
    .reg-card-header {
        background: rgba(255, 255, 255, 0.08);
        padding: 0.75rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgba(255, 255, 255, 0.5);
    }
    .reg-item {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .reg-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .btn-join {
        background: #ffffff;
        color: #000000;
        width: 100%;
        padding: 0.9rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        text-align: center;
        text-decoration: none;
        display: block;
        transition: transform 0.2s;
        border: none;
        cursor: pointer;
    }
    .form-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: white;
        margin-bottom: 1rem;
        font-family: inherit;
    }
    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    .pending-status {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        text-align: center;
    }
    .btn-join:hover {
        transform: scale(1.01);
        opacity: 0.95;
    }
    .social-icon {
        color: rgba(255, 255, 255, 0.6);
        transition: color 0.2s;
    }
    .social-icon:hover {
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="event-show-body">
    <div class="container">
        
        <div style="display: grid; grid-template-columns: 380px 1fr; gap: 3.5rem; align-items: start;">
            
            {{-- ── Left Side: Image & Meta ── --}}
            <div>
                <div style="width: 380px; height: 380px; background: {{ $event->cover_image ? "url('{$event->cover_image}')" : 'linear-gradient(45deg, #4f46e5, #9333ea)' }}; background-size: cover; background-position: center; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); margin-bottom: 2rem;"></div>
                
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffffff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($event->organizer->name) }}&background=fff&color=000" alt="logo" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: rgba(255,255,255,0.5); font-weight: 600;">Presented by</p>
                        <p style="font-weight: 700; font-size: 0.95rem;">{{ $event->organizer->name }} <span style="color: rgba(255,255,255,0.4); margin-left: 0.25rem;">›</span></p>
                    </div>
                    <div style="margin-left: auto;">
                        <button class="btn" style="background: rgba(255,255,255,0.1); color: #fff; padding: 0.4rem 1rem; font-size: 0.8rem; border-radius: 20px;">Subscribe</button>
                    </div>
                </div>

                <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    {{ Str::limit($event->description, 150) }}
                </p>

                <div style="display: flex; gap: 1rem; margin-bottom: 2.5rem;">
                    <a href="#" class="social-icon"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/></svg></a>
                    <a href="#" class="social-icon"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                    <a href="#" class="social-icon"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.023c-.306-.024-.613-.023-.913.003L11.365 0h-.21c-2.482.023-4.148.046-5.83.504-2.128.582-3.652 1.954-4.298 3.856C.641 5.568.542 7.147.51 9.07l-.01.815V14.116l.01.815c.032 1.923.13 3.502.516 5.21.646 1.902 2.17 3.274 4.298 3.856 1.682.458 3.348.481 5.83.504l.21.003c.306.026.613.027.914.003.111-.001.218-.002.327-.003 2.481-.023 4.147-.046 5.829-.504 2.128-.582 3.652-1.954 4.298-3.856.386-1.708.485-3.287.517-5.21l.01-.815V9.885l-.01-.815c-.033-1.923-.131-3.502-.517-5.21-.646-1.902-2.17-3.274-4.298-3.856-1.682-.458-3.348-.481-5.829-.504l-.21-.003c-.109-.001-.216-.002-.327-.003zm-1.841 6.54h3.328c-.015.372-.11 1.488-.11 1.488s-1.127.015-1.503.015v1.545h1.56s-.11.758-.11 1.47h-1.45V15.5l-2.073-.016V11.08h-1.157s.035-.712.035-1.47h1.122V8.31s.037-1.747 1.748-1.747z"/></svg></a>
                    <a href="#" class="social-icon"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    <a href="#" class="social-icon"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.5c0 .276-.224.5-.5.5h-1c-.276 0-.5-.224-.5-.5v-1c0-.276.224-.5.5-.5h1c.276 0 .5.224.5.5v1zm0-3.5c0 .276-.224.5-.5.5h-1c-.276 0-.5-.224-.5-.5v-4c0-.276.224-.5.5-.5h1c.276 0 .5.224.5.5v4zM12 7c-.552 0-1-.448-1-1s.448-1 1-1 1 .448 1 1-.448 1-1 1z"/></svg></a>
                </div>

                <div style="margin-top: 2rem;">
                    <p style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.4); margin-bottom: 1.5rem;">Hosted By</p>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                            {{ strtoupper(substr($event->organizer->name, 0, 1)) }}
                        </div>
                        <p style="font-weight: 600; font-size: 0.95rem;">{{ $event->organizer->name }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Right Side: Details & Registration ── --}}
            <div>
                <h1 style="font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 2rem; letter-spacing: -0.02em;">{{ $event->title }}</h1>
                
                {{-- Date Section --}}
                <div style="display: flex; gap: 1.25rem; align-items: flex-start; margin-bottom: 1.5rem;">
                    <div style="width: 44px; height: 48px; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0;">
                        <span style="font-size: 0.6rem; font-weight: 700; text-transform: uppercase; color: rgba(255,255,255,0.5);">{{ $event->date->format('M') }}</span>
                        <span style="font-size: 1.1rem; font-weight: 800;">{{ $event->date->format('d') }}</span>
                    </div>
                    <div>
                        <p style="font-weight: 700; font-size: 1.05rem;">{{ $event->date->format('l, F d') }}</p>
                        <p style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">{{ $event->time->format('h:i A') }} - {{ $event->time->addHours(4)->format('h:i A') }} CST</p>
                    </div>
                </div>

                {{-- Location Section --}}
                <div style="display: flex; gap: 1.25rem; align-items: flex-start; margin-bottom: 3rem;">
                    <div style="width: 44px; height: 44px; border: 1.5px solid rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p style="font-weight: 700; font-size: 1.05rem;">{{ $event->location }} <span style="margin-left: 0.25rem; color: rgba(255,255,255,0.4); font-size: 0.8rem;">↗</span></p>
                    </div>
                </div>

                {{-- Registration Card --}}
                <div class="reg-card">
                    <div class="reg-card-header">Registration</div>
                    
                    <div class="reg-item">
                        <div class="reg-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p style="font-weight: 700; font-size: 0.95rem;">Limited Spots Remaining</p>
                            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Hurry up and register before the event fills up!</p>
                        </div>
                    </div>

                    <div class="reg-item">
                        <div class="reg-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p style="font-weight: 700; font-size: 0.95rem;">Approval Required</p>
                            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">Your registration is subject to host approval.</p>
                        </div>
                    </div>

                    <div style="padding: 1.25rem; background: rgba(255,255,255,0.02);">
                        @php
                            $userReg = null;
                            if(auth()->check()) {
                                $userReg = $event->registrations()->where('user_id', auth()->id())->first();
                            }
                        @endphp

                        @if($userReg && $userReg->status === 'confirmed')
                            <div style="text-align: center; padding: 1.5rem; border: 2px solid #10b981; border-radius: 12px; background: rgba(16, 185, 129, 0.1);">
                                <p style="font-weight: 800; color: #10b981; font-size: 1.1rem; margin-bottom: 0.5rem;">✓ You're Registered!</p>
                                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">Check your email for your digital ticket.</p>
                            </div>
                        @elseif($userReg && $userReg->status === 'pending')
                            <div class="pending-status">
                                <p>⏳ Registration Pending</p>
                                <p style="font-size: 0.75rem; font-weight: 500; opacity: 0.8; margin-top: 0.25rem;">Waiting for organizer approval</p>
                            </div>
                        @elseif(Auth::check() && $event->organizer_id === Auth::id())
                            <a href="{{ route('events.edit', $event) }}" class="btn-join" style="background: rgba(255,255,255,0.1); color: #fff;">✏️ Edit Event Settings</a>
                        @else
                            <form action="{{ route('events.register', $event) }}" method="POST">
                                @csrf
                                @guest
                                    <input type="text" name="name" class="form-input" placeholder="Your Full Name" required>
                                    <input type="email" name="email" class="form-input" placeholder="Email Address" required>
                                @endguest
                                
                                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.5); margin-bottom: 1.25rem; text-align: center;">
                                    By registering, you agree to receive event updates via email.
                                </p>
                                
                                <button type="submit" class="btn-join">Request to Join Event</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div style="margin-top: 3rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: rgba(255,255,255,0.6);">About Event</h3>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $event->title }}</h2>
                    <div style="line-height: 1.8; color: rgba(255,255,255,0.7); white-space: pre-line;">{{ $event->description }}</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// No scripts needed for this layout overhaul
</script>
@endsection
