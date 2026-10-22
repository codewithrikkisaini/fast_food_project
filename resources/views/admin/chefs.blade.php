@extends('admin.layouts.app')

@section('title', 'Chefs Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Culinary Team &amp; Chefs Management</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage head chefs, master grillers, and culinary profiles displayed across your restaurant website.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('about') }}#chefs" target="_blank" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-eye me-1"></i> View Chefs on Live Site
        </a>
        <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addChefModal">
            <i class="fas fa-user-plus me-1"></i> Add New Chef Profile
        </button>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-25 text-success mb-4" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-25 text-danger mb-4" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i> <strong>Please correct the following errors:</strong>
    <ul class="mb-0 mt-2 small">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- CHEFS GRID -->
<div class="row g-4">
    @forelse($chefs as $chef)
        <div class="col-sm-6 col-lg-3">
            <div class="admin-card h-100 d-flex flex-column justify-content-between shadow-sm">
                <div>
                    <!-- Chef Photo -->
                    <div class="position-relative mb-3 rounded-3 overflow-hidden" style="background:#090d16;border:1px solid #334155;">
                        <img src="{{ asset($chef['image']) }}" class="w-100" style="height:230px;object-fit:cover;" alt="{{ $chef['name'] }}" onerror="this.src='{{ asset('img/chefs/1.jpg') }}'"/>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-2 py-1" style="font-size:0.7rem;">
                            ID: #{{ $chef['id'] ?? '1' }}
                        </span>
                    </div>

                    <!-- Chef Info -->
                    <h5 class="text-white mb-1 fw-bold">{{ $chef['name'] }}</h5>
                    <div class="text-warning small fw-semibold mb-2"><i class="fas fa-utensils me-1"></i>{{ $chef['role'] }}</div>
                    <div class="d-inline-flex align-items-center gap-1 badge bg-dark border border-secondary text-light mb-2 px-2 py-1">
                        <i class="fas fa-medal text-warning"></i> {{ $chef['exp'] }}
                    </div>

                    @if(!empty($chef['bio']))
                        <p class="text-secondary small mb-3" style="line-height:1.45;font-size:0.82rem;">{{ Str::limit($chef['bio'], 100) }}</p>
                    @endif

                    <!-- Social Icons Preview -->
                    <div class="d-flex gap-2 mb-2">
                        @if(!empty($chef['instagram']))
                            <a href="{{ $chef['instagram'] }}" target="_blank" class="text-secondary small" title="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($chef['facebook']))
                            <a href="{{ $chef['facebook'] }}" target="_blank" class="text-secondary small" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($chef['twitter']))
                            <a href="{{ $chef['twitter'] }}" target="_blank" class="text-secondary small" title="Twitter"><i class="fab fa-twitter"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="pt-3 border-top border-secondary border-opacity-50 d-flex justify-content-between align-items-center mt-3">
                    <button type="button" class="btn btn-sm btn-dark border border-secondary text-light px-3" data-bs-toggle="modal" data-bs-target="#editChefModal{{ $chef['id'] }}">
                        <i class="fas fa-edit me-1 text-warning"></i> Edit
                    </button>
                    <form action="{{ route('admin.chefs.delete', $chef['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $chef['name'] }} from culinary team?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Remove Chef">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- EDIT CHEF MODAL -->
        <div class="modal fade" id="editChefModal{{ $chef['id'] }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark border-secondary text-light shadow-lg">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-user-edit text-warning me-2"></i>Edit Chef: {{ $chef['name'] }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.chefs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $chef['id'] }}"/>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-admin">Chef Name *</label>
                                    <input type="text" name="name" class="form-control form-control-admin" value="{{ $chef['name'] }}" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-admin">Executive Role / Title *</label>
                                    <input type="text" name="role" class="form-control form-control-admin" value="{{ $chef['role'] }}" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-admin">Years of Experience *</label>
                                    <input type="text" name="exp" class="form-control form-control-admin" value="{{ $chef['exp'] }}" required/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-admin">Chef Photo (Upload to replace)</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:50px;height:50px;border-radius:8px;overflow:hidden;border:1px solid #334155;flex-shrink:0;background:#090d16;">
                                            <img id="editChefThumb_{{ $chef['id'] }}" src="{{ asset($chef['image']) }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/chefs/1.jpg') }}'"/>
                                        </div>
                                        <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*" onchange="previewChefImg(this, 'editChefThumb_{{ $chef['id'] }}')"/>
                                    </div>
                                    <input type="hidden" name="image" value="{{ $chef['image'] }}"/>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-admin">Short Biography / Culinary Specialty</label>
                                    <textarea name="bio" class="form-control form-control-admin" rows="3" placeholder="Specialized in wood-fired grills, smoked seasoning blends...">{{ $chef['bio'] ?? '' }}</textarea>
                                </div>
                                <div class="col-12 pt-2 border-top border-secondary border-opacity-50">
                                    <h6 class="text-warning small mb-3"><i class="fas fa-share-alt me-1"></i> Social Profiles (Optional)</h6>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-instagram"></i></span>
                                                <input type="text" name="instagram" class="form-control form-control-admin" value="{{ $chef['instagram'] ?? '' }}" placeholder="Instagram Profile URL"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-dark border-secondary text-primary"><i class="fab fa-facebook-f"></i></span>
                                                <input type="text" name="facebook" class="form-control form-control-admin" value="{{ $chef['facebook'] ?? '' }}" placeholder="Facebook Profile URL"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-twitter"></i></span>
                                                <input type="text" name="twitter" class="form-control form-control-admin" value="{{ $chef['twitter'] ?? '' }}" placeholder="Twitter / X Profile URL"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-admin-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-user-friends fa-3x mb-3 text-secondary"></i>
            <h5>No Chefs Registered Yet</h5>
            <p class="small text-secondary">Click the button above to add your first executive chef or grill specialist.</p>
        </div>
    @endforelse
