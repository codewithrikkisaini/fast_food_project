@extends('admin.layouts.app')

@section('title', 'Chefs Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Culinary Team &amp; Chefs Management</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage head chefs, master grillers, and culinary profiles shown on the front website.</p>
    </div>
    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addChefModal">
        <i class="fas fa-plus"></i> Add New Chef Profile
    </button>
</div>

<!-- CHEFS GRID -->
<div class="row g-4">
    @forelse($chefs as $chef)
        <div class="col-sm-6 col-lg-3">
            <div class="admin-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="position-relative mb-3 rounded-3 overflow-hidden">
                        <img src="{{ asset($chef['image']) }}" class="w-100" style="height:220px;object-fit:cover;" alt="{{ $chef['name'] }}"/>
                    </div>
                    <h5 class="text-white mb-1 fw-bold">{{ $chef['name'] }}</h5>
                    <div class="text-warning small fw-semibold mb-1">{{ $chef['role'] }}</div>
                    <div class="badge bg-dark border text-light mb-2"><i class="fas fa-history me-1"></i>{{ $chef['exp'] }}</div>
                    @if(!empty($chef['bio']))
                        <p class="text-secondary small mb-3" style="line-height:1.4;">{{ $chef['bio'] }}</p>
                    @endif
                </div>
                <div class="pt-3 border-top border-secondary d-flex justify-content-end">
                    <form action="{{ route('admin.chefs.delete', $chef['id']) }}" method="POST" onsubmit="return confirm('Delete this chef profile?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt me-1"></i> Remove Chef
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No chefs registered yet.</div>
    @endforelse
</div>

<!-- ADD CHEF MODAL -->
<div class="modal fade" id="addChefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><i class="fas fa-user-plus text-danger me-2"></i>Add Chef Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.chefs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Chef Name *</label>
                            <input type="text" name="name" class="form-control form-control-admin" placeholder="e.g. Gordon Ramsay" required/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Executive Role / Title *</label>
                            <input type="text" name="role" class="form-control form-control-admin" placeholder="e.g. Master Grill Specialist" required/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Years of Experience *</label>
                            <input type="text" name="exp" class="form-control form-control-admin" placeholder="e.g. 10 years experience" required/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Short Biography / Culinary Specialty</label>
                            <textarea name="bio" class="form-control form-control-admin" rows="3" placeholder="Specialized in wood-fired grills, smoked seasoning blends..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary">Add Chef Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
