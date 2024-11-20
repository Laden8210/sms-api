<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-violet-800 text-white py-4">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
            <h1 class="text-2xl font-bold">FIEND Dashboard</h1>
            <a href="#" class="mt-2 sm:mt-0 px-4 py-2 bg-white text-violet-800 rounded-lg hover:bg-gray-200">Logout</a>
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
                <a href="https://www.facebook.com/STIKoronadal" target="_blank" class="underline font-bold hover:text-purple-700">
                    Mizuki Mayumi
                </a>.
            </p>
        </div>
    </section>



    <!-- Orders Section -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold mb-6">Orders</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Dummy Order -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-violet-600 mb-2">Order #1</h3>
                <p class="text-gray-700 mb-2"><strong>Name:</strong> John Doe</p>
                <p class="text-gray-700 mb-2"><strong>Size:</strong> Large</p>
                <p class="text-gray-700 mb-2"><strong>Quantity:</strong> 2</p>
                <p class="text-gray-500 text-sm mb-4"><strong>Ordered on:</strong> 12 Nov 2024</p>
                <!-- Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="openPaymentModal('John Doe', 1)"
                        class="flex-1 px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600 transition">
                        Pay
                    </button>
                    <button onclick="openEditModal('John Doe', 'Large', 2, 1)"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600 transition">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Process Payment</h3>
            <p id="payment-details" class="text-gray-700 mb-4"></p>
            <div class="flex flex-col items-center mb-4">
                <img src="path/to/qr-code.png" alt="QR Code" class="w-40 h-40 mb-4">
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
                <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
                <button type="button" onclick="submitPayment()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Submit Payment</button>
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
                    <label for="edit-quantity" class="block text-sm font-semibold mb-2">Quantity</label>
                    <input type="number" id="edit-quantity"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
                    <button type="button" class="px-4 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open Edit Modal
        function openEditModal(name, size, quantity, orderId) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-size').value = size;
            document.getElementById('edit-quantity').value = quantity;
            document.getElementById('edit-order-id').value = orderId;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Open Payment Modal
        function openPaymentModal(name, orderId) {
            document.getElementById('payment-details').textContent = `Processing payment for ${name} (Order #${orderId})`;
            document.getElementById('payment-modal').classList.remove('hidden');
        }

        // Close Payment Modal
        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        // Submit Payment
        function submitPayment() {
            const referenceNumber = document.getElementById('reference-number').value;
            const paymentProof = document.getElementById('payment-proof').files[0];

            if (!referenceNumber) {
                alert('Please enter a reference number.');
                return;
            }

            if (!paymentProof) {
                alert('Please upload payment proof.');
                return;
            }

            alert('Payment submitted successfully!');
            closePaymentModal();
        }
    </script>
</body>
</html>