</div>

<!-- ADD CHEF MODAL -->
<div class="modal fade" id="addChefModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-light shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-plus text-danger me-2"></i>Add Chef Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.chefs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-admin">Chef Name *</label>
                            <input type="text" name="name" class="form-control form-control-admin" placeholder="e.g. Gordon Ramsay" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-admin">Executive Role / Title *</label>
                            <input type="text" name="role" class="form-control form-control-admin" placeholder="e.g. Master Grill Specialist" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-admin">Years of Experience *</label>
                            <input type="text" name="exp" class="form-control form-control-admin" placeholder="e.g. 10 years experience" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-admin">Chef Photo (Upload JPG, PNG &le; 5MB)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:50px;height:50px;border-radius:8px;overflow:hidden;border:1px solid #334155;flex-shrink:0;background:#090d16;">
                                    <img id="addChefThumb" src="{{ asset('img/chefs/1.jpg') }}" style="width:100%;height:100%;object-fit:cover;"/>
                                </div>
                                <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*" onchange="previewChefImg(this, 'addChefThumb')"/>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Short Biography / Culinary Specialty</label>
                            <textarea name="bio" class="form-control form-control-admin" rows="3" placeholder="Specialized in wood-fired grills, smoked seasoning blends..."></textarea>
                        </div>
                        <div class="col-12 pt-2 border-top border-secondary border-opacity-50">
                            <h6 class="text-warning small mb-3"><i class="fas fa-share-alt me-1"></i> Social Profiles (Optional)</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-dark border-secondary text-danger"><i class="fab fa-instagram"></i></span>
                                        <input type="text" name="instagram" class="form-control form-control-admin" placeholder="Instagram URL"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-dark border-secondary text-primary"><i class="fab fa-facebook-f"></i></span>
                                        <input type="text" name="facebook" class="form-control form-control-admin" placeholder="Facebook URL"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-dark border-secondary text-info"><i class="fab fa-twitter"></i></span>
                                        <input type="text" name="twitter" class="form-control form-control-admin" placeholder="Twitter URL"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-check-circle me-1"></i> Add Chef Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
    function previewChefImg(input, thumbId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const el = document.getElementById(thumbId);
                if (el) el.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
