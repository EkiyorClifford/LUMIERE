@extends('layouts.app')

@section('content')
<div class="lespace-container">
    <!-- Header -->
    <div class="lespace-header">
        <div class="header-content">
            <h1 class="lespace-title">L'Espace</h1>
            <p class="lespace-subtitle">Your personal sanctuary at LUMIÈRE</p>
        </div>
        <div class="user-greeting">
            <p class="greeting-text">Welcome back, {{ $user->name }}</p>
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-info">
                <p class="stat-number">{{ $recentOrders->count() }}</p>
                <p class="stat-label">Orders</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-gem"></i>
            </div>
            <div class="stat-info">
                <p class="stat-number">{{ $treasures->count() }}</p>
                <p class="stat-label">Treasures</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-pen-ruler"></i>
            </div>
            <div class="stat-info">
                <p class="stat-number">{{ $bespokeProjects->count() }}</p>
                <p class="stat-label">Bespoke Projects</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <p class="stat-number">{{ $upcomingAppointments->count() }}</p>
                <p class="stat-label">Upcoming Appointments</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Recent Orders -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Recent Orders</h2>
                    <a href="{{ route('profile.orders') }}" class="btn-view-all">View All</a>
                </div>
                @if($recentOrders->count() > 0)
                    <div class="orders-list">
                        @foreach($recentOrders as $order)
                            <div class="order-item">
                                <div class="order-info">
                                    <p class="order-number">{{ $order->order_number }}</p>
                                    <p class="order-date">{{ $order->created_at->format('F j, Y') }}</p>
                                </div>
                                <div class="order-status">
                                    <span class="status-badge status-{{ $order->order_status }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                                <div class="order-total">
                                    €{{ number_format($order->total, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-regular fa-box-open"></i>
                        <p>No orders yet</p>
                        <a href="{{ route('shop') }}" class="btn-shop">Start Shopping</a>
                    </div>
                @endif
            </div>

            <!-- Bespoke Projects -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Bespoke Projects</h2>
                    <a href="{{ route('bespoke') }}" class="btn-view-all">Start New</a>
                </div>
                @if($bespokeProjects->count() > 0)
                    <div class="projects-list">
                        @foreach($bespokeProjects as $project)
                            <div class="project-item">
                                <div class="project-info">
                                    <h3 class="project-title">{{ $project->project_title }}</h3>
                                    <p class="project-step">Current Step: {{ ucfirst($project->current_step) }}</p>
                                    @if($project->consultant)
                                        <p class="project-consultant">Consultant: {{ $project->consultant->name }}</p>
                                    @endif
                                </div>
                                <div class="project-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ 
                                            match($project->current_step) {
                                                'consultation' => 10,
                                                'design' => 30,
                                                'creation' => 60,
                                                'finalization' => 90,
                                                'completed' => 100,
                                                default => 0
                                            }
                                        }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-pen-ruler"></i>
                        <p>No bespoke projects yet</p>
                        <a href="{{ route('bespoke') }}" class="btn-shop">Create Your Piece</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Treasures -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Your Treasures</h2>
                </div>
                @if($treasures->count() > 0)
                    <div class="treasures-grid">
                        @foreach($treasures as $treasure)
                            <div class="treasure-item">
                                @if($treasure->product && $treasure->product->images->first())
                                    <img src="{{ $treasure->product->images->first()->image_url }}" 
                                         alt="{{ $treasure->product->name }}" 
                                         class="treasure-image">
                                @else
                                    <div class="treasure-image placeholder">
                                        <i class="fa-regular fa-gem"></i>
                                    </div>
                                @endif
                                <div class="treasure-info">
                                    <h4 class="treasure-name">{{ $treasure->product->name ?? 'Unknown' }}</h4>
                                    <p class="treasure-serial">Serial: {{ $treasure->serial_number }}</p>
                                    <p class="treasure-date">{{ $treasure->purchased_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-regular fa-gem"></i>
                        <p>No treasures yet</p>
                        <p class="empty-hint">Your purchased pieces will appear here</p>
                    </div>
                @endif
            </div>

            <!-- Appointments -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Appointments</h2>
                    <button onclick="openAppointmentModal()" class="btn-book">Book Appointment</button>
                </div>
                
                @if($upcomingAppointments->count() > 0)
                    <div class="appointments-section">
                        <h3 class="appointments-subtitle">Upcoming</h3>
                        @foreach($upcomingAppointments as $appointment)
                            <div class="appointment-item upcoming">
                                <div class="appointment-date">
                                    <p class="date-day">{{ $appointment->scheduled_at->format('d') }}</p>
                                    <p class="date-month">{{ $appointment->scheduled_at->format('M') }}</p>
                                </div>
                                <div class="appointment-info">
                                    <h4 class="appointment-type">{{ ucfirst($appointment->type) }} Consultation</h4>
                                    <p class="appointment-time">{{ $appointment->scheduled_at->format('g:i A') }}</p>
                                    @if($appointment->consultant)
                                        <p class="appointment-consultant">with {{ $appointment->consultant->name }}</p>
                                    @endif
                                </div>
                                <div class="appointment-status confirmed">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($pastAppointments->count() > 0)
                    <div class="appointments-section">
                        <h3 class="appointments-subtitle">Past</h3>
                        @foreach($pastAppointments as $appointment)
                            <div class="appointment-item past">
                                <div class="appointment-date">
                                    <p class="date-day">{{ $appointment->scheduled_at->format('d') }}</p>
                                    <p class="date-month">{{ $appointment->scheduled_at->format('M') }}</p>
                                </div>
                                <div class="appointment-info">
                                    <h4 class="appointment-type">{{ ucfirst($appointment->type) }} Consultation</h4>
                                    <p class="appointment-time">{{ $appointment->scheduled_at->format('g:i A') }}</p>
                                    @if($appointment->consultant)
                                        <p class="appointment-consultant">with {{ $appointment->consultant->name }}</p>
                                    @endif
                                </div>
                                <div class="appointment-status completed">
                                    <i class="fa-solid fa-check-double"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($upcomingAppointments->count() === 0 && $pastAppointments->count() === 0)
                    <div class="empty-state">
                        <i class="fa-regular fa-calendar"></i>
                        <p>No appointments yet</p>
                        <button onclick="openAppointmentModal()" class="btn-shop">Book Your First</button>
                    </div>
                @endif
            </div>

            <!-- Consultant Contact -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Contact Your Consultant</h2>
                </div>
                <form action="{{ route('profile.contact-consultant') }}" method="POST" class="consultant-form">
                    @csrf
                    <div class="form-group">
                        <label>Project Type</label>
                        <select name="project_type" required>
                            <option value="">Select project type</option>
                            <option value="engagement-ring">Engagement Ring</option>
                            <option value="wedding-bands">Wedding Bands</option>
                            <option value="necklace">Necklace</option>
                            <option value="bracelet">Bracelet</option>
                            <option value="earrings">Earrings</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="4" placeholder="Describe your vision..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Modal -->
<div id="appointment-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Book Appointment</h2>
            <button onclick="closeAppointmentModal()" class="btn-close">&times;</button>
        </div>
        <form action="{{ route('profile.book-appointment') }}" method="POST" class="appointment-form">
            @csrf
            <div class="form-group">
                <label>Consultant</label>
                <select name="consultant_id" required>
                    <option value="">Select consultant</option>
                    @foreach(\App\Models\Consultant::all() as $consultant)
                        <option value="{{ $consultant->id }}">{{ $consultant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Appointment Type</label>
                <select name="type" required>
                    <option value="virtual">Virtual Consultation</option>
                    <option value="in-person">In-Person Visit</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date & Time</label>
                <input type="datetime-local" name="scheduled_at" required>
            </div>
            <div class="form-group">
                <label>Notes (Optional)</label>
                <textarea name="notes" rows="3" placeholder="Any specific requests or questions..."></textarea>
            </div>
            <button type="submit" class="btn-submit">Book Appointment</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAppointmentModal() {
    document.getElementById('appointment-modal').classList.add('show');
}

function closeAppointmentModal() {
    document.getElementById('appointment-modal').classList.remove('show');
}

// Close modal when clicking outside
document.getElementById('appointment-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAppointmentModal();
    }
});
</script>
<style>
:root {
    --gold: #C9A84C;
    --gold-light: #E8C97A;
    --gold-dim: rgba(201,168,76,0.12);
    --cream: #F9F6F0;
    --ivory: #F2EDE4;
    --charcoal: #1C1C1C;
    --warm-gray: #8A8580;
    --border: rgba(28,28,28,0.10);
    --border-md: rgba(28,28,28,0.14);
}

.lespace-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
}

.lespace-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 48px;
    padding-bottom: 32px;
    border-bottom: 1px solid var(--border);
}

.header-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    color: var(--charcoal);
    margin: 0 0 8px 0;
}

.lespace-subtitle {
    color: var(--warm-gray);
    font-size: 1.1rem;
    margin: 0;
}

.user-greeting {
    text-align: right;
}

.greeting-text {
    color: var(--warm-gray);
    font-size: 1rem;
    margin-bottom: 12px;
}

.btn-edit-profile {
    display: inline-block;
    padding: 10px 24px;
    background: var(--gold);
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
}

.btn-edit-profile:hover {
    background: #A8862E;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 48px;
}

.stat-card {
    background: white;
    padding: 32px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: var(--gold-dim);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--gold);
}

.stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    color: var(--charcoal);
    margin: 0;
}

.stat-label {
    color: var(--warm-gray);
    font-size: 0.9rem;
    margin: 4px 0 0 0;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
}

.left-column, .right-column {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.section-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 32px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: var(--charcoal);
    margin: 0;
}

.btn-view-all, .btn-book {
    padding: 8px 16px;
    background: transparent;
    color: var(--gold);
    border: 1px solid var(--gold);
    border-radius: 4px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-view-all:hover, .btn-book:hover {
    background: var(--gold);
    color: white;
}

.orders-list, .projects-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.order-item, .project-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.order-item:hover, .project-item:hover {
    border-color: var(--gold);
    background: var(--gold-dim);
}

.order-number {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--charcoal);
    margin: 0;
}

.order-date {
    color: var(--warm-gray);
    font-size: 0.85rem;
    margin: 4px 0 0 0;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending { background: var(--gold-dim); color: var(--gold); }
.status-confirmed { background: rgba(39, 174, 96, 0.1); color: #27ae60; }
.status-processing { background: rgba(52, 152, 219, 0.1); color: #3498db; }
.status-shipped { background: rgba(155, 89, 182, 0.1); color: #9b59b6; }
.status-delivered { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }

.order-total {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--charcoal);
}

.project-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin: 0 0 4px 0;
}

.project-step, .project-consultant {
    color: var(--warm-gray);
    font-size: 0.85rem;
    margin: 2px 0;
}

.progress-bar {
    width: 100px;
    height: 6px;
    background: var(--border);
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--gold);
    transition: width 0.3s ease;
}

.treasures-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.treasure-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
}

