/* ============================================
   INVENTORY POS - COMPLETE JAVASCRIPT
   ============================================ */

// Global Variables
let cart = [];
let selectedPayment = 'cash';
let charts = {};

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Initialize Application
function initializeApp() {
    initializeTheme();
    initializeSidebar();
    initializePageSpecific();
    initializeEventListeners();
}

// Theme Management
function initializeTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-theme', savedTheme);

    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const icon = savedTheme === 'dark' ? 'bi-sun-fill' : 'bi-moon-fill';
        themeToggle.innerHTML = `<i class="bi ${icon}"></i>`;
    }

    // Dark mode switch in settings
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    if (darkModeSwitch) {
        darkModeSwitch.checked = savedTheme === 'dark';
    }
}

// Sidebar Management
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            toggleSidebar();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function() {
            closeMobileSidebar();
        });
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        handleResize();
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const overlay = document.getElementById('sidebarOverlay');

    if (window.innerWidth <= 768) {
        // Mobile behavior
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    } else {
        // Desktop behavior
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    }
}

function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}

function handleResize() {
    if (window.innerWidth > 768) {
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebar');

        if (overlay) overlay.classList.remove('show');
        if (sidebar) sidebar.classList.remove('show');
    }
}

// Theme Toggle
function toggleTheme() {
    const currentTheme = document.body.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';

    document.body.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);

    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        const icon = newTheme === 'dark' ? 'bi-sun-fill' : 'bi-moon-fill';
        themeToggle.innerHTML = `<i class="bi ${icon}"></i>`;
    }

    // Update dark mode switch
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    if (darkModeSwitch) {
        darkModeSwitch.checked = newTheme === 'dark';
    }
}

// Page Specific Initialization
function initializePageSpecific() {
    const currentPath = window.location.pathname;
    const pageName = currentPath.split('/').pop() || 'index.html';

    switch(pageName) {
        case 'index.html':
        case '':
            initializeDashboard();
            break;
        case 'products.html':
            initializeProducts();
            break;
        case 'pos.html':
            initializePOS();
            break;
        case 'customers.html':
            initializeCustomers();
            break;
        case 'reports.html':
            initializeReports();
            break;
        case 'settings.html':
            initializeSettings();
            break;
    }
}

// Dashboard Functions
function initializeDashboard() {
    initializeSalesChart();
    initializeCategoryChart();
}

function initializeSalesChart() {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    charts.sales = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Sales',
                data: [12000, 19000, 15000, 25000, 22000, 30000],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Profit',
                data: [8000, 12000, 10000, 18000, 15000, 22000],
                borderColor: '#f093fb',
                backgroundColor: 'rgba(240, 147, 251, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

function initializeCategoryChart() {
    const ctx = document.getElementById('categoryChart');
    if (!ctx) return;

    charts.category = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Electronics', 'Accessories', 'Software', 'Hardware'],
            datasets: [{
                data: [35, 25, 20, 20],
                backgroundColor: [
                    '#667eea',
                    '#f093fb',
                    '#13B497',
                    '#4facfe'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Products Functions
function initializeProducts() {
    initializeProductFilters();
    initializeProductSearch();
    initializeViewToggle();
}

function initializeProductFilters() {
    // Filter pills
    const filterPills = document.querySelectorAll('.filter-pill');
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            console.log('Filter:', filter);
            // Implement filter logic here
        });
    });

    // Category filter
    const categoryFilter = document.getElementById('categoryFilter');
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function() {
            console.log('Category:', this.value);
            // Implement category filter logic here
        });
    }
}

function initializeProductSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Search:', searchTerm);
            // Implement search logic here
        });
    }
}

function initializeViewToggle() {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const productsGrid = document.getElementById('productsGrid');
    const productsList = document.getElementById('productsList');

    if (gridView && listView) {
        gridView.addEventListener('click', function() {
            if (productsGrid) productsGrid.style.display = 'flex';
            if (productsList) productsList.style.display = 'none';
            this.classList.add('active');
            listView.classList.remove('active');
        });

        listView.addEventListener('click', function() {
            if (productsGrid) productsGrid.style.display = 'none';
            if (productsList) productsList.style.display = 'block';
            this.classList.add('active');
            gridView.classList.remove('active');
        });
    }
}

