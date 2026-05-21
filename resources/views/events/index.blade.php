@extends('layouts.app')

@section('title', 'Explore Events - EventFlow')

@section('content')
<section class="container" style="padding: 4rem 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
        <div>
            <h1 style="font-size: 2.5rem; letter-spacing: -0.025em;">Explore Events</h1>
            <p style="color: var(--text-muted);">Discover and join exciting events in your community.</p>
        </div>
        @auth
            <a href="{{ route('events.create') }}" class="btn btn-primary">+ Create New Event</a>
        @endauth
    </div>

    @if($events->isEmpty())
        <div class="card" style="text-align: center; padding: 5rem 0;">
            <p style="color: var(--text-muted); font-size: 1.25rem;">No events found. Why not create one?</p>
            @auth
                <a href="{{ route('events.create') }}" class="btn btn-outline" style="margin-top: 1.5rem;">Host an Event</a>
            @endauth
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
            @foreach($events as $event)
                @php
                    $hasCover = !empty($event->cover_image);
                    $cardStyle = $hasCover 
                        ? "background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{$event->cover_image}'); background-size: cover; background-position: center; color: #ffffff; border: none; transition: transform 0.3s ease;" 
                        : "transition: transform 0.3s ease;";
                    $mutedColor = $hasCover ? "rgba(255,255,255,0.7)" : "var(--text-muted)";
                    $badgeStyle = $hasCover ? "background: rgba(255,255,255,0.2); color: #ffffff; backdrop-filter: blur(4px);" : "background: var(--bg-main); color: var(--primary);";
                    $btnClass = $hasCover ? "btn-primary" : "btn-outline";
                @endphp
                <div class="card" style="{{ $cardStyle }}">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <span style="{{ $badgeStyle }} font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 20px; text-transform: uppercase;">{{ $event->status }}</span>
                        <span style="color: {{ $mutedColor }}; font-size: 0.875rem;">{{ $event->date->format('M d, Y') }}</span>
                    </div>
                    <h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; {{ $hasCover ? 'color: #fff;' : '' }}">{{ $event->title }}</h3>
                    <p style="color: {{ $mutedColor }}; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $event->description }}</p>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; color: {{ $mutedColor }};">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location }}
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.875rem; font-weight: 600;">{{ $event->participants->count() }} / {{ $event->capacity }} Joined</span>
                        <a href="{{ route('events.show', $event) }}" class="btn {{ $btnClass }}" style="{{ $hasCover ? 'background: #fff; color: #000;' : '' }}">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
