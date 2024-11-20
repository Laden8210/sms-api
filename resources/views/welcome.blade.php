<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIEND - Clothing Line</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #2b0348, #000000);
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Oswald', sans-serif;
        }

        .hidden {
            opacity: 0;
            visibility: hidden;
            transition: opacity 1s ease, visibility 1s ease;
        }

        .hover-img:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }

        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #2b0348;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 50;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            transition: opacity 1s ease, visibility 1s ease;
        }

        #welcome-message {
            font-size: 1.5rem;
        }

        #random-quote {
            font-size: 1rem;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-top: 20px;
        }

        @media (min-width: 640px) {
            #welcome-message {
                font-size: 2rem;
            }

            #random-quote {
                font-size: 1.25rem;
            }

            .spinner {
                width: 50px;
                height: 50px;
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="text-white">

    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="text-center">
            <p id="welcome-message" class="mb-4">Welcome to FIEND</p>
            <p id="random-quote" class="italic"></p>
            <div class="spinner mt-4 m-auto"></div>
        </div>
    </div>

    <script>
        // List of Random Quotes
        const quotes = [
            "Although I am weak now, I will rise to the top.",
            "Carve your own path and claim the strength you deserve.",
            "Protect those you love and destroy those who stand in your way.",
            "Power is earned through determination and will.",
            "The shadows hold great strength for those who seek it."
        ];

        // Select a random quote
        const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];

        // Set the random quote in the loading screen
        document.getElementById('random-quote').textContent = randomQuote;
    </script>

    <!-- Header -->
    <header class="bg-violet-800 shadow-lg fixed top-0 left-0 w-full z-20">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo Section -->
            <div class="flex items-center">
                <img src="{{ asset('images/feind-logo.webp') }}" alt="FIEND Logo" class="w-12 h-12 mr-4">
                <h1 class="text-3xl font-bold">FIEND</h1>
            </div>


            <div class=" lg:flex items-center">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-white text-violet-800 font-bold rounded-lg shadow-md hover:bg-gray-200 transition">
                    Login
                </a>
            </div>


        </div>

    </header>


    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section id="hero" class="text-center h-screen flex flex-col justify-center items-center px-4">
            <h2 class="text-3xl sm:text-5xl font-extrabold mb-4">Welcome to FIEND</h2>
            <p class="text-sm sm:text-lg font-light mb-8">Inspired by the Solo Leveling manhwa, the FIEND jersey
                captures the power and mystery of its universe.</p>
            <img src="{{ asset('images/solo-leveling.jpg') }}" alt="Solo Leveling Art"
                class="rounded-lg shadow-md w-full max-w-md sm:max-w-lg hover-img">
        </section>

        <!-- Mission Section -->
        <section id="mission"
            class="min-h-screen bg-black flex flex-col justify-center items-center text-center px-4">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6 text-violet-500">Our Mission</h2>
            <p class="text-sm sm:text-lg leading-relaxed max-w-xl">
                At FIEND, we aim to empower teams with designs that inspire strength, unity, and individuality. We
                strive to create apparel that not only performs on the field but also represents the spirit of every
                player.
            </p>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="min-h-screen bg-black flex flex-col justify-center items-center px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-8 text-violet-500">Gallery</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full max-w-5xl">
                <!-- Gallery Images -->



                <div class="relative group">
                    <img src="{{ asset('images/jersey.png') }}" alt="Jersey Front"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Jersey Front</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="{{ asset('images/solo-leveling.jpg') }}" alt="Solo Leveling Design"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Solo Leveling Design</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="{{ asset('images/jersey.png') }}" alt="Team Jersey"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Team Jersey</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="{{ asset('images/feind-logo.webp') }}" alt="Logo Design"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Logo Design</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="{{ asset('images/jersey.png') }}" alt="Jersey Side View"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Jersey Side View</p>
                    </div>
                </div>
                <div class="relative group">
                    <img src="{{ asset('images/solo-leveling.jpg') }}" alt="Inspired Art"
                        class="rounded-lg shadow-md hover-img w-full h-72 object-cover">
                    <div
                        class="absolute inset-0 bg-violet-800 bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                        <p class="text-white font-bold">Inspired Art</p>
                    </div>
                </div>

            </div>
        </section>

        <section id="form"
            class="min-h-screen bg-gradient-to-b from-black via-gray-900 to-black text-white flex flex-col justify-center items-center py-12">
            <h2 class="text-5xl font-extrabold text-violet-500 mb-12">Order Your Jersey</h2>
            <div class="container mx-auto flex flex-col lg:flex-row items-center lg:justify-between gap-10 px-6">

                <!-- Quote Section -->
                <div class="flex justify-center lg:justify-end w-full lg:w-1/2">
                    <div class="relative text-center rounded-lg shadow-lg p-8 w-full max-w-lg">
                        <p class="text-xl italic font-semibold text-white leading-relaxed">
                            "Although I am weak now, I will rise to the top. I will carve my own path and claim the
                            strength to protect those I love and destroy those who stand in my way."
                        </p>
                        <span class="block mt-4 text-sm text-gray-300">- Solo Leveling</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-violet-500 to-transparent opacity-20 rounded-lg pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Order Form -->
                <div class="bg-gray-800 text-white rounded-lg shadow-lg p-8 w-full lg:w-1/2">
                    <h3 class="text-3xl font-bold text-center mb-6 text-violet-400">Place Your Order</h3>
                    <form id="orderFormElement" onsubmit="submitOrder(event)">
                        <div class="mb-6">
                            <label for="name" class="block text-lg font-semibold mb-2">Your Name</label>
                            <input type="text" id="name" name="name" required class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg">
                        </div>
                        <div class="mb-6">
                            <label for="contact_number" class="block text-lg font-semibold mb-2">Your Phone Number</label>
                            <input type="text" id="contact_number" name="contact_number" required class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg">
                        </div>
                        <div class="mb-6">
                            <label for="jersey_name" class="block text-lg font-semibold mb-2">Jersey Name</label>
                            <input type="text" id="jersey_name" name="jersey_name" required class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg">
                        </div>
                        <div class="mb-6">
                            <label for="jersey_number" class="block text-lg font-semibold mb-2">Jersey Number</label>
                            <input type="number" id="jersey_number" name="jersey_number" min="1" required class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg">
                        </div>
                        <div class="mb-6">
                            <label for="size" class="block text-lg font-semibold mb-2">Select Size</label>
                            <select id="size" name="size" required class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg">
                                <option value="" disabled selected>Select Size</option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="remarks" class="block text-lg font-semibold mb-2">Remarks</label>
                            <textarea id="remarks" name="remarks" class="w-full p-3 bg-gray-900 border border-gray-700 rounded-lg"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="px-6 py-3 bg-violet-500 text-white font-bold rounded-lg shadow-md hover:bg-violet-600">
                                Submit Order
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </section>


        <!-- About Section -->
        <section id="about" class="min-h-screen bg-violet-900 flex flex-col justify-center items-center px-4">
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-6">About FIEND</h2>
            <p class="text-sm sm:text-lg leading-relaxed max-w-3xl text-center">
                FIEND draws inspiration from the Solo Leveling manhwa, symbolizing strength, unity, and individuality.
            </p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-4 bg-violet-800 text-center">
        <p class="text-sm sm:text-base">&copy; 2024 FIEND. All Rights Reserved.</p>
        <div class="mt-2 flex justify-center space-x-4">
            <a href="#" class="hover:text-violet-400">Facebook</a>
            <a href="#" class="hover:text-violet-400">Twitter</a>
            <a href="#" class="hover:text-violet-400">Instagram</a>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        function submitOrder(event) {
            alert("Hulat lang kay tapuson ko pa bwas ang code");
        }
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loadingScreen = document.getElementById('loading-screen');
                loadingScreen.classList.add('hidden');
            }, 2000);
        });

        // Mobile Menu Toggle
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function submitOrder(event) {
    event.preventDefault();

    const name = $('#name').val();
    const contactNumber = $('#contact_number').val();

    // Regex for validation
    const nameRegex = /^[a-zA-Z\s]+$/;
    const contactNumberRegex = /^(09|\+639)\d{9}$/;

    // Validate name
    if (!nameRegex.test(name)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Name',
            text: 'Name should only contain letters and spaces.',
        });
        return;
    }

    // Validate contact number
    if (!contactNumberRegex.test(contactNumber)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Contact Number',
            text: 'Please enter a valid Philippine mobile number (e.g., 09123456789 or +639123456789).',
        });
        return;
    }

    // AJAX Submission
    const formData = {
        name,
        contact_number: contactNumber,
        jersey_name: $('#jersey_name').val(),
        jersey_number: $('#jersey_number').val(),
        size: $('#size').val(),
        remarks: $('#remarks').val(),
        _token: "{{ csrf_token() }}", // Laravel CSRF Token
    };

    $.ajax({
        url: "{{ route('createOrder') }}",
        type: "POST",
        data: formData,
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Order Placed',
                    text: response.message,
                });
                $('#orderFormElement')[0].reset();
            }
        },
        error: function (xhr) {
            const errors = xhr.responseJSON.errors;
            let errorMessages = '';
            for (let key in errors) {
                errorMessages += `${errors[key][0]}\n`;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessages,
            });
        },
    });
}

</script>

</body>

</html>
