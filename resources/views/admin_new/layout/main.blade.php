<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory POS - Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style_new.css') }}">

</head>
<body data-theme="light">
    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div class="overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    @include('admin_new.layout.partials.navbar')

    <!-- Sidebar -->
    @include('admin_new.layout.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="content-wrapper">
           @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Sidebar Toggle
        $('#sidebarToggle').click(function() {
            const sidebar = $('#sidebar');
            const mainContent = $('#mainContent');
            const overlay = $('#sidebarOverlay');

            if (window.innerWidth <= 768) {
                // Mobile behavior
                sidebar.toggleClass('show');
                overlay.toggleClass('show');
            } else {
                // Desktop behavior
                sidebar.toggleClass('collapsed');
                mainContent.toggleClass('expanded');
            }
        });

        // Close sidebar when clicking overlay on mobile
        $('#sidebarOverlay').click(function() {
            $('#sidebar').removeClass('show');
            $(this).removeClass('show');
        });

        // Handle window resize
        $(window).resize(function() {
            if (window.innerWidth > 768) {
                $('#sidebarOverlay').removeClass('show');
                $('#sidebar').removeClass('show');
            }
        });

        // Theme Toggle
        $('#themeToggle').click(function() {
            const currentTheme = $('body').attr('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            $('body').attr('data-theme', newTheme);

            const icon = newTheme === 'dark' ? 'bi-sun-fill' : 'bi-moon-fill';
            $(this).html(`<i class="bi ${icon}"></i>`);

            localStorage.setItem('theme', newTheme);
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        $('body').attr('data-theme', savedTheme);
        if (savedTheme === 'dark') {
            $('#themeToggle').html('<i class="bi bi-sun-fill"></i>');
        }

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
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

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
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

        // Simulate loading
        $(window).on('load', function() {
            $('.loading-spinner').fadeOut();
        });

        // Add click animation to cards
        $('.stat-card').click(function() {
            $(this).addClass('animate__animated animate__pulse');
            setTimeout(() => {
                $(this).removeClass('animate__animated animate__pulse');
            }, 1000);
        });
    </script>
    @stack('scripts')
</body>
</html>