.treasure-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.treasure-image.placeholder {
    background: var(--ivory);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--warm-gray);
}

.treasure-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    padding: 16px;
    color: white;
}

.treasure-name {
    font-family: 'Playfair Display', serif;
    font-size: 0.9rem;
    margin: 0 0 4px 0;
}

.treasure-serial, .treasure-date {
    font-size: 0.75rem;
    margin: 2px 0;
    opacity: 0.9;
}

.appointments-section {
    margin-bottom: 24px;
}

.appointments-section:last-child {
    margin-bottom: 0;
}

.appointments-subtitle {
    font-size: 0.9rem;
    color: var(--warm-gray);
    margin: 0 0 12px 0;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.appointment-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    margin-bottom: 12px;
}

.appointment-item:last-child {
    margin-bottom: 0;
}

.appointment-date {
    width: 50px;
    height: 50px;
    background: var(--gold-dim);
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.date-day {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--charcoal);
    margin: 0;
}

.date-month {
    font-size: 0.75rem;
    color: var(--warm-gray);
    margin: 0;
    text-transform: uppercase;
}

.appointment-type {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: var(--charcoal);
    margin: 0 0 4px 0;
}

.appointment-time, .appointment-consultant {
    color: var(--warm-gray);
    font-size: 0.85rem;
    margin: 2px 0;
}

.appointment-status {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
}

.appointment-status.confirmed {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.appointment-status.completed {
    background: rgba(155, 89, 182, 0.1);
    color: #9b59b6;
}

.consultant-form, .appointment-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 0.85rem;
    color: var(--charcoal);
    font-weight: 500;
}

.form-group select,
.form-group input,
.form-group textarea {
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

.form-group select:focus,
.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--gold);
}

.btn-submit {
    padding: 12px 24px;
    background: var(--gold);
    color: white;
    border: none;
    border-radius: 6px;
    font-family: 'Jost', sans-serif;
    font-size: 0.9rem;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background: #A8862E;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--warm-gray);
}

.empty-state i {
    font-size: 2.5rem;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state p {
    margin: 0 0 16px 0;
}

.empty-hint {
    font-size: 0.85rem;
    margin: 0 0 16px 0;
}

.btn-shop {
    display: inline-block;
    padding: 10px 24px;
    background: var(--charcoal);
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-shop:hover {
    background: #2C2C2C;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 12px;
    padding: 32px;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.modal-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: var(--charcoal);
    margin: 0;
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--warm-gray);
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.btn-close:hover {
    background: var(--border);
    color: var(--charcoal);
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .lespace-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 24px;
    }
    
    .user-greeting {
        text-align: left;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .treasures-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openAppointmentModal() {
    document.getElementById('appointment-modal').classList.add('show');
}

function closeAppointmentModal() {
    document.getElementById('appointment-modal').classList.remove('show');
}

// Close modal when clicking outside
document.getElementById('appointment-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAppointmentModal();
    }
});
</script>
@endpush
