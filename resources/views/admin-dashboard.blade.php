<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-violet-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <a href="#" class="px-4 py-2 bg-white text-violet-800 rounded-lg hover:bg-gray-200">Logout</a>
        </div>
    </header>

    <!-- Search Section -->
    <section class="container mx-auto mt-8 px-4">

    </section>

    <!-- Orders Section -->
    <main class="container mx-auto mt-4 px-4 bg-white rounded-lg p-2 shadow">
        <div class="flex flex-wrap justify-between items-center">
            <h2 class="text-3xl font-bold mb-4 sm:mb-0">Orders</h2>
            <input id="search-bar" type="text" placeholder="Search orders..."
                class="w-full sm:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>
        <div id="orders-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Dummy Order Card -->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
                <!-- Header -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-violet-600">Order #1</h3>
                        <span class="text-sm bg-violet-200 text-violet-800 px-2 py-1 rounded-full">Pending</span>
                    </div>
                    <!-- Order Details -->
                    <p class="text-gray-700 mb-2"><strong>Name:</strong> John Doe</p>
                    <p class="text-gray-700 mb-2"><strong>Size:</strong> Large</p>
                    <p class="text-gray-700 mb-2"><strong>Quantity:</strong> 2</p>
                    <p class="text-gray-500 text-sm mb-4"><strong>Ordered on:</strong> 12 Nov 2024</p>
                    <p class="text-gray-500 text-sm mb-4"><strong>Total Payments:</strong> ₱1,500 / ₱3,000</p>
                </div>
                <!-- Buttons -->
                <div class="flex flex-wrap gap-2 mt-4">
                    <button onclick="openPaymentModal(1)"
                        class="flex-1 px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600 transition">
                        View Payments
                    </button>
                    <button onclick="openAddPaymentModal(1)"
                        class="flex-1 px-4 py-2 bg-yellow-500 text-white font-bold rounded-lg shadow-md hover:bg-yellow-600 transition">
                        Add Payment
                    </button>
                    <button onclick="openConfirmOrderModal(1)"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600 transition">
                        Confirm
                    </button>
                    <button onclick="openCancelOrderModal(1)"
                        class="flex-1 px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Chart Section -->
    <section class="container mx-auto mt-12 px-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Order Statistics -->
        <div>
            <h2 class="text-3xl font-bold mb-6">Order Statistics</h2>
            <div class="bg-white shadow-md rounded-lg p-6">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
        <!-- Daily Orders -->
        <div>
            <h2 class="text-3xl font-bold mb-6">Daily Orders</h2>
            <div class="bg-white shadow-md rounded-lg p-6">
                <canvas id="dailyOrdersChart"></canvas>
            </div>
        </div>
    </section>


    <!-- Modals -->
    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden px-4">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h3 class="text-xl font-bold mb-4">Payments for Order #1</h3>
            <ul id="payment-list" class="mb-4 space-y-4">
                <!-- Payment Item -->
                <li class="text-gray-700">
                    <div class="mb-2">
                        <p><strong>Payment 1:</strong> ₱1,000</p>
                        <p class="text-sm text-gray-500"><strong>Reference Number:</strong> 12345678</p>
                        <p class="text-sm text-gray-500"><strong>Date:</strong> 12 Nov 2024</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/payment1.jpg') }}" alt="Proof of Payment 1"
                            class="rounded-lg shadow-md w-full max-h-48 object-cover border border-gray-300">
                    </div>
                </li>
                <!-- Another Payment Item -->
                <li class="text-gray-700">
                    <div class="mb-2">
                        <p><strong>Payment 2:</strong> ₱500</p>
                        <p class="text-sm text-gray-500"><strong>Reference Number:</strong> 87654321</p>
                        <p class="text-sm text-gray-500"><strong>Date:</strong> 14 Nov 2024</p>
                    </div>
                    <div>
                        <img src="{{ asset('images/payment2.jpg') }}" alt="Proof of Payment 2"
                            class="rounded-lg shadow-md w-full max-h-48 object-cover border border-gray-300">
                    </div>
                </li>
            </ul>
            <button onclick="closePaymentModal()"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Close</button>
        </div>
    </div>

    <script>
        // Modal functions
        function openPaymentModal(orderId) {
            document.getElementById('payment-modal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        // Chart.js setup for orders
        const ctx1 = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Order #1', 'Order #2', 'Order #3'],
                datasets: [{
                    label: 'Payments (₱)',
                    data: [1500, 2500, 1000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        const ctx2 = document.getElementById('dailyOrdersChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['11 Nov', '12 Nov', '13 Nov', '14 Nov', '15 Nov'],
                datasets: [{
                    label: 'Daily Orders',
                    data: [5, 8, 3, 7, 10],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: true
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</body>

</html>
