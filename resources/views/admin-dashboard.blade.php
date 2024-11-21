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
            <a href="{{route('logout')}}" class="px-4 py-2 bg-white text-violet-800 rounded-lg hover:bg-gray-200">Logout</a>
        </div>
    </header>

    <!-- Orders Section -->
    <main class="container mx-auto mt-4 px-4 bg-white rounded-lg p-4 shadow">
        <h2 class="text-3xl font-bold mb-6">Orders</h2>
        <button onclick="window.location.href='{{ route('orders.download-all') }}'"
            class="px-6 py-3 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600 transition">
            Download All Orders (PDF)
        </button>

        <div id="orders-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($orders as $order)
                <div class="bg-gray-50 shadow-md rounded-lg p-6 flex flex-col space-y-4">
                    <!-- Order Details -->
                    <div class="text-gray-700">
                        <h3 class="text-xl font-bold text-violet-600">Order #{{ $order->id }}</h3>
                        <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                        <p><strong>Jersey Name:</strong>{{$order->jersey_name ?? 'N/A'}}</p>
                        <p><strong>Size:</strong> {{ $order->size }}</p>
                        <p><strong>Jersey Number:</strong> {{ $order->jersey_number }}</p>
                        <p><strong>Remarks:</strong> {{ $order->remarks ?? 'No remarks' }}</p>
                        <p class="text-sm text-gray-500"><strong>Ordered On:</strong>
                            {{ $order->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Payment Details -->
                    <div class="text-gray-700">
                        @if ($order->payment)
                            <h4 class="text-md font-bold mb-2">Payment Details</h4>
                            <p><strong>Reference:</strong> {{ $order->payment->reference_number }}</p>
                            <button
                                onclick="viewPaymentProof('{{ asset('storage/' . $order->payment->payment_proof) }}')"
                                class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600 transition">
                                View Payment Proof
                            </button>
                        @else
                            <p><strong>Payment Status:</strong> Pending</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-700">No orders found.</p>
            @endforelse
        </div>
    </main>

    <!-- Payment Proof Modal -->
    <div id="payment-proof-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg max-h-[90vh] overflow-auto">
            <h3 class="text-xl font-bold mb-4 text-center">Payment Proof</h3>
            <div id="payment-proof-container" class="mb-4 flex justify-center">
                <img src="" alt="Payment Proof" id="payment-proof-image"
                    class="max-w-full max-h-[70vh] rounded-lg shadow-md object-contain">
            </div>
            <div class="text-center">
                <button onclick="closePaymentProofModal()"
                    class="px-6 py-2 bg-gray-500 text-white font-bold rounded-lg shadow-md hover:bg-gray-600 transition">
                    Close
                </button>
            </div>
        </div>
    </div>


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

    <script>
        // Function to display the payment proof modal
        function viewPaymentProof(imageUrl) {
            const modal = document.getElementById('payment-proof-modal');
            const img = document.getElementById('payment-proof-image');

            img.src = imageUrl;
            modal.classList.remove('hidden');
        }


        function closePaymentProofModal() {
            const modal = document.getElementById('payment-proof-modal');
            modal.classList.add('hidden');
        }
    </script>


    <script>
        // Daily Order Data
        const dailyOrderStats = @json($dailyOrderStats);

        const ctx1 = document.getElementById('ordersChart').getContext('2d');
        const ctx2 = document.getElementById('dailyOrdersChart').getContext('2d');

        // Order Chart
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($orders->pluck('id')->map(fn($id) => "Order #$id")),
                datasets: [{
                    label: 'Payments',
                    data: @json($orders->map(fn($order) => $order->payment ? 1 : 0)),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
            },
        });

        // Daily Orders Chart
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: Object.keys(dailyOrderStats),
                datasets: [{
                    label: 'Daily Orders',
                    data: Object.values(dailyOrderStats),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Orders',
                        },
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>

</body>

</html>