// POS Functions
function initializePOS() {
    initializeCategoryTabs();
    initializeProductSearch();
    initializePaymentMethods();
    updateCart();
}

function initializeCategoryTabs() {
    const categoryTabs = document.querySelectorAll('.category-tab');
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const category = this.getAttribute('data-category');
            console.log('Category:', category);
            // Implement category filter logic here
        });
    });
}

function initializePaymentMethods() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            paymentMethods.forEach(m => m.classList.remove('active'));
            this.classList.add('active');
            selectedPayment = this.getAttribute('onclick').match(/'(\w+)'/)[1];
        });
    });
}

// Cart Functions
function addToCart(name, price, image) {
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
    }

    updateCart();
}

function updateCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    if (!cartItemsDiv) return;

    cartItemsDiv.innerHTML = '';

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-muted text-center">Cart is empty</p>';
    } else {
        cart.forEach((item, index) => {
            const itemHtml = `
                <div class="cart-item">
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/${item.image}/40/40" alt="${item.name}">
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">${item.name}</div>
                            <div class="text-muted">$${item.price.toFixed(2)}</div>
                        </div>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                        <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            cartItemsDiv.innerHTML += itemHtml;
        });
    }

    updateTotals();
}

function updateQuantity(index, change) {
    if (cart[index]) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCart();
    }
}

function removeFromCart(index) {
    if (cart[index]) {
        cart.splice(index, 1);
        updateCart();
    }
}

function updateTotals() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total');

    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    if (taxEl) taxEl.textContent = `$${tax.toFixed(2)}`;
    if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;
}

function clearCart() {
    if (confirm('Are you sure you want to clear the cart?')) {
        cart = [];
        updateCart();
    }
}

// Payment Functions
function processPayment() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }

    generateReceipt();
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    modal.show();
}

function generateReceipt() {
    const receiptPreview = document.getElementById('receiptPreview');
    if (!receiptPreview) return;

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    let receiptHtml = `
        <div style="text-align: center;">
            <h4>INVENTORY POS</h4>
            <p>123 Main Street<br>City, State 12345<br>Tel: (555) 123-4567</p>
            <hr>
            <p>Date: ${new Date().toLocaleDateString()}<br>Time: ${new Date().toLocaleTimeString()}</p>
            <hr>
    `;

    cart.forEach(item => {
        receiptHtml += `
            <div style="display: flex; justify-content: space-between;">
                <span>${item.name} x${item.quantity}</span>
                <span>$${(item.price * item.quantity).toFixed(2)}</span>
            </div>
        `;
    });

    receiptHtml += `
            <hr>
            <div style="display: flex; justify-content: space-between;">
                <strong>Subtotal:</strong>
                <span>$${subtotal.toFixed(2)}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <strong>Tax:</strong>
                <span>$${tax.toFixed(2)}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <strong>Total:</strong>
                <span>$${total.toFixed(2)}</span>
            </div>
            <hr>
            <p>Payment Method: ${selectedPayment.toUpperCase()}</p>
            <p>Thank you for your purchase!</p>
        </div>
    `;

    receiptPreview.innerHTML = receiptHtml;

    const amountReceived = document.getElementById('amountReceived');
    if (amountReceived) {
        amountReceived.value = total.toFixed(2);
        calculateChange();
    }
}

function calculateChange() {
    const totalEl = document.getElementById('total');
    const amountReceivedEl = document.getElementById('amountReceived');
    const changeAmountEl = document.getElementById('changeAmount');

    if (!totalEl || !amountReceivedEl || !changeAmountEl) return;

    const total = parseFloat(totalEl.textContent.replace('$', ''));
    const received = parseFloat(amountReceivedEl.value) || 0;
    const change = received - total;
    changeAmountEl.textContent = Math.max(0, change).toFixed(2);
}

function confirmPayment() {
    alert('Payment processed successfully!');
    cart = [];
    updateCart();

    const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
    if (modal) modal.hide();
}

// Customers Functions
function initializeCustomers() {
    initializeCustomerFilters();
    initializeCustomerViewToggle();
}

function initializeCustomerFilters() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Customer Search:', searchTerm);
            // Implement search logic here
        });
    }

    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');

    if (typeFilter) {
        typeFilter.addEventListener('change', function() {
            console.log('Type Filter:', this.value);
            // Implement filter logic here
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            console.log('Status Filter:', this.value);
            // Implement filter logic here
        });
    }
}

function initializeCustomerViewToggle() {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const customersGrid = document.getElementById('customersGrid');
    const customersList = document.getElementById('customersList');

    if (gridView && listView) {
        gridView.addEventListener('click', function() {
            if (customersGrid) customersGrid.style.display = 'flex';
            if (customersList) customersList.style.display = 'none';
            this.classList.add('active');
            listView.classList.remove('active');
        });

        listView.addEventListener('click', function() {
            if (customersGrid) customersGrid.style.display = 'none';
            if (customersList) customersList.style.display = 'block';
            this.classList.add('active');
            gridView.classList.remove('active');
        });
    }
}

// Reports Functions
function initializeReports() {
    initializeReportCharts();
    initializeReportFilters();
    setDefaultDates();
}

function initializeReportCharts() {
    // Sales Trend Chart
    const salesTrendCtx = document.getElementById('salesTrendChart');
    if (salesTrendCtx) {
        charts.salesTrend = new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 38000, 42000, 45000],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Profit',
                    data: [8000, 12000, 10000, 18000, 15000, 22000, 20000, 25000, 23000, 27000, 30000, 32000],
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Top Products Chart
    const topProductsCtx = document.getElementById('topProductsChart');
    if (topProductsCtx) {
        charts.topProducts = new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: ['Laptop', 'Monitor', 'Keyboard', 'Mouse', 'Webcam'],
                datasets: [{
                    label: 'Units Sold',
                    data: [45, 67, 89, 120, 56],
                    backgroundColor: [
                        '#667eea',
                        '#f093fb',
                        '#13B497',
                        '#4facfe',
                        '#fa709a'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Category Revenue Chart
    const categoryRevenueCtx = document.getElementById('categoryRevenueChart');
    if (categoryRevenueCtx) {
        charts.categoryRevenue = new Chart(categoryRevenueCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Accessories', 'Software', 'Hardware'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#667eea',
                        '#f093fb',
                        '#13B497',
                        '#4facfe'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Monthly Comparison Chart
    const monthlyComparisonCtx = document.getElementById('monthlyComparisonChart');
    if (monthlyComparisonCtx) {
        charts.monthlyComparison = new Chart(monthlyComparisonCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'This Year',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    backgroundColor: '#667eea',
                    borderWidth: 0
                }, {
                    label: 'Last Year',
                    data: [10000, 15000, 13000, 20000, 18000, 25000],
                    backgroundColor: '#f093fb',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
}

function initializeReportFilters() {
    const reportType = document.getElementById('reportType');
    if (reportType) {
        reportType.addEventListener('change', function() {
            console.log('Report type changed to:', this.value);
            // Implement report type change logic here
        });
    }
}

function setDefaultDates() {
    const endDate = document.getElementById('endDate');
    const startDate = document.getElementById('startDate');

    if (endDate && startDate) {
        const today = new Date().toISOString().split('T')[0];
        endDate.value = today;

        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        startDate.value = lastMonth.toISOString().split('T')[0];
    }
}

function applyDateFilter() {
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const reportType = document.getElementById('reportType');

    if (startDate && endDate && reportType) {
        console.log('Applying filter:', {
            startDate: startDate.value,
            endDate: endDate.value,
            reportType: reportType.value
        });
        // Implement filter logic here
    }
}

function exportReport(format) {
    alert(`Exporting report as ${format.toUpperCase()}...`);
    // Implement export logic here
}

// Settings Functions
function initializeSettings() {
    initializeSettingsTabs();
    initializeDarkModeSwitch();
}

function initializeSettingsTabs() {
    // Tabs are handled by Bootstrap automatically
    console.log('Settings tabs initialized');
}

function initializeDarkModeSwitch() {
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    if (darkModeSwitch) {
        darkModeSwitch.addEventListener('change', function() {
            const isDark = this.checked;
            const newTheme = isDark ? 'dark' : 'light';

            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                const icon = newTheme === 'dark' ? 'bi-sun-fill' : 'bi-moon-fill';
                themeToggle.innerHTML = `<i class="bi ${icon}"></i>`;
            }
        });
    }
}

function saveAllSettings() {
    alert('All settings have been saved successfully!');
    // Implement save logic here
}

function addUser() {
    alert('User added successfully!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
    if (modal) modal.hide();
    // Implement add user logic here
}

function testEmailSettings() {
    alert('Test email sent successfully!');
    // Implement test email logic here
}

function createBackup() {
    alert('Backup created successfully!');
    // Implement backup logic here
}

function restoreBackup() {
    alert('Backup restored successfully!');
    // Implement restore logic here
}

function copyApiKey() {
    const apiKeyInput = document.querySelector('input[value="sk_test_4242424242424242"]');
    if (apiKeyInput) {
        apiKeyInput.select();
        document.execCommand('copy');
        alert('API Key copied to clipboard!');
    }
}

function regenerateApiKey() {
    if (confirm('Are you sure you want to regenerate the API key? This will invalidate the current key.')) {
        alert('New API key generated successfully!');
        // Implement regenerate logic here
    }
}

function openApiDocs() {
    window.open('#', '_blank');
}

// Product Management Functions
function saveProduct() {
    alert('Product saved successfully!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
    if (modal) modal.hide();
    // Implement save logic here
}

function editProduct(id) {
    console.log('Editing product:', id);
    const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    if (modal) modal.show();
    // Implement edit logic here
}

function updateProduct() {
    alert('Product updated successfully!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
    if (modal) modal.hide();
    // Implement update logic here
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        alert('Product deleted successfully!');
        // Implement delete logic here
    }
}

// Customer Management Functions
function saveCustomer() {
    alert('Customer saved successfully!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
    if (modal) modal.hide();
    // Implement save logic here
}

function editCustomer(id) {
    console.log('Editing customer:', id);
    const modal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
    if (modal) modal.show();
    // Implement edit logic here
}

function updateCustomer() {
    alert('Customer updated successfully!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('editCustomerModal'));
    if (modal) modal.hide();
    // Implement update logic here
}

function deleteCustomer(id) {
    if (confirm('Are you sure you want to delete this customer?')) {
        alert('Customer deleted successfully!');
        // Implement delete logic here
    }
}

// Event Listeners
function initializeEventListeners() {
    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }

    // Amount received input for change calculation
    const amountReceived = document.getElementById('amountReceived');
    if (amountReceived) {
        amountReceived.addEventListener('input', calculateChange);
    }

    // Form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Handle form submission based on form ID or class
            console.log('Form submitted:', form.id || form.className);
        });
    });

    // Loading simulation
    window.addEventListener('load', function() {
        const loadingSpinner = document.querySelector('.loading-spinner');
        if (loadingSpinner) {
            loadingSpinner.style.display = 'none';
        }
    });

    // Add click animations to cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.add('pulse');
            setTimeout(() => {
                this.classList.remove('pulse');
            }, 1000);
        });
    });
}

// Utility Functions
function showModal(modalId) {
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
}

function hideModal(modalId) {
    const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    if (modal) modal.hide();
}

function showNotification(message, type = 'success') {
    // Create a simple notification (you can enhance this)
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
    notification.style.zIndex = '9999';
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('en-US').format(date);
}

// Export functions for global access
window.InventoryPOS = {
    cart,
    selectedPayment,
    charts,
    toggleTheme,
    toggleSidebar,
    addToCart,
    updateCart,
    clearCart,
    processPayment,
    confirmPayment,
    saveProduct,
    editProduct,
    updateProduct,
    deleteProduct,
    saveCustomer,
    editCustomer,
    updateCustomer,
    deleteCustomer,
    exportReport,
    applyDateFilter,
    saveAllSettings,
    addUser,
    testEmailSettings,
    createBackup,
    restoreBackup,
    copyApiKey,
    regenerateApiKey,
    openApiDocs,
    showModal,
    hideModal,
    showNotification,
    formatCurrency,
    formatDate
};
