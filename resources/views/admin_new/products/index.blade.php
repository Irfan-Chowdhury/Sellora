@extends('admin_new.layout.main')
@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Products Management</h2>
    <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addProductModal">
        <i class="bi bi-plus-circle"></i> Add Product
    </button>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" id="searchInput" placeholder="Search products...">
        </div>
    </div>
    <div class="col-md-6">
        <select class="form-select" id="categoryFilter">
            <option value="">All Categories</option>
            <option value="electronics">Electronics</option>
            <option value="accessories">Accessories</option>
            <option value="software">Software</option>
            <option value="hardware">Hardware</option>
        </select>
    </div>
</div>

<!-- Filter Pills -->
<div class="filter-pills">
    <div class="filter-pill active" data-filter="all">All Products</div>
    <div class="filter-pill" data-filter="instock">In Stock</div>
    <div class="filter-pill" data-filter="lowstock">Low Stock</div>
    <div class="filter-pill" data-filter="outofstock">Out of Stock</div>
</div>

<!-- View Toggle -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary active" id="gridView">
            <i class="bi bi-grid-3x3-gap"></i>
        </button>
        <button type="button" class="btn btn-outline-primary" id="listView">
            <i class="bi bi-list-ul"></i>
        </button>
    </div>
    <span class="text-muted">Showing 1-12 of 234 products</span>
</div>

<!-- Products Grid View -->
<div class="row" id="productsGrid">
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product-card">
            <div class="position-relative">
                <img src="https://picsum.photos/seed/laptop/300/200" class="card-img-top product-image" alt="Product">
                <span class="stock-badge stock-good">In Stock</span>
            </div>
            <div class="card-body">
                <h6 class="card-title">Laptop Pro 15"</h6>
                <p class="text-muted small">Electronics</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">$999</h5>
                    <small class="text-muted">45 units</small>
                </div>
                <div class="mt-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 45%; background: var(--success-gradient);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product-card">
            <div class="position-relative">
                <img src="https://picsum.photos/seed/mouse/300/200" class="card-img-top product-image" alt="Product">
                <span class="stock-badge stock-low">Low Stock</span>
            </div>
            <div class="card-body">
                <h6 class="card-title">Wireless Mouse</h6>
                <p class="text-muted small">Accessories</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">$29</h5>
                    <small class="text-muted">8 units</small>
                </div>
                <div class="mt-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 8%; background: var(--warning-gradient);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product-card">
            <div class="position-relative">
                <img src="https://picsum.photos/seed/keyboard/300/200" class="card-img-top product-image" alt="Product">
                <span class="stock-badge stock-out">Out of Stock</span>
            </div>
            <div class="card-body">
                <h6 class="card-title">Mechanical Keyboard</h6>
                <p class="text-muted small">Accessories</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">$129</h5>
                    <small class="text-muted">0 units</small>
                </div>
                <div class="mt-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 0%; background: var(--secondary-gradient);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product-card">
            <div class="position-relative">
                <img src="https://picsum.photos/seed/monitor/300/200" class="card-img-top product-image" alt="Product">
                <span class="stock-badge stock-good">In Stock</span>
            </div>
            <div class="card-body">
                <h6 class="card-title">4K Monitor 27"</h6>
                <p class="text-muted small">Electronics</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">$599</h5>
                    <small class="text-muted">23 units</small>
                </div>
                <div class="mt-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 23%; background: var(--success-gradient);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products List View (Hidden by default) -->
<div class="table-responsive" id="productsList" style="display: none;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="https://picsum.photos/seed/laptop/50/50" class="rounded" alt="Product"></td>
                <td>Laptop Pro 15"</td>
                <td>Electronics</td>
                <td>$999</td>
                <td>45</td>
                <td><span class="badge bg-success">In Stock</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="editProduct(1)"><i class="bi bi-pencil"></i></button>
                        <button class="btn-delete" onclick="deleteProduct(1)"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td><img src="https://picsum.photos/seed/mouse/50/50" class="rounded" alt="Product"></td>
                <td>Wireless Mouse</td>
                <td>Accessories</td>
                <td>$29</td>
                <td>8</td>
                <td><span class="badge bg-warning">Low Stock</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="editProduct(2)"><i class="bi bi-pencil"></i></button>
                        <button class="btn-delete" onclick="deleteProduct(2)"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>


<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" required>
                                <option value="">Select Category</option>
                                <option>Electronics</option>
                                <option>Accessories</option>
                                <option>Software</option>
                                <option>Hardware</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gradient" onclick="saveProduct()">Save Product</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" class="form-control" id="editProductSku" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="editProductCategory" required>
                                <option value="">Select Category</option>
                                <option>Electronics</option>
                                <option>Accessories</option>
                                <option>Software</option>
                                <option>Hardware</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control" id="editProductBrand" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" id="editProductPrice" step="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost</label>
                            <input type="number" class="form-control" id="editProductCost" step="0.01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="editProductStock" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="editProductDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gradient" onclick="updateProduct()">Update Product</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        // View Toggle
        $('#gridView').click(function() {
            $('#productsGrid').show();
            $('#productsList').hide();
            $(this).addClass('active');
            $('#listView').removeClass('active');
        });

        $('#listView').click(function() {
            $('#productsGrid').hide();
            $('#productsList').show();
            $(this).addClass('active');
            $('#gridView').removeClass('active');
        });

        // Filter Pills
        $('.filter-pill').click(function() {
            $('.filter-pill').removeClass('active');
            $(this).addClass('active');

            const filter = $(this).data('filter');
            console.log('Filter:', filter);
        });

        // Search functionality
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            console.log('Search:', searchTerm);
        });

        // Category filter
        $('#categoryFilter').change(function() {
            const category = $(this).val();
            console.log('Category:', category);
        });

        // Product functions
        function saveProduct() {
            alert('Product saved successfully!');
            $('#addProductModal').modal('hide');
        }

        function editProduct(id) {
            $('#editProductModal').modal('show');
        }

        function updateProduct() {
            alert('Product updated successfully!');
            $('#editProductModal').modal('hide');
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                alert('Product deleted successfully!');
            }
        }

        // Form validation
        $('#addProductForm, #editProductForm').on('submit', function(e) {
            e.preventDefault();
        });
    </script>

@endpush
