@extends('admin_new.layout.main')
@section('content')
            <div class="row">
                <!-- Products Section -->
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Select Products</h5>
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                                </div>
                            </div>

                            <!-- Category Tabs -->
                            <div class="category-tabs">
                                <div class="category-tab active" data-category="all">All</div>
                                <div class="category-tab" data-category="electronics">Electronics</div>
                                <div class="category-tab" data-category="accessories">Accessories</div>
                                <div class="category-tab" data-category="software">Software</div>
                                <div class="category-tab" data-category="hardware">Hardware</div>
                            </div>

                            <!-- Products Grid -->
                            <div class="product-grid" id="productGrid">
                                <div class="product-item" onclick="addToCart('Laptop Pro', 999, 'laptop')">
                                    <img src="https://picsum.photos/seed/laptop/60/60" alt="Product">
                                    <div class="name">Laptop Pro</div>
                                    <div class="price">$999</div>
                                </div>
                                <div class="product-item" onclick="addToCart('Wireless Mouse', 29, 'mouse')">
                                    <img src="https://picsum.photos/seed/mouse/60/60" alt="Product">
                                    <div class="name">Wireless Mouse</div>
                                    <div class="price">$29</div>
                                </div>
                                <div class="product-item" onclick="addToCart('Keyboard', 129, 'keyboard')">
                                    <img src="https://picsum.photos/seed/keyboard/60/60" alt="Product">
                                    <div class="name">Keyboard</div>
                                    <div class="price">$129</div>
                                </div>
                                <div class="product-item" onclick="addToCart('Monitor', 599, 'monitor')">
                                    <img src="https://picsum.photos/seed/monitor/60/60" alt="Product">
                                    <div class="name">Monitor</div>
                                    <div class="price">$599</div>
                                </div>
                                <div class="product-item" onclick="addToCart('USB Hub', 49, 'hub')">
                                    <img src="https://picsum.photos/seed/hub/60/60" alt="Product">
                                    <div class="name">USB Hub</div>
                                    <div class="price">$49</div>
                                </div>
                                <div class="product-item" onclick="addToCart('Webcam', 79, 'webcam')">
                                    <img src="https://picsum.photos/seed/webcam/60/60" alt="Product">
                                    <div class="name">Webcam</div>
                                    <div class="price">$79</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Section -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Shopping Cart</h5>

                            <!-- Cart Items -->
                            <div id="cartItems" style="max-height: 300px; overflow-y: auto;">
                                <!-- Cart items will be added here dynamically -->
                            </div>

                            <!-- Cart Summary -->
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (10%):</span>
                                    <span id="tax">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong id="total">$0.00</strong>
                                </div>

                                <!-- Customer Info -->
                                <div class="mb-3">
                                    <label class="form-label">Customer</label>
                                    <select class="form-select" id="customerSelect">
                                        <option value="">Walk-in Customer</option>
                                        <option value="1">John Doe</option>
                                        <option value="2">Jane Smith</option>
                                    </select>
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-3">
                                    <label class="form-label">Payment Method</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="payment-method active" onclick="selectPayment('cash')">
                                                <i class="bi bi-cash"></i>
                                                <div>Cash</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="payment-method" onclick="selectPayment('card')">
                                                <i class="bi bi-credit-card"></i>
                                                <div>Card</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <button class="btn btn-gradient" onclick="processPayment()">
                                        <i class="bi bi-check-circle"></i> Complete Sale
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="clearCart()">
                                        <i class="bi bi-trash"></i> Clear Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Process Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="receipt-preview" id="receiptPreview">
                        <!-- Receipt will be generated here -->
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Amount Received</label>
                        <input type="number" class="form-control" id="amountReceived" step="0.01">
                        <div class="mt-2">
                            <strong>Change: $<span id="changeAmount">0.00</span></strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-gradient" onclick="confirmPayment()">
                        <i class="bi bi-check-circle"></i> Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let cart = [];
        let selectedPayment = 'cash';


        // Category Tabs
        $('.category-tab').click(function() {
            $('.category-tab').removeClass('active');
            $(this).addClass('active');

            const category = $(this).data('category');
            console.log('Category:', category);
        });

        // Add to Cart
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

        // Update Cart Display
        function updateCart() {
            const cartItemsDiv = $('#cartItems');
            cartItemsDiv.empty();

            if (cart.length === 0) {
                cartItemsDiv.html('<p class="text-muted text-center">Cart is empty</p>');
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
                    cartItemsDiv.append(itemHtml);
                });
            }

            updateTotals();
        }

        // Update Quantity
        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            updateCart();
        }

        // Remove from Cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        // Update Totals
        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            $('#subtotal').text(`$${subtotal.toFixed(2)}`);
            $('#tax').text(`$${tax.toFixed(2)}`);
            $('#total').text(`$${total.toFixed(2)}`);
        }

        // Clear Cart
        function clearCart() {
            if (confirm('Are you sure you want to clear the cart?')) {
                cart = [];
                updateCart();
            }
        }

        // Select Payment Method
        function selectPayment(method) {
            selectedPayment = method;
            $('.payment-method').removeClass('active');
            $(`.payment-method:contains('${method}')`).addClass('active');
        }

        // Process Payment
        function processPayment() {
            if (cart.length === 0) {
                alert('Cart is empty!');
                return;
            }

            generateReceipt();
            $('#paymentModal').modal('show');
        }

        // Generate Receipt
        function generateReceipt() {
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

            $('#receiptPreview').html(receiptHtml);
            $('#amountReceived').val(total.toFixed(2));
            calculateChange();
        }

        // Calculate Change
        function calculateChange() {
            const total = parseFloat($('#total').text().replace('$', ''));
            const received = parseFloat($('#amountReceived').val()) || 0;
            const change = received - total;
            $('#changeAmount').text(Math.max(0, change).toFixed(2));
        }

        $('#amountReceived').on('input', calculateChange);

        // Confirm Payment
        function confirmPayment() {
            alert('Payment processed successfully!');
            cart = [];
            updateCart();
            $('#paymentModal').modal('hide');
        }

        // Product Search
        $('#productSearch').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.product-item').each(function() {
                const productName = $(this).find('.name').text().toLowerCase();
                $(this).toggle(productName.includes(searchTerm));
            });
        });

        // Initialize
        updateCart();
    </script>
@endpush
