<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-violet-800 text-white py-4">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
            <h1 class="text-2xl font-bold">FIEND Dashboard</h1>
            <a href="#"
                class="mt-2 sm:mt-0 px-4 py-2 bg-white text-violet-800 rounded-lg hover:bg-gray-200">Logout</a>
        </div>
    </header>

    <!-- Quote Section -->
    <section class="bg-gradient-to-r from-violet-700 to-purple-800 text-white py-8">
        <div class="container mx-auto text-center px-6">
            <blockquote class="italic text-2xl font-semibold">
                "Stay connected with us at STI Koronadal — where teamwork meets excellence."
            </blockquote>
            <p class="mt-6 text-md font-medium bg-white text-violet-800 inline-block px-6 py-2 rounded-full shadow-md">
                For updates, orders, and inquiries, visit our Facebook page:
                <a href="https://www.facebook.com/NasaPh8210" target="_blank"
                    class="underline font-bold hover:text-purple-700">
                    Mizuki Mayumi
                </a>.
            </p>
        </div>
    </section>



    <!-- Orders Section -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold mb-6">Orders</h2>
        <button onclick="openOrderModal()"
            class="mb-6 px-6 py-3 bg-violet-500 text-white font-bold rounded-lg shadow-md hover:bg-violet-600 transition">
            Create New Order
        </button>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($orders as $order)
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col md:flex-row gap-6">
                    <!-- Order Details Section -->
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-violet-600 mb-2">Order #{{ $order->id }}</h3>
                        <p class="text-gray-700 mb-2"><strong>Jersey Name:</strong> {{ $order->jersey_name }}</p>
                        <p class="text-gray-700 mb-2"><strong>Size:</strong> {{ $order->size }}</p>
                        <p class="text-gray-700 mb-2"><strong>Jersey Number:</strong> {{ $order->jersey_number }}</p>
                        <p class="text-gray-700 mb-2"><strong>Remarks:</strong> {{ $order->remarks }}</p>
                        <p class="text-gray-500 text-sm mb-4"><strong>Ordered on:</strong>
                            {{ $order->created_at->format('d M Y') }}</p>
                        <div class="flex gap-2 mt-4">
                            <button onclick="openEditModal('{{ $order->jersey_name }}', '{{ $order->size }}', {{ $order->jersey_number }}, {{ $order->id }}, '{{ $order->remarks }}')"
                                class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600 transition">
                                Edit
                            </button>
                            <button onclick="openPaymentModal('{{ $order->jersey_name }}', {{ $order->id }})"
                                class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600 transition">
                                Pay
                            </button>
                        </div>
                    </div>

                    <!-- Payment Details Section -->
                    <div class="flex-1 bg-gray-100 p-4 rounded-lg text-gray-700">
                        @if ($order->payment && $order->payment->payment_proof)
                            <h4 class="text-md font-bold mb-2">Payment Details</h4>
                            <p class="mb-2"><strong>Reference Number:</strong> {{ $order->payment->reference_number }}</p>
                            <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Payment Proof"
                                class="w-full h-auto rounded-lg shadow-md">
                        @else
                            <h4 class="text-md font-bold text-red-500 mb-2">Payment Pending</h4>

                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-700">No orders found.</p>
            @endforelse
        </div>
    </main>


    <div id="order-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Create New Order</h3>
            <form id="order-form">
                <div class="mb-4">
                    <label for="jersey-name" class="block text-sm font-semibold mb-2">Jersey Name</label>
                    <input type="text" id="jersey-name" name="jersey_name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="size" class="block text-sm font-semibold mb-2">Size</label>
                    <select id="size" name="size"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
                        required>
                        <option value="" disabled selected>Select Size</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="XL">XL</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jersey-number" class="block text-sm font-semibold mb-2">Jersey Number</label>
                    <input type="number" id="jersey-number" name="jersey_number"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
                        min="1" required>
                </div>
                <div class="mb-6">
                    <label for="remarks" class="block text-lg font-semibold mb-2">Remarks</label>
                    <textarea id="remarks" name="remarks"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeOrderModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="button" onclick="submitOrder()"
                        class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Edit Order</h3>
            <form>
                <input type="hidden" id="edit-order-id">
                <div class="mb-4">
                    <label for="edit-name" class="block text-sm font-semibold mb-2">Jersey Name</label>
                    <input type="text" id="edit-name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                </div>
                <div class="mb-4">
                    <label for="edit-size" class="block text-sm font-semibold mb-2">Size</label>
                    <select id="edit-size"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="XL">XL</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit-jersey-number" class="block text-sm font-semibold mb-2">Jersey Number</label>
                    <input type="number" id="edit-jersey-number"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                </div>
                <div class="mb-6">
                    <label for="edit-remarks" class="block text-lg font-semibold mb-2">Remarks</label>
                    <textarea id="edit-remarks" name="remarks"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="button" onclick="saveEditOrder()"
                        class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>





    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Process Payment</h3>
            <p id="payment-details" class="text-gray-700 mb-4"></p>
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('storage/QR.jpg' ) }}" alt="QR Code" class="w-64 mb-4">
            </div>
            <div class="mb-4">
                <label for="reference-number" class="block text-sm font-semibold mb-2">Enter Reference Number</label>
                <input type="text" id="reference-number" placeholder="Reference Number"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>
            <div class="mb-4">
                <label for="payment-proof" class="block text-sm font-semibold mb-2">Upload Payment Proof</label>
                <input type="file" id="payment-proof" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closePaymentModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
                <button type="button" onclick="submitPayment()"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Submit Payment</button>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Edit Order</h3>
            <form>
                <input type="hidden" id="edit-order-id">
                <div class="mb-4">
                    <label for="edit-name" class="block text-sm font-semibold mb-2">Name</label>
                    <input type="text" id="edit-name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                </div>
                <div class="mb-4">
                    <label for="edit-size" class="block text-sm font-semibold mb-2">Size</label>
                    <select id="edit-size"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="XL">XL</option>
                        <option value="2XL">2XL</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit-jersey-number" class="block text-sm font-semibold mb-2">Jersey Number</label>
                    <input type="number" id="edit-jersey-number"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                </div>
                <div class="mb-6">
                    <label for="remarks" class="block text-lg font-semibold mb-2">Remarks</label>
                    <textarea id="remarks" name="remarks" class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
                    <button type="button" onclick="saveEditOrder()"
                        class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600">Save</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Open Order Modal
        function openOrderModal() {
            document.getElementById('order-modal').classList.remove('hidden');
        }

        // Close Order Modal
        function closeOrderModal() {
            document.getElementById('order-modal').classList.add('hidden');
        }

        // Submit Order via AJAX
        function submitOrder() {
            const jerseyName = document.getElementById('jersey-name').value;
            const size = document.getElementById('size').value;
            const jerseyNumber = document.getElementById('jersey-number').value;
            const remarks = document.getElementById('remarks').value;

            if (!jerseyName || !size || jerseyNumber <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill out all fields correctly.',
                });
                return;
            }

            $.ajax({
                url: "{{ route('orders.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    jersey_name: jerseyName,
                    size: size,
                    jersey_number: jerseyNumber,
                    remarks: remarks
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Created',
                        text: response.message,
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Order Failed',
                        text: xhr.responseJSON?.message || 'An error occurred.',
                    });
                },
            });
        }
        // Open Edit Modal
        function openEditModal(name, size, jerseyNumber, orderId, remarks) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-size').value = size;
            document.getElementById('edit-jersey-number').value = jerseyNumber;
            document.getElementById('edit-order-id').value = orderId;
            document.getElementById('edit-remarks').value = remarks;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
        // Save Edited Order via AJAX
        function saveEditOrder() {
            const orderId = document.getElementById('edit-order-id').value;
            const name = document.getElementById('edit-name').value;
            const size = document.getElementById('edit-size').value;
            const jerseyNumber = document.getElementById('edit-jersey-number').value;
            const remarks = document.getElementById('edit-remarks').value;

            if (!name || !size || jerseyNumber <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill out all fields correctly.',
                });
                return;
            }

            $.ajax({
                url: "{{ route('orders.update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: orderId,
                    jersey_name: name,
                    size: size,
                    jersey_number: jerseyNumber,
                    remarks: remarks
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Updated',
                        text: response.message,
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: xhr.responseJSON?.message || 'An error occurred.',
                    });
                },
            });
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Open Payment Modal
        function openPaymentModal(name, orderId) {
            document.getElementById('payment-details').textContent = `Processing payment for ${name} (Order #${orderId})`;
            document.getElementById('payment-details').dataset.orderId = orderId;
            document.getElementById('payment-modal').classList.remove('hidden');
        }

        // Submit Payment via AJAX
        function submitPayment() {
            const orderId = document.getElementById('payment-details').dataset.orderId;
            const referenceNumber = document.getElementById('reference-number').value;
            const paymentProof = document.getElementById('payment-proof').files[0];

            if (!referenceNumber || !paymentProof) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Both reference number and payment proof are required.',
                });
                return;
            }

            const formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('order_id', orderId);
            formData.append('reference_number', referenceNumber);
            formData.append('payment_proof', paymentProof);

            $.ajax({
                url: "{{ route('payments.submit') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Submitted',
                            text: response.message,
                        }).then(() => location.reload());
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: xhr.responseJSON?.message ||
                            'An error occurred while submitting the payment.',
                    });
                },
            });
        }

        // Close Payment Modal
        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }
    </script>
</body>

</html>
