@extends('layouts.admin')
@section('title', 'Enquiry Dossier #' . $enquiry->reference_number)
@section('page-title', 'Enquiry Details')

@section('content')
<div class="page-head">
    <div>
        <div style="display:flex;align-items:center;gap:12px">
            <h1 class="page-head-title">Enquiry #{{ $enquiry->reference_number }}</h1>
            <span class="badge-status badge-{{ $enquiry->status }}" style="font-size:0.85rem;padding:4px 12px">
                {{ $enquiry->status_label }}
            </span>
        </div>
        <p class="page-head-sub">Received on {{ $enquiry->created_at->format('l, d F Y \a\t h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline">
            ← Back to CRM
        </a>
        <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Permanently delete this enquiry record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-admin btn-admin-danger">
                Delete Dossier
            </button>
        </form>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:start">
    <!-- Left Main Column -->
    <div style="display:flex;flex-direction:column;gap:24px">
        <!-- Client Profile & Requirements -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Client Information & Contact Details</h2>
                <div style="display:flex;gap:8px">
                    @php $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->mobile_number); @endphp
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn-admin btn-admin-sm" style="background:#25D366;color:white;border:none">
                        WhatsApp Client
                    </a>
                    <a href="tel:{{ $enquiry->mobile_number }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        Call
                    </a>
                    <a href="mailto:{{ $enquiry->email }}" class="btn-admin btn-admin-outline btn-admin-sm">
                        Email
                    </a>
                </div>
            </div>
            <div class="admin-card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Full Name</div>
                        <div style="font-size:1.1rem;font-weight:700;color:var(--admin-text);margin-top:4px">{{ $enquiry->full_name }}</div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Company / Organization</div>
                        <div style="font-size:1.1rem;font-weight:600;color:var(--admin-text);margin-top:4px">{{ $enquiry->company_name ?? 'Individual' }}</div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Mobile Number</div>
                        <div style="font-size:1rem;color:var(--admin-gold);font-weight:600;margin-top:4px">{{ $enquiry->mobile_number }}</div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Email Address</div>
                        <div style="font-size:1rem;color:var(--admin-text);margin-top:4px">
                            <a href="mailto:{{ $enquiry->email }}" style="color:#60A5FA">{{ $enquiry->email }}</a>
                        </div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Location / City</div>
                        <div style="font-size:0.95rem;color:var(--admin-text);margin-top:4px">{{ $enquiry->location ?? 'Not specified' }}</div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Submission IP Address</div>
                        <div style="font-size:0.9rem;color:var(--admin-muted);margin-top:4px"><code>{{ $enquiry->ip_address ?? '127.0.0.1' }}</code></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Specification Requested -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Enquiry Scope & Specifications</h2>
            </div>
            <div class="admin-card-body">
                <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;background:var(--admin-bg);padding:16px;border-radius:8px;border:1px solid var(--admin-border);margin-bottom:20px">
                    <div>
                        <div style="font-size:0.72rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Target Category</div>
                        <div style="font-size:1rem;font-weight:600;color:var(--admin-gold);margin-top:4px">
                            {{ optional($enquiry->category)->name ?? 'General Inquiry' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size:0.72rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Product Model</div>
                        <div style="font-size:1rem;font-weight:600;margin-top:4px">
                            {{ $enquiry->product_name ?? optional($enquiry->product)->name ?? 'Custom Architecture' }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size:0.72rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700">Quantity Needed</div>
                        <div style="font-size:1.1rem;font-weight:700;color:var(--admin-green);margin-top:4px">
                            {{ $enquiry->quantity }} Unit(s)
                        </div>
                    </div>
                </div>

                @if($enquiry->budget_range)
                <div style="margin-bottom:20px">
                    <span style="font-size:0.78rem;color:var(--admin-muted);font-weight:600">Expected Budget:</span>
                    <span style="font-size:0.95rem;font-weight:600;margin-left:8px">{{ $enquiry->budget_range }}</span>
                </div>
                @endif

                <div style="margin-top:16px">
                    <div style="font-size:0.78rem;color:var(--admin-muted);text-transform:uppercase;letter-spacing:1px;font-weight:700;margin-bottom:8px">Client Detailed Message</div>
                    <div style="background:var(--admin-bg);border:1px solid var(--admin-border);border-radius:8px;padding:16px 20px;font-size:0.92rem;line-height:1.7;white-space:pre-wrap;color:var(--admin-text)">
                        {{ $enquiry->message ?? 'No specific message entered by client.' }}
                    </div>
                </div>

                @if($enquiry->attachment)
                <div style="margin-top:20px;padding:16px;background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.2);border-radius:8px;display:flex;align-items:center;justify-content:space-between">
                    <div>
                        <div style="font-weight:600;font-size:0.9rem">Attached Architecture / Specification File</div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);margin-top:2px">Uploaded by client during enquiry submission</div>
                    </div>
                    <a href="{{ $enquiry->attachment_url }}" target="_blank" class="btn-admin btn-admin-primary btn-admin-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download File
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- CRM Internal Team Notes -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Internal Team Activity & Follow-up Notes</h2>
                    <p style="font-size:0.75rem;color:var(--admin-muted)">Log calls, site visits, quotations sent, and deal milestones</p>
                </div>
            </div>
            <div class="admin-card-body">
                <!-- Add Note Form -->
                <form action="{{ route('admin.enquiries.add-note', $enquiry->id) }}" method="POST" style="margin-bottom:24px">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="new-note">Add Activity Note</label>
                        <textarea id="new-note" name="note" class="admin-form-control" rows="3" required placeholder="e.g. Spoke with client regarding dimensions and timeline. Sent quotation PDF via email..."></textarea>
                    </div>
                    <button type="submit" class="btn-admin btn-admin-primary btn-admin-sm">
                        Add Note
                    </button>
                </form>

                <!-- Notes Timeline -->
                <div style="display:flex;flex-direction:column;gap:12px">
                    @forelse($enquiry->notes as $note)
                    <div style="background:var(--admin-bg);border:1px solid var(--admin-border);border-left:3px solid var(--admin-gold);border-radius:6px;padding:12px 16px">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                            <span style="font-weight:600;font-size:0.85rem;color:var(--admin-text)">
                                {{ optional($note->user)->name ?? 'Team Member' }}
                            </span>
                            <span style="font-size:0.75rem;color:var(--admin-muted)">
                                {{ $note->created_at->format('d M Y, h:i A') }} ({{ $note->created_at->diffForHumans() }})
                            </span>
                        </div>
                        <div style="font-size:0.88rem;color:var(--admin-text);line-height:1.6">
                            {{ $note->note }}
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:24px;color:var(--admin-muted);font-size:0.85rem">
                        No internal notes yet. Use the form above to record meeting notes or follow-up milestones.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Column -->
    <div style="display:flex;flex-direction:column;gap:24px">
        <!-- Pipeline Status Updater -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Update Lead Status</h2>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.enquiries.update-status', $enquiry->id) }}" method="POST">
                    @csrf
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="pipeline-status">Current Pipeline Stage</label>
                        <select id="pipeline-status" name="status" class="admin-form-control" style="font-weight:600">
                            @foreach(\App\Models\Enquiry::STATUS_LABELS as $sKey => $sLabel)
                                <option value="{{ $sKey }}" {{ $enquiry->status === $sKey ? 'selected' : '' }}>
                                    {{ $sLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;justify-content:center">
                        Update Status
                    </button>
                </form>

                @if($enquiry->contacted_at)
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--admin-border);font-size:0.78rem;color:var(--admin-muted)">
                    First Contacted: {{ $enquiry->contacted_at->format('d M Y, h:i A') }}
                </div>
                @endif
            </div>
        </div>

        <!-- Meta Dossier Box -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Dossier Summary</h2>
            </div>
            <div class="admin-card-body" style="font-size:0.82rem;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--admin-muted)">Lead ID</span>
                    <span>#{{ $enquiry->id }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--admin-muted)">Reference</span>
                    <span style="font-weight:600;color:var(--admin-gold)">{{ $enquiry->reference_number }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--admin-muted)">Logged At</span>
                    <span>{{ $enquiry->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <span style="color:var(--admin-muted)">Last Updated</span>
                    <span>{{ $enquiry->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
