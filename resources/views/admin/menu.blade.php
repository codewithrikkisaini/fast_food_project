@extends('admin.layouts.app')

@section('title', 'Menu Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Food Menu Management</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Add new items, adjust pricing, manage categories, and update preparation details.</p>
    </div>
    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
        <i class="fas fa-plus"></i> Add New Food Dish
    </button>
</div>

<!-- MENU ITEMS TABLE -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-utensils text-danger"></i> All Menu Dishes ({{ count($menuItems) }})</h3>
        <div class="text-secondary small">Live synchronization with frontend menu</div>
    </div>

    <div class="table-responsive">
        <table class="table-admin">
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
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}" style="width:55px;height:50px;object-fit:cover;border-radius:10px;"/>
                                <div>
                                    <div class="fw-bold text-white">{{ $item['title'] }}</div>
                                    <small class="text-secondary" style="font-size:0.75rem;">{{ Str::limit($item['desc'], 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark border text-warning">{{ $item['category_name'] }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-danger">${{ number_format($item['price'], 2) }}</div>
                            @if(!empty($item['old_price']))
                                <small class="text-muted text-decoration-line-through">${{ number_format($item['old_price'], 2) }}</small>
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
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-dark border text-light" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $item['id'] }}" 
                                    title="Edit Item">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.menu.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu dish?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Item">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-dark border-secondary text-light">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title"><i class="fas fa-edit text-warning me-2"></i>Edit Dish: {{ $item['title'] }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.menu.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}"/>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <label class="form-label-admin">Dish Title</label>
                                                <input type="text" name="title" class="form-control form-control-admin" value="{{ $item['title'] }}" required/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Category</label>
                                                <select name="category" class="form-control form-control-admin" required>
                                                    <option value="burgers" {{ $item['category'] == 'burgers' ? 'selected' : '' }}>Burgers</option>
                                                    <option value="pizza" {{ $item['category'] == 'pizza' ? 'selected' : '' }}>Pizza</option>
                                                    <option value="chicken" {{ $item['category'] == 'chicken' ? 'selected' : '' }}>Chicken</option>
                                                    <option value="wraps" {{ $item['category'] == 'wraps' ? 'selected' : '' }}>Wraps</option>
                                                    <option value="desserts" {{ $item['category'] == 'desserts' ? 'selected' : '' }}>Desserts</option>
                                                    <option value="pasta" {{ $item['category'] == 'pasta' ? 'selected' : '' }}>Pasta</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Price ($)</label>
                                                <input type="number" step="0.01" name="price" class="form-control form-control-admin" value="{{ $item['price'] }}" required/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Old Price ($) (Optional)</label>
                                                <input type="number" step="0.01" name="old_price" class="form-control form-control-admin" value="{{ $item['old_price'] ?? '' }}"/>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-admin">Badge (e.g. Hot, New)</label>
                                                <input type="text" name="badge" class="form-control form-control-admin" value="{{ $item['badge'] ?? '' }}"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label-admin">Calories (kcal)</label>
                                                <input type="number" name="cal" class="form-control form-control-admin" value="{{ $item['cal'] ?? 550 }}"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label-admin">Preparation Time (minutes)</label>
                                                <input type="number" name="time" class="form-control form-control-admin" value="{{ $item['time'] ?? 15 }}"/>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label-admin">Description</label>
                                                <textarea name="desc" class="form-control form-control-admin" rows="3" required>{{ $item['desc'] }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label-admin">Tags (comma separated)</label>
                                                <input type="text" name="tags" class="form-control form-control-admin" value="{{ is_array($item['tags'] ?? '') ? implode(', ', $item['tags']) : $item['tags'] }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn-admin-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No menu items created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ADD ITEM MODAL -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-danger me-2"></i>Add New Food Dish</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label-admin">Dish Title *</label>
                            <input type="text" name="title" class="form-control form-control-admin" placeholder="e.g. Double Bacon Truffle Smash" required/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-admin">Category *</label>
                            <select name="category" class="form-control form-control-admin" required>
                                <option value="burgers">Burgers</option>
                                <option value="pizza">Pizza</option>
                                <option value="chicken">Chicken</option>
                                <option value="wraps">Wraps</option>
                                <option value="desserts">Desserts</option>
                                <option value="pasta">Pasta</option>
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
                    <button type="submit" class="btn-admin-primary">Add Food Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
