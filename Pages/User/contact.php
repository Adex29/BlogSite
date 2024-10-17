<?php include_once("../Components/userHeader.php"); ?>
<?php include_once("../Components/userNavbar.php"); ?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Contact Us</h1>

        <!-- Centered Contact Form -->
        <div class="flex justify-center">
            <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
                <h2 class="text-2xl font-bold mb-4">Get In Touch</h2>
                <p class="text-gray-600 mb-6">Fill out the form below and we'll get back to you as soon as possible.</p>
                
                <!-- Contact Form -->
                <form id="contactForm" action="sendContactForm.php" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="input input-bordered w-full mt-1" placeholder="Your Name" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="input input-bordered w-full mt-1" placeholder="Your Email" required>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="block text-sm font-semibold text-gray-700">Message</label>
                        <textarea id="message" name="message" class="textarea textarea-bordered w-full mt-1" rows="5" placeholder="Your Message" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-full mt-3">Send Message</button>
                </form>

                <!-- Success Pop-up -->
                <div id="successPopup" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                        <h2 class="text-2xl font-bold text-green-600 mb-4">Message Sent!</h2>
                        <p class="text-gray-700">Thank you for getting in touch. We will get back to you shortly.</p>
                        <button id="closePopup" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("../Components/userFooter.php"); ?>

<script>
  // Form submission event handler
  document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent actual form submission

    // Show the success popup
    document.getElementById('successPopup').classList.remove('hidden');

    // Optionally clear form fields
    document.getElementById('contactForm').reset();
  });

  // Close popup button event handler
  document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('successPopup').classList.add('hidden');
  });
</script>