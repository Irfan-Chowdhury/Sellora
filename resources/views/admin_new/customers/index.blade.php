@extends('admin_new.layout.main')
@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Customers Management</h2>
    <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        <i class="bi bi-plus-circle"></i> Add Customer
    </button>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary">892</h3>
                <p class="mb-0">Total Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">45</h3>
                <p class="mb-0">New This Month</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">23</h3>
                <p class="mb-0">VIP Customers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">156</h3>
                <p class="mb-0">Active Today</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" id="searchInput" placeholder="Search customers...">
        </div>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="typeFilter">
            <option value="">All Types</option>
            <option value="regular">Regular</option>
            <option value="vip">VIP</option>
            <option value="new">New</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
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
    <span class="text-muted">Showing 1-12 of 892 customers</span>
</div>

<!-- Customers Grid View -->
<div class="row" id="customersGrid">
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card customer-card">
            <div class="card-body text-center">
                <img src="https://picsum.photos/seed/customer1/80/80" class="customer-avatar mb-3" alt="Customer">
                <h6 class="card-title">John Doe</h6>
                <p class="text-muted small">john.doe@example.com</p>
                <span class="customer-type type-vip">VIP</span>
                <div class="customer-stats">
                    <div class="stat-item">
                        <div class="stat-value">45</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">$5.2k</div>
                        <div class="stat-label">Spent</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card customer-card">
            <div class="card-body text-center">
                <img src="https://picsum.photos/seed/customer2/80/80" class="customer-avatar mb-3" alt="Customer">
                <h6 class="card-title">Jane Smith</h6>
                <p class="text-muted small">jane.smith@example.com</p>
                <span class="customer-type type-regular">Regular</span>
                <div class="customer-stats">
                    <div class="stat-item">
                        <div class="stat-value">23</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">$2.1k</div>
                        <div class="stat-label">Spent</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card customer-card">
            <div class="card-body text-center">
                <img src="https://picsum.photos/seed/customer3/80/80" class="customer-avatar mb-3" alt="Customer">
                <h6 class="card-title">Mike Johnson</h6>
                <p class="text-muted small">mike.j@example.com</p>
                <span class="customer-type type-new">New</span>
                <div class="customer-stats">
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">$450</div>
                        <div class="stat-label">Spent</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card customer-card">
            <div class="card-body text-center">
                <img src="https://picsum.photos/seed/customer4/80/80" class="customer-avatar mb-3" alt="Customer">
                <h6 class="card-title">Sarah Williams</h6>
                <p class="text-muted small">sarah.w@example.com</p>
                <span class="customer-type type-vip">VIP</span>
                <div class="customer-stats">
                    <div class="stat-item">
                        <div class="stat-value">67</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">$8.9k</div>
                        <div class="stat-label">Spent</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customers List View (Hidden by default) -->
<div class="table-responsive" id="customersList" style="display: none;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Type</th>
                <th>Orders</th>
                <th>Total Spent</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/customer1/40/40" class="rounded-circle me-2" alt="Customer">
                        <span>John Doe</span>
                    </div>
                </td>
                <td>john.doe@example.com</td>
                <td>+1 234-567-8900</td>
                <td><span class="customer-type type-vip">VIP</span></td>
                <td>45</td>
                <td>$5,234</td>
                <td><span class="badge bg-success">Active</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="editCustomer(1)"><i class="bi bi-pencil"></i></button>
                        <button class="btn-delete" onclick="deleteCustomer(1)"><i class="bi bi-trash"></i></button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/customer2/40/40" class="rounded-circle me-2" alt="Customer">
                        <span>Jane Smith</span>
                    </div>
                </td>
                <td>jane.smith@example.com</td>
                <td>+1 234-567-8901</td>
                <td><span class="customer-type type-regular">Regular</span></td>
                <td>23</td>
                <td>$2,156</td>
                <td><span class="badge bg-success">Active</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-edit" onclick="editCustomer(2)"><i class="bi bi-pencil"></i></button>
                        <button class="btn-delete" onclick="deleteCustomer(2)"><i class="bi bi-trash"></i></button>
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

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCustomerForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer Type</label>
                            <select class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="regular">Regular</option>
                                <option value="vip">VIP</option>
                                <option value="new">New</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gradient" onclick="saveCustomer()">Save Customer</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="editPhone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer Type</label>
                            <select class="form-select" id="editType" required>
                                <option value="">Select Type</option>
                                <option value="regular">Regular</option>
                                <option value="vip">VIP</option>
                                <option value="new">New</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editStatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="editNotes" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gradient" onclick="updateCustomer()">Update Customer</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        // View Toggle
        $('#gridView').click(function() {
            $('#customersGrid').show();
            $('#customersList').hide();
            $(this).addClass('active');
            $('#listView').removeClass('active');
        });

        $('#listView').click(function() {
            $('#customersGrid').hide();
            $('#customersList').show();
            $(this).addClass('active');
            $('#gridView').removeClass('active');
        });

        // Search functionality
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            console.log('Search:', searchTerm);
        });

        // Filter functionality
        $('#typeFilter, #statusFilter').change(function() {
            const type = $('#typeFilter').val();
            const status = $('#statusFilter').val();
            console.log('Filters:', { type, status });
        });

        // Customer functions
        function saveCustomer() {
            alert('Customer saved successfully!');
            $('#addCustomerModal').modal('hide');
        }

        function editCustomer(id) {
            $('#editCustomerModal').modal('show');
        }

        function updateCustomer() {
            alert('Customer updated successfully!');
            $('#editCustomerModal').modal('hide');
        }

        function deleteCustomer(id) {
            if (confirm('Are you sure you want to delete this customer?')) {
                alert('Customer deleted successfully!');
            }
        }

        // Form validation
        $('#addCustomerForm, #editCustomerForm').on('submit', function(e) {
            e.preventDefault();
        });
    </script>
@endpush
