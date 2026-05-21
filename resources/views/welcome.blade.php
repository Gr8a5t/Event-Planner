@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="container">
            <h1>Simplify event planning <br>with a <span>smarter platform</span></h1>
            <p>Take control of every aspect of your events with intuitive tools for guest management, task tracking, and real-time updates, making planning easier than ever.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;">
                <a href="{{ route('register') }}" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem 2.5rem;">Start Planning Today</a>
            </div>

            <div class="features-grid">
                <!-- Card 1 -->
                <div class="feature-card card-left">
                    <h3>Seamless Team Collaboration</h3>
                    <p>Coordinate tasks and communicate with your team effortlessly.</p>
                    <img src="{{ asset('images/firstcard.png') }}" alt="Team Collaboration" class="feature-image">
                </div>

                <!-- Card 2 -->
                <div class="feature-card card-center">
                    <h3>All-in-One Event Planning</h3>
                    <p>Multiple planning tools combined into one simple platform.</p>
                    <img src="{{ asset('images/centercard.png') }}" alt="Event Planning" class="feature-image">
                </div>

                <!-- Card 3 -->
                <div class="feature-card card-right">
                    <h3>Secure Payments & Billing</h3>
                    <p>Accept payments and manage billing safely built-in security.</p>
                    <img src="{{ asset('images/lastcard.png') }}" alt="Secure Payments" class="feature-image">
                </div>
            </div>
        </div>
    </section>
   <section id="about" class="section-padding">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">With us, <span>scheduling is easy</span></h2>
                <p class="section-subtitle">Effortless scheduling for individuals, powerful solutions for fast-growing modern companies.</p>
            </div>

            <div class="bento-grid">
                <!-- Card 1: Wide -->
                <div class="bento-card card-wide bg-gradient-blue">
                    <div class="bento-content">
                        <h3>Connect your community</h3>
                        <p>We'll handle the cross-referencing, so you don't have to worry about double bookings.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-white">See pricing</a>
                    </div>
                    <div class="bento-visual">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600" alt="Community">
                    </div>
                </div>

                <!-- Card 2: Tall -->
                <div class="bento-card card-tall bg-gradient-purple">
                    <div class="bento-content">
                        <h3>Notify automatically</h3>
                        <p>EventFlow automatically reminds your clients of upcoming events.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
                    </div>
                    <div class="bento-visual">
                        <img src="https://images.unsplash.com/photo-1557426272-fc759fdf7a8d?auto=format&fit=crop&q=80&w=600" alt="Automation">
                    </div>
                </div>

                <!-- Card 3: Small/Tall -->
                <div class="bento-card card-small-tall bg-gradient-red">
                    <div class="bento-content">
                        <h3>Choose how to meet</h3>
                        <p>It could be a video chat, phone call, or a walk in the park!</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
                    </div>
                </div>

                <!-- Card 4: Wide -->
                <div class="bento-card card-row-wide bg-gradient-blue-alt">
                    <div class="bento-content">
                        <h3>Set your availability</h3>
                        <p>Want to block off weekends? Set up any buffers? We make it easy.</p>
                        <a href="#pricing" class="btn btn-outline">See pricing</a>
                    </div>
                    <div class="bento-visual">
                        <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&q=80&w=600" alt="Scheduling">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="section-padding bg-light">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Scale with your <span>vision</span></h2>
                <p class="section-subtitle">Transparent pricing for every stage of your event planning journey.</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="card-header">
                        <h4>Starter</h4>
                        <div class="price">$0<span>/mo</span></div>
                        <p>Perfect for personal gatherings and small community meetups.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>Up to 50 attendees</li>
                        <li>Basic event pages</li>
                        <li>Email support</li>
                        <li>Manual attendee check-in</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline w-full">Start for Free</a>
                </div>

                <div class="pricing-card featured">
                    <div class="card-tag">Most Popular</div>
                    <div class="card-header">
                        <h4>Professional</h4>
                        <div class="price">$29<span>/mo</span></div>
                        <p>Built for individual organizers and growing small teams.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>Unlimited attendees</li>
                        <li>Advanced analytics</li>
                        <li>Custom event branding</li>
                        <li>Priority support</li>
                        <li>Automated RSVP emails</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-primary w-full">Go Pro Now</a>
                </div>

                <div class="pricing-card">
                    <div class="card-header">
                        <h4>Enterprise</h4>
                        <div class="price">$99<span>/mo</span></div>
                        <p>Dedicated solutions for large-scale corporate event planning.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>Multi-org management</li>
                        <li>API access</li>
                        <li>White-labeling options</li>
                        <li>24/7 Dedicated account manager</li>
                        <li>Custom integration support</li>
                    </ul>
                    <a href="#" class="btn btn-outline w-full">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    
@endsection
