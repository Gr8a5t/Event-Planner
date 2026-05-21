@extends('layouts.app')

@section('title', 'Edit Event - EventFlow')

@section('content')
<section class="container" style="max-width: 860px; padding: 4rem 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <a href="{{ route('events.show', $event) }}" style="color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; font-weight: 600;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Event
        </a>
        <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $event->participants->count() }} registered</span>
    </div>

    <form action="{{ route('events.update', $event) }}" method="POST" id="eventForm">
        @csrf
        @method('PUT')

        {{-- ── Tab Nav ── --}}
        <div style="display: flex; gap: 0; border-bottom: 2px solid var(--border); margin-bottom: 2rem;">
            <button type="button" class="tab-btn active" data-tab="details">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Details
            </button>
            <button type="button" class="tab-btn" data-tab="design">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Design
            </button>
            <button type="button" class="tab-btn" data-tab="registrations">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Registrations
                @if($event->registrations()->where('status', 'pending')->count() > 0)
                    <span style="background: var(--accent); color: white; border-radius: 50%; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.7rem; margin-left: 0.25rem;">
                        {{ $event->registrations()->where('status', 'pending')->count() }}
                    </span>
                @endif
            </button>
        </div>

        {{-- ── Tab: Details ── --}}
        <div id="tab-details" class="tab-panel">
            <div class="card" style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; letter-spacing: -0.025em;">Edit Event</h2>

                <div class="form-group">
                    <label for="title">Event Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required autofocus>
                    @error('title')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $event->description) }}</textarea>
                    @error('description')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="date">Event Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date->format('Y-m-d')) }}" required>
                        @error('date')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="time">Event Time</label>
                        <input type="time" name="time" id="time" class="form-control" value="{{ old('time', $event->time->format('H:i')) }}" required>
                        @error('time')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required>
                        @error('location')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label for="capacity">Total Capacity</label>
                        <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $event->capacity) }}" min="1" required>
                        @error('capacity')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Tab: Design ── --}}
        <div id="tab-design" class="tab-panel" style="display:none;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start;">

                {{-- Controls --}}
                <div class="card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem;">Page Appearance</h3>

                    <div class="form-group">
                        <label for="cover_image">Cover Image URL</label>
                        <input type="url" name="cover_image" id="cover_image" class="form-control" value="{{ old('cover_image', $event->cover_image) }}" placeholder="https://images.unsplash.com/...">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.4rem;">Paste any image URL (Unsplash, etc.)</p>
                        @error('cover_image')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label>Page Background</label>
                        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.5rem; margin-bottom: 1rem;">
                            @php
                                $presets = [
                                    'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=800&q=80', // Event
                                    'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&q=80', // Lights
                                    'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&q=80', // Festival
                                    'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80', // Stage
                                    'https://images.unsplash.com/photo-1472653431158-6364773b2a56?w=800&q=80', // Dinner
                                    'https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?w=800&q=80', // Crowd
                                    'https://images.unsplash.com/photo-1514525253361-bee8718a300c?w=800&q=80', // Concert
                                    'https://images.unsplash.com/photo-1527529482837-4698179dc6be?w=800&q=80', // Celebration
                                    'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&q=80', // Nightlife
                                    'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&q=80', // Talk
                                    'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80', // Business
                                    'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80', // Tech
                                    'https://images.unsplash.com/photo-1531050171651-7efc4a3835d4?w=800&q=80', // Workshop
                                    'https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&q=80', // Music
                                    'https://images.unsplash.com/photo-1506157786151-b8491531f063?w=800&q=80', // Artistic
                                    'https://images.unsplash.com/photo-1459749411177-042180ce673c?w=800&q=80', // Venue
                                    'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=800&q=80', // Energy
                                    'https://images.unsplash.com/photo-1496337589254-7e19d01ced44?w=800&q=80', // Urban
                                    'https://images.unsplash.com/photo-1520242739010-44e95bde329e?w=800&q=80', // Nature
                                    'https://images.unsplash.com/photo-1522158633405-4cd9061c1184?w=800&q=80', // Focus
                                ];
                            @endphp
                            @foreach($presets as $url)
                                <div class="bg-preset {{ $event->background_image === $url ? 'active' : '' }}" style="background-image: url('{{ $url }}');" data-url="{{ $url }}"></div>
                            @endforeach
                        </div>
                        <input type="url" name="background_image" id="background_image" class="form-control" value="{{ old('background_image', $event->background_image) }}" placeholder="Or paste custom background URL...">
                        @error('background_image')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="theme_color">Accent Color</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="color" name="theme_color" id="theme_color" value="{{ old('theme_color', $event->theme_color ?? '#ffffff') }}" style="width:44px; height:44px; border-radius:10px; border:1.5px solid #e5e7eb; cursor:pointer; padding:2px;">
                                <input type="text" id="theme_color_hex" class="form-control" value="{{ old('theme_color', $event->theme_color ?? '#ffffff') }}" style="font-family: monospace;" maxlength="7">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="font_family">Font</label>
                            <select name="font_family" id="font_family" class="form-control">
                                @foreach(['Outfit' => 'Outfit (Default)', 'Inter' => 'Inter — Clean & Modern', 'Playfair Display' => 'Playfair Display — Elegant', 'Space Grotesk' => 'Space Grotesk — Techy', 'Syne' => 'Syne — Bold & Artistic', 'Lato' => 'Lato — Friendly', 'Merriweather' => 'Merriweather — Classic Serif'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('font_family', $event->font_family ?? 'Outfit') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Live Preview --}}
                <div>
                    <p style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-bottom: 0.75rem;">Live Preview</p>
                    <div id="preview-card" style="border-radius: 20px; overflow: hidden; border: 1.5px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
                        <div id="preview-cover" style="height: 140px; background-size: cover; background-position: center; display: flex; align-items: flex-end; padding: 1rem; {{ $event->cover_image ? 'background-image: url('.$event->cover_image.')' : 'background: #e5e7eb' }}">
                            <span id="preview-badge" style="background: {{ $event->theme_color ?? '#000' }}; color:#fff; font-size:0.7rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:99px; text-transform:uppercase;">{{ $event->status }}</span>
                        </div>
                        <div id="preview-body" style="padding: 1.25rem; background: {{ $event->bg_color ?? '#fff' }};">
                            <p id="preview-title" style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.4rem; letter-spacing: -0.02em;">{{ $event->title }}</p>
                            <p style="font-size: 0.8rem; color: #6b7280;">📍 {{ $event->location }}  •  🕐 {{ $event->time->format('h:i A') }}</p>
                            <div id="preview-btn" style="margin-top: 1rem; display: inline-block; background: {{ $event->theme_color ?? '#000' }}; color: #fff; font-size: 0.75rem; font-weight: 700; padding: 0.5rem 1.25rem; border-radius: 99px;">Register Now</div>
                        </div>
                    </div>

                    {{-- Share Link --}}
                    <div style="margin-top: 1.5rem; padding: 1rem; background: #f9fafb; border-radius: 12px; border: 1px solid var(--border);">
                        <p style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Share Link</p>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="text" id="share-url" class="form-control" value="{{ route('events.show', $event) }}" readonly style="font-size: 0.8rem; font-family: monospace; background: #fff;">
                            <button type="button" id="copy-btn" onclick="copyShareLink()" style="flex-shrink:0; padding: 0.65rem 1rem; background:#000; color:#fff; border:none; border-radius:10px; font-size:0.8rem; font-weight:600; cursor:pointer; font-family: var(--font-sans);">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div id="design-actions" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <a href="{{ route('events.show', $event) }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2.5rem;">Save Changes</button>
        </div>
    </form>

    {{-- ── Tab: Registrations ── --}}
    <div id="tab-registrations" class="tab-panel" style="display:none;">
        <div class="card" style="padding: 0;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.02em;">Management</h3>
                <div style="display: flex; gap: 0.5rem;">
                    <span style="font-size: 0.8rem; background: #f3f4f6; padding: 0.2rem 0.6rem; border-radius: 6px;">{{ $event->registrations()->count() }} Total</span>
                </div>
            </div>

            @if($event->registrations->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                        <thead>
                            <tr style="text-align: left; background: #fafafa; border-bottom: 1px solid var(--border);">
                                <th style="padding: 1rem 1.5rem; font-weight: 600;">Attendee</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600;">Date</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600;">Status</th>
                                <th style="padding: 1rem 1.5rem; font-weight: 600;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->registrations()->latest()->get() as $reg)
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 1.25rem 1.5rem;">
                                        <div style="font-weight: 700;">{{ $reg->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $reg->email }}</div>
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem; color: var(--text-muted);">
                                        {{ $reg->created_at->format('M d, Y') }}
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem;">
                                        @if($reg->status === 'confirmed')
                                            <span style="background: #ecfdf5; color: #065f46; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Confirmed</span>
                                        @elseif($reg->status === 'pending')
                                            <span style="background: #fffbeb; color: #92400e; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">Pending</span>
                                        @else
                                            <span style="background: #f3f4f6; color: #374151; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">{{ $reg->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem;">
                                        @if($reg->status === 'pending')
                                            <form action="{{ route('events.approve', [$event, $reg]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn" style="background: #10b981; color: #fff; padding: 0.4rem 0.8rem; font-size: 0.75rem; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Approve</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 4rem 2rem; text-align: center; color: var(--text-muted);">
                    <p>No registration requests yet.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.tab-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    padding: 0.75rem 1.5rem; font-size: 0.875rem; font-weight: 600;
    border: none; background: transparent; cursor: pointer;
    color: var(--text-muted); border-bottom: 2px solid transparent; margin-bottom: -2px;
    transition: all 0.2s; font-family: var(--font-sans);
}
.tab-btn.active { color: #000; border-bottom-color: #000; }
.tab-btn:hover:not(.active) { color: #374151; }
.field-error { color: var(--accent); font-size: 0.75rem; margin-top: 0.25rem; }
.bg-preset {
    height: 40px; border-radius: 8px; background-size: cover; background-position: center;
    cursor: pointer; border: 2px solid transparent; transition: all 0.2s;
}
.bg-preset.active { border-color: #000; transform: scale(1.05); }
.bg-preset:hover { transform: scale(1.05); }
</style>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).style.display = 'block';
            
            // Hide save buttons on Registrations tab
            const actions = document.getElementById('design-actions');
            if (btn.dataset.tab === 'registrations') {
                actions.style.display = 'none';
            } else {
                actions.style.display = 'flex';
            }
        });
    });

    function syncColor(pickerId, hexId) {
        const picker = document.getElementById(pickerId);
        const hex = document.getElementById(hexId);
        picker.addEventListener('input', () => { hex.value = picker.value; updatePreview(); });
        hex.addEventListener('input', () => {
            if (/^#[0-9a-fA-F]{6}$/.test(hex.value)) { picker.value = hex.value; updatePreview(); }
        });
    }
    syncColor('theme_color', 'theme_color_hex');

    document.getElementById('cover_image').addEventListener('input', updatePreview);
    document.getElementById('background_image').addEventListener('input', updatePreview);
    document.getElementById('title').addEventListener('input', updatePreview);
    document.getElementById('font_family').addEventListener('change', updatePreview);

    // Preset selection
    document.querySelectorAll('.bg-preset').forEach(preset => {
        preset.addEventListener('click', () => {
            document.querySelectorAll('.bg-preset').forEach(p => p.classList.remove('active'));
            preset.classList.add('active');
            document.getElementById('background_image').value = preset.dataset.url;
            updatePreview();
        });
    });

    function updatePreview() {
        const cover   = document.getElementById('cover_image').value;
        const bg      = document.getElementById('background_image').value;
        const theme   = document.getElementById('theme_color').value;
        const title   = document.getElementById('title').value || 'Your Event Title';
        const previewCover = document.getElementById('preview-cover');
        const previewBody  = document.getElementById('preview-body');
        const previewBtn   = document.getElementById('preview-btn');
        const previewBadge = document.getElementById('preview-badge');
        const previewTitle = document.getElementById('preview-title');

        if (cover) {
            previewCover.style.backgroundImage = `url(${cover})`;
        } else {
            previewCover.style.backgroundImage = 'none';
            previewCover.style.background = '#e5e7eb';
        }

        // Preview background on card
        if (bg) {
            document.getElementById('preview-card').style.backgroundImage = `linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(${bg})`;
            document.getElementById('preview-card').style.backgroundSize = 'cover';
        } else {
            document.getElementById('preview-card').style.background = '#fff';
        }

        previewBtn.style.background   = theme;
        previewBadge.style.background = theme;
        previewTitle.textContent      = title;
    }

    function copyShareLink() {
        const input = document.getElementById('share-url');
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            const btn = document.getElementById('copy-btn');
            btn.textContent = '✓ Copied!';
            btn.style.background = '#10b981';
            setTimeout(() => { btn.textContent = 'Copy'; btn.style.background = '#000'; }, 2000);
        });
    }
</script>
@endsection
