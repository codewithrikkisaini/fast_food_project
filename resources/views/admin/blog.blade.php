@extends('admin.layouts.app')

@section('title', 'Blog Articles Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h2 class="h3 fw-bold text-white mb-1">Blog Stories &amp; Articles Management</h2>
        <p class="text-secondary mb-0" style="font-size:0.9rem;">Create, edit, and publish culinary stories, recipe insights, and restaurant news on your website.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('blog') }}" target="_blank" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-1">
            <i class="fas fa-external-link-alt"></i> View Live Blog
        </a>
        <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">
            <i class="fas fa-plus-circle me-1"></i> Add New Blog Article
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

<!-- ========================================================
     BLOG ARTICLES GRID
     ======================================================== -->
<div class="row g-4">
    @forelse($blogs as $blog)
        <div class="col-md-6 col-xl-4">
            <div class="admin-card h-100 d-flex flex-column justify-content-between shadow-sm">
                <div>
                    <!-- Article Image Banner -->
                    <div class="position-relative mb-3 rounded-3 overflow-hidden" style="background:#090d16;border:1px solid #334155;">
                        <img src="{{ asset($blog['image'] ?? 'img/blog/1.jpg') }}" class="w-100" style="height:200px;object-fit:cover;" alt="{{ $blog['title'] }}" onerror="this.src='{{ asset('img/blog/1.jpg') }}'"/>
                        <div class="position-absolute top-0 start-0 m-2 bg-danger text-white px-2 py-1 rounded text-center" style="font-size:0.75rem;line-height:1.2;font-weight:700;">
                            <div>{{ $blog['day'] ?? '15' }}</div>
                            <div class="text-uppercase" style="font-size:0.65rem;">{{ $blog['month'] ?? 'Oct' }}</div>
                        </div>
                        <span class="badge bg-dark bg-opacity-75 border border-secondary text-warning position-absolute top-0 end-0 m-2 px-2 py-1" style="font-size:0.75rem;">
                            {{ $blog['category'] ?? 'General' }}
                        </span>
                    </div>

                    <!-- Meta info -->
                    <div class="d-flex align-items-center gap-3 text-secondary small mb-2">
                        <span><i class="fas fa-user text-danger me-1"></i>{{ $blog['author'] ?? 'Author' }}</span>
                        <span><i class="fas fa-comment text-warning me-1"></i>{{ $blog['comments'] ?? 0 }} Comments</span>
                    </div>

                    <!-- Title -->
                    <h5 class="text-white fw-bold mb-2" style="font-size:1.05rem;line-height:1.4;">
                        {{ $blog['title'] }}
                    </h5>

                    <!-- Excerpt -->
                    <p class="text-light small mb-3" style="line-height:1.55;font-size:0.86rem;opacity:0.85;">
                        {{ Str::limit($blog['excerpt'] ?? '', 120) }}
                    </p>
                </div>

                <!-- Footer Actions -->
                <div class="pt-3 border-top border-secondary border-opacity-50 d-flex justify-content-between align-items-center mt-2">
                    <a href="{{ route('blog.detail', $blog['id']) }}" target="_blank" class="btn btn-sm btn-dark border border-secondary text-info px-2" title="Preview on live site">
                        <i class="fas fa-external-link-alt me-1"></i> View
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-dark border border-secondary text-warning px-3" data-bs-toggle="modal" data-bs-target="#editBlogModal{{ $blog['id'] }}">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.blog.delete', $blog['id']) }}" method="POST" onsubmit="return confirm('Delete this blog article: {{ addslashes($blog['title']) }}?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Delete Article">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================
             EDIT BLOG ARTICLE MODAL
             ======================================================== -->
        <div class="modal fade" id="editBlogModal{{ $blog['id'] }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark border-secondary text-light shadow-lg">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-edit text-warning me-2"></i>Edit Article: {{ Str::limit($blog['title'], 40) }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.blog.update', $blog['id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label-admin">Article Title *</label>
                                <input type="text" name="title" class="form-control form-control-admin" value="{{ $blog['title'] }}" required />
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label-admin">Category *</label>
                                    <input type="text" name="category" class="form-control form-control-admin" value="{{ $blog['category'] ?? 'Culinary Science' }}" required placeholder="e.g. Food & Health, Recipes" />
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label-admin">Author *</label>
                                    <input type="text" name="author" class="form-control form-control-admin" value="{{ $blog['author'] ?? 'Executive Chef' }}" required />
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-sm-4">
                                    <label class="form-label-admin">Day (e.g. 15)</label>
                                    <input type="text" name="day" class="form-control form-control-admin" value="{{ $blog['day'] ?? date('d') }}" />
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label-admin">Month (e.g. Oct)</label>
                                    <input type="text" name="month" class="form-control form-control-admin" value="{{ $blog['month'] ?? date('M') }}" />
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label-admin">Comment Count</label>
                                    <input type="number" name="comments" class="form-control form-control-admin" value="{{ $blog['comments'] ?? 0 }}" min="0" />
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label-admin">Select Preset Image</label>
                                    <select name="image" class="form-control form-control-admin">
                                        <option value="img/blog/1.jpg" {{ ($blog['image'] ?? '') == 'img/blog/1.jpg' ? 'selected' : '' }}>Blog Image 1 (Healthy Fast Food)</option>
                                        <option value="img/blog/2.jpg" {{ ($blog['image'] ?? '') == 'img/blog/2.jpg' ? 'selected' : '' }}>Blog Image 2 (Kitchen & Cooking)</option>
                                        <option value="img/blog/3.jpg" {{ ($blog['image'] ?? '') == 'img/blog/3.jpg' ? 'selected' : '' }}>Blog Image 3 (Burger & Fresh Bun)</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label-admin">Or Upload New Image</label>
                                    <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-admin">Short Excerpt / Summary *</label>
                                <textarea name="excerpt" class="form-control form-control-admin" rows="3" required placeholder="A brief 1-2 sentence teaser for cards...">{{ $blog['excerpt'] ?? '' }}</textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label-admin">Full Article Content *</label>
                                <textarea name="content" class="form-control form-control-admin" rows="6" required placeholder="Write the complete article content here...">{{ $blog['content'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-admin-primary">
                                <i class="fas fa-save me-1"></i> Update Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-newspaper fa-2x mb-3 text-secondary"></i>
            <p>No blog articles published yet. Click <strong>Add New Blog Article</strong> above to create your first story!</p>
        </div>
    @endforelse
</div>

<!-- ========================================================
     ADD NEW BLOG ARTICLE MODAL
     ======================================================== -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary text-light shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white">
                    <i class="fas fa-plus-circle text-warning me-2"></i>Publish New Blog Article
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-admin">Article Title *</label>
                        <input type="text" name="title" class="form-control form-control-admin" placeholder="e.g. The Secret to our 100% Grass-Fed Smash Burgers" required value="{{ old('title') }}" />
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label-admin">Category *</label>
                            <select name="category" class="form-control form-control-admin" required>
                                <option value="Food & Health">Food &amp; Health</option>
                                <option value="Culinary Science" selected>Culinary Science</option>
                                <option value="Recipes & Tips">Recipes &amp; Tips</option>
                                <option value="Chef Specials">Chef Specials</option>
                                <option value="Behind the Scenes">Behind the Scenes</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Author *</label>
                            <input type="text" name="author" class="form-control form-control-admin" placeholder="e.g. Chef Marcus Vance" required value="{{ old('author', 'Executive Chef') }}" />
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-4">
                            <label class="form-label-admin">Day</label>
                            <input type="text" name="day" class="form-control form-control-admin" value="{{ old('day', date('d')) }}" />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-admin">Month</label>
                            <input type="text" name="month" class="form-control form-control-admin" value="{{ old('month', date('M')) }}" />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-admin">Initial Comments</label>
                            <input type="number" name="comments" class="form-control form-control-admin" value="{{ old('comments', 0) }}" min="0" />
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label-admin">Select Preset Image</label>
                            <select name="image" class="form-control form-control-admin">
                                <option value="img/blog/1.jpg">Blog Image 1 (Healthy Fast Food)</option>
                                <option value="img/blog/2.jpg">Blog Image 2 (Kitchen & Cooking)</option>
                                <option value="img/blog/3.jpg">Blog Image 3 (Burger & Fresh Bun)</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-admin">Or Upload Custom Image</label>
                            <input type="file" name="image_file" class="form-control form-control-admin" accept="image/*" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-admin">Short Excerpt / Teaser *</label>
                        <textarea name="excerpt" class="form-control form-control-admin" rows="3" required placeholder="A short 1-2 sentence preview for the blog cards...">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-admin">Full Article Content *</label>
                        <textarea name="content" class="form-control form-control-admin" rows="6" required placeholder="Write your full story or article content here...">{{ old('content') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-admin-primary">
                        <i class="fas fa-paper-plane me-1"></i> Publish Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
