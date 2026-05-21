@extends('layouts.app')

@section('title', 'Your Dashboard - EventFlow')

@section('content')
<section class="container" style="padding: 4rem 0;">
    <h1 style="font-size: 2.5rem; margin-bottom: 3rem; letter-spacing: -0.025em;">Welcome back, {{ auth()->user()->name }}</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
        <!-- Left: My Events (Organizing) -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem;">Events You're Organizing</h2>
                <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">+ New</a>
            </div>

            @if($myEvents->isEmpty())
                <div class="card" style="text-align: center; padding: 3rem 0;">
                    <p style="color: var(--text-muted);">You haven't created any events yet.</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($myEvents as $event)
                        @php
                            $bg = $event->background_image;
                            $style = $bg ? "background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{$bg}'); background-size: cover; background-position: center; border: none; color: white;" : "";
                        @endphp
                        <div class="card" style="display: flex; justify-content: space-between; align-items: center; {{ $style }}">
                            <div>
                                <h4 style="margin-bottom: 0.25rem; {{ $bg ? 'color: white;' : '' }}">{{ $event->title }}</h4>
                                <p style="font-size: 0.875rem; color: {{ $bg ? 'rgba(255,255,255,0.7)' : 'var(--text-muted)' }};">{{ $event->date->format('M d, Y') }} • {{ $event->participants_count }} Registered</p>
                            </div>
                            <a href="{{ route('events.edit', $event) }}" class="btn {{ $bg ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; {{ $bg ? 'background: white; color: black; border: none;' : '' }}">Manage</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Attending Events -->
        <div>
            <h2 style="font-size: 1.5rem; margin-bottom: 2rem;">Events You're Attending</h2>

            @if($attendingEvents->isEmpty())
                <div class="card" style="text-align: center; padding: 3rem 0;">
                    <p style="color: var(--text-muted);">You haven't registered for any events.</p>
                    <a href="{{ route('events.index') }}" style="color: var(--primary); font-size: 0.875rem; font-weight: 600; margin-top: 1rem; display: inline-block;">Browse Events</a>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($attendingEvents as $event)
                        @php
                            $bg = $event->background_image;
                            $style = $bg ? "background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{$bg}'); background-size: cover; background-position: center; border: none; color: white;" : "";
                        @endphp
                        <div class="card" style="display: flex; justify-content: space-between; align-items: center; {{ $style }}">
                            <div>
                                <h4 style="margin-bottom: 0.25rem; {{ $bg ? 'color: white;' : '' }}">{{ $event->title }}</h4>
                                <p style="font-size: 0.875rem; color: {{ $bg ? 'rgba(255,255,255,0.7)' : 'var(--text-muted)' }};">By {{ $event->organizer->name }} • {{ $event->date->format('M d, Y') }}</p>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                @if(Auth::user()->registrations()->where('event_id', $event->id)->where('status', 'confirmed')->exists())
                                    <span style="background: #10b981; color: white; font-size: 0.65rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 4px; text-transform: uppercase; align-self: center;">Joined</span>
                                @else
                                    <span style="background: #f59e0b; color: white; font-size: 0.65rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 4px; text-transform: uppercase; align-self: center;">Pending</span>
                                @endif
                                <a href="{{ route('events.show', $event) }}" class="btn {{ $bg ? 'btn-primary' : 'btn-outline' }}" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; {{ $bg ? 'background: white; color: black; border: none;' : '' }}">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
