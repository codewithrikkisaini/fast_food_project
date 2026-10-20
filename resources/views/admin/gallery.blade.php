@extends('admin.layouts.app')

@section('title', 'Food Gallery Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Food Gallery &amp; Showcase Manager</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Manage culinary photography, signature dishes, and gallery highlights displayed across the live website.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('gallery') }}" target="_blank" class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2">
            <i class="fas fa-eye"></i> View Live Gallery
        </a>
        <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
            <i class="fas fa-plus"></i> Add Gallery Item
        </button>
    </div>
</div>

<!-- GALLERY GRID -->
<div class="row g-4">
    @forelse($galleryItems as $index => $item)
        <div class="col-sm-6 col-lg-4">
            <div class="admin-card h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="position-relative mb-3 rounded-3 overflow-hidden" style="height:210px; background: #000;">
                        <img src="{{ asset($item['image']) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $item['title'] }}"
                            onerror="this.src='{{ asset('img/portfolio/work1.jpg') }}'"/>
                        <span class="badge position-absolute top-0 end-0 m-2 px-3 py-1" style="background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; font-size: 0.75rem; backdrop-filter: blur(4px);">
                            <i class="fas fa-tag me-1"></i>{{ $item['category'] ?? 'Showcase' }}
                        </span>
                    </div>
                    <h5 class="text-white mb-2 fw-bold">{{ $item['title'] }}</h5>
                    <p class="text-secondary small mb-3" style="line-height:1.5;">{{ $item['desc'] }}</p>
                </div>
                <div class="pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                    <span class="text-muted small">ID: #{{ $item['id'] }}</span>
                    <form action="{{ route('admin.gallery.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this gallery item?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt me-1"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted mb-3"><i class="fas fa-images fa-3x"></i></div>
            <h5 class="text-white">No gallery items yet</h5>
            <p class="text-secondary">Click "Add Gallery Item" to upload your first food showcase image.</p>
        </div>
    @endforelse
</div>

<!-- ADD GALLERY MODAL -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><i class="fas fa-camera text-danger me-2"></i>Add Food Gallery Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-admin">Item Headline / Dish Title *</label>
                            <input type="text" name="title" class="form-control form-control-admin" placeholder="e.g. Gourmet Truffle Smash Burger" required/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Category / Badge Tag</label>
                            <input type="text" name="category" class="form-control form-control-admin" placeholder="e.g. Gourmet Burgers, Wood-Fired Pizza"/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Upload Photo File (JPEG, PNG, WebP)</label>
                            <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*"/>
                            <small class="text-secondary">Or specify an existing asset path below</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Or Asset Image Path (Optional)</label>
                            <input type="text" name="image" class="form-control form-control-admin" placeholder="e.g. img/portfolio/work1.jpg"/>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Short Dish Description *</label>
                            <textarea name="desc" class="form-control form-control-admin" rows="3" placeholder="Describe the ingredients, cooking method, flavor profile..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-check me-1"></i> Save Gallery Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
