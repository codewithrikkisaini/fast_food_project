@extends('admin.layouts.app')

@section('title', 'Menu Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Food Menu Management</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Add new dishes, adjust pricing, upload custom food photos, and manage preparation specs.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('menu') }}" target="_blank" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-eye me-1"></i> View Live Menu Page
        </a>
        <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="fas fa-plus me-1"></i> Add New Food Dish
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

<!-- SEARCH & CATEGORY FILTER BAR -->
<div class="admin-card mb-4 p-3">
    <div class="row g-3 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-secondary"><i class="fas fa-search"></i></span>
                <input type="text" id="menuSearchInput" class="form-control form-control-admin" placeholder="Search dish title, description, or tags..." onkeyup="filterMenuTable()"/>
            </div>
        </div>
        <div class="col-md-4">
            <select id="menuCategoryFilter" class="form-select form-control-admin" onchange="filterMenuTable()">
                <option value="">All Categories ({{ count($menuItems) }})</option>
                <option value="burgers">Burgers</option>
                <option value="pizza">Pizza</option>
                <option value="chicken">Chicken</option>
                <option value="wraps">Wraps</option>
                <option value="desserts">Desserts</option>
                <option value="pasta">Pasta</option>
                <option value="drinks">Drinks</option>
                <option value="salads">Salads</option>
            </select>
        </div>
        <div class="col-md-3 text-md-end text-secondary small">
            Showing <strong class="text-white" id="visibleCount">{{ count($menuItems) }}</strong> of {{ count($menuItems) }} dishes
        </div>
    </div>
</div>

<!-- MENU ITEMS TABLE -->
<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <h3 class="admin-card-title mb-0"><i class="fas fa-utensils text-danger me-2"></i> All Menu Dishes</h3>
        <span class="text-secondary small">Live synchronization with frontend menu</span>
    </div>

    <div class="table-responsive">
        <table class="table-admin" id="menuDishesTable">
            <thead>
                <tr>
                    <th>Dish Details</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Prep &amp; Calories</th>
                    <th>Badge</th>
                    <th>Rating</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menuItems as $item)
                    <tr class="dish-row" data-category="{{ strtolower($item['category'] ?? '') }}" data-title="{{ strtolower($item['title'] ?? '') }}" data-desc="{{ strtolower($item['desc'] ?? '') }}">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" style="width:58px;height:52px;object-fit:cover;border-radius:10px;border:1px solid #334155;" onerror="this.src='{{ asset('img/menu/1.jpg') }}'"/>
                                <div>
                                    <div class="fw-bold text-white">{{ $item['title'] }}</div>
                                    <small class="text-secondary" style="font-size:0.75rem;">{{ Str::limit($item['desc'], 55) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-warning">{{ $item['category_name'] ?? ucfirst($item['category'] ?? 'General') }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-danger fs-6">${{ number_format((float)$item['price'], 2) }}</div>
                            @if(!empty($item['old_price']))
                                <small class="text-muted text-decoration-line-through">${{ number_format((float)$item['old_price'], 2) }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="small text-light">{{ $item['cal'] ?? 500 }} kcal</div>
                            <small class="text-secondary">{{ $item['time'] ?? 15 }} mins prep</small>
                        </td>
                        <td>
                            @if(!empty($item['badge']))
                                <span class="badge {{ ($item['badge_class'] ?? 'hot') === 'new' ? 'bg-primary' : 'bg-danger' }}">
                                    {{ $item['badge'] }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-warning small"><i class="fas fa-star"></i> {{ $item['rating'] ?? 5.0 }}</span>
                            <small class="text-secondary d-block" style="font-size:0.7rem;">({{ $item['reviews'] ?? 1 }} reviews)</small>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-dark border border-secondary text-light px-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $item['id'] }}" 
                                    title="Edit Item">
                                    <i class="fas fa-edit text-warning"></i>
                                </button>
                                <form action="{{ route('admin.menu.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete \'{{ $item['title'] }}\'?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Delete Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark border-secondary text-light shadow-lg">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title"><i class="fas fa-edit text-warning me-2"></i>Edit Dish: {{ $item['title'] }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}"/>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label class="form-label-admin">Dish Title *</label>
                                                <input type="text" name="title" class="form-control form-control-admin" value="{{ $item['title'] }}" required/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Category *</label>
                                                <select name="category" class="form-select form-control-admin" required>
                                                    <option value="burgers" {{ ($item['category'] ?? '') == 'burgers' ? 'selected' : '' }}>Burgers</option>
                                                    <option value="pizza" {{ ($item['category'] ?? '') == 'pizza' ? 'selected' : '' }}>Pizza</option>
                                                    <option value="chicken" {{ ($item['category'] ?? '') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                                                    <option value="wraps" {{ ($item['category'] ?? '') == 'wraps' ? 'selected' : '' }}>Wraps</option>
                                                    <option value="desserts" {{ ($item['category'] ?? '') == 'desserts' ? 'selected' : '' }}>Desserts</option>
                                                    <option value="pasta" {{ ($item['category'] ?? '') == 'pasta' ? 'selected' : '' }}>Pasta</option>
                                                    <option value="drinks" {{ ($item['category'] ?? '') == 'drinks' ? 'selected' : '' }}>Drinks</option>
                                                    <option value="salads" {{ ($item['category'] ?? '') == 'salads' ? 'selected' : '' }}>Salads</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Price ($) *</label>
                                                <input type="number" step="0.01" name="price" class="form-control form-control-admin" value="{{ $item['price'] }}" required/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Old Price ($) (Optional)</label>
                                                <input type="number" step="0.01" name="old_price" class="form-control form-control-admin" value="{{ $item['old_price'] ?? '' }}"/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Badge (e.g. Hot, New)</label>
                                                <input type="text" name="badge" class="form-control form-control-admin" value="{{ $item['badge'] ?? '' }}" placeholder="Hot, New, Chef's Pick"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label-admin">Calories (kcal)</label>
                                                <input type="number" name="cal" class="form-control form-control-admin" value="{{ $item['cal'] ?? 550 }}"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label-admin">Preparation Time (minutes)</label>
                                                <input type="number" name="time" class="form-control form-control-admin" value="{{ $item['time'] ?? 15 }}"/>
                                            </div>
                                            <!-- Image Upload & Preview -->
                                            <div class="col-12">
                                                <label class="form-label-admin">Dish Photo (Upload to replace)</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div style="width:65px;height:55px;border-radius:8px;overflow:hidden;border:1px solid #334155;flex-shrink:0;background:#090d16;">
                                                        <img id="editDishThumb_{{ $item['id'] }}" src="{{ asset($item['image']) }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.src='{{ asset('img/menu/1.jpg') }}'"/>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input type="file" name="image_file" class="form-control form-control-admin mb-1" accept="image/*" onchange="previewDishImg(this, 'editDishThumb_{{ $item['id'] }}')"/>
                                                        <small class="text-secondary" style="font-size:0.75rem;">Upload new dish photo (JPG, PNG, WebP &le; 5MB)</small>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="image" value="{{ $item['image'] }}"/>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label-admin">Description *</label>
                                                <textarea name="desc" class="form-control form-control-admin" rows="3" required>{{ $item['desc'] }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label-admin">Tags (comma separated)</label>
                                                <input type="text" name="tags" class="form-control form-control-admin" value="{{ is_array($item['tags'] ?? '') ? implode(', ', $item['tags']) : ($item['tags'] ?? '') }}"/>
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
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-utensils fa-3x mb-3 text-secondary"></i>
                            <h5>No Menu Items Created Yet</h5>
                            <p class="small text-secondary">Click "Add New Food Dish" above to create your first delicious menu item.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ADD ITEM MODAL -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-light shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-danger me-2"></i>Add New Food Dish</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label-admin">Dish Title *</label>
                            <input type="text" name="title" class="form-control form-control-admin" placeholder="e.g. Double Bacon Truffle Smash" required/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-admin">Category *</label>
                            <select name="category" class="form-select form-control-admin" required>
                                <option value="burgers">Burgers</option>
                                <option value="pizza">Pizza</option>
                                <option value="chicken">Chicken</option>
                                <option value="wraps">Wraps</option>
                                <option value="desserts">Desserts</option>
                                <option value="pasta">Pasta</option>
                                <option value="drinks">Drinks</option>
                                <option value="salads">Salads</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-admin">Price ($) *</label>
                            <input type="number" step="0.01" name="price" class="form-control form-control-admin" placeholder="14.99" required/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-admin">Old Price ($) (Optional)</label>
                            <input type="number" step="0.01" name="old_price" class="form-control form-control-admin" placeholder="18.99"/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-admin">Badge (e.g. Hot, New, Chef's Pick)</label>
                            <input type="text" name="badge" class="form-control form-control-admin" placeholder="Hot"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-admin">Calories (kcal)</label>
                            <input type="number" name="cal" class="form-control form-control-admin" placeholder="620"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-admin">Preparation Time (minutes)</label>
                            <input type="number" name="time" class="form-control form-control-admin" placeholder="15"/>
                        </div>
                        <!-- Image Upload & Preview -->
                        <div class="col-12">
                            <label class="form-label-admin">Dish Photo (Upload JPG, PNG, WebP &le; 5MB)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:65px;height:55px;border-radius:8px;overflow:hidden;border:1px solid #334155;flex-shrink:0;background:#090d16;">
                                    <img id="addDishThumb" src="{{ asset('img/menu/1.jpg') }}" style="width:100%;height:100%;object-fit:cover;"/>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image_file" class="form-control form-control-admin mb-1" accept="image/*" onchange="previewDishImg(this, 'addDishThumb')"/>
                                    <small class="text-secondary" style="font-size:0.75rem;">Leave empty to auto-assign a category default photo</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Description *</label>
                            <textarea name="desc" class="form-control form-control-admin" rows="3" placeholder="Freshly seasoned ingredients, secret sauces, and preparation style..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label-admin">Tags (comma separated)</label>
                            <input type="text" name="tags" class="form-control form-control-admin" placeholder="Spicy, Bestseller, Chef's Special"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add Food Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('admin-scripts')
<script>
    function previewDishImg(input, thumbId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const el = document.getElementById(thumbId);
                if (el) el.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function filterMenuTable() {
        const query = (document.getElementById('menuSearchInput').value || '').toLowerCase().trim();
        const selectedCat = (document.getElementById('menuCategoryFilter').value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#menuDishesTable tbody .dish-row');
        let visible = 0;

        rows.forEach(row => {
            const rowCat = (row.getAttribute('data-category') || '').toLowerCase();
            const rowTitle = (row.getAttribute('data-title') || '').toLowerCase();
            const rowDesc = (row.getAttribute('data-desc') || '').toLowerCase();

            const matchesQuery = !query || rowTitle.includes(query) || rowDesc.includes(query);
            const matchesCat = !selectedCat || rowCat === selectedCat;

            if (matchesQuery && matchesCat) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        const countEl = document.getElementById('visibleCount');
        if (countEl) countEl.textContent = visible;
    }
</script>
@endpush
