@extends('admin_new.layout.main')
@section('content')
 <!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Dashboard</h2>
    <div>
        <button class="btn btn-primary">
            <i class="bi bi-download"></i> Export Report
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Sales</h6>
                        <h3 class="mb-0">$45,231</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 12.5%</small>
                    </div>
                    <div class="stat-icon" style="background: var(--primary-gradient);">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Products</h6>
                        <h3 class="mb-0">1,234</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 8.2%</small>
                    </div>
                    <div class="stat-icon" style="background: var(--success-gradient);">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Customers</h6>
                        <h3 class="mb-0">892</h3>
                        <small class="text-danger"><i class="bi bi-arrow-down"></i> 3.1%</small>
                    </div>
                    <div class="stat-icon" style="background: var(--info-gradient);">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Orders</h6>
                        <h3 class="mb-0">456</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 18.7%</small>
                    </div>
                    <div class="stat-icon" style="background: var(--warning-gradient);">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sales Overview</h5>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Category Distribution</h5>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Top Products -->
<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Activity</h5>
                <div class="recent-activity">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>New Order</strong>
                                <p class="mb-0 text-muted">Order #1234 - $234.50</p>
                            </div>
                            <small class="text-muted">2 min ago</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Product Added</strong>
                                <p class="mb-0 text-muted">Wireless Mouse - 50 units</p>
                            </div>
                            <small class="text-muted">15 min ago</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Customer Registered</strong>
                                <p class="mb-0 text-muted">John Doe - john@example.com</p>
                            </div>
                            <small class="text-muted">1 hour ago</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Payment Received</strong>
                                <p class="mb-0 text-muted">Order #1233 - $156.00</p>
                            </div>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Top Selling Products</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Laptop Pro</td>
                                <td>$999</td>
                                <td>45</td>
                                <td>$44,955</td>
                            </tr>
                            <tr>
                                <td>Wireless Mouse</td>
                                <td>$29</td>
                                <td>120</td>
                                <td>$3,480</td>
                            </tr>
                            <tr>
                                <td>USB-C Hub</td>
                                <td>$49</td>
                                <td>89</td>
                                <td>$4,361</td>
                            </tr>
                            <tr>
                                <td>Mechanical Keyboard</td>
                                <td>$129</td>
                                <td>67</td>
                                <td>$8,643</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
