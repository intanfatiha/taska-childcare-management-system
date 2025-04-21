<x-app-layout>
    

    <div class="max-w-[1150px] m-auto px-3">
        <!-- Title and Date/Time -->
        <div class="text-left mt-5">
            <h1 class="text-5xl font-bold">Kid Surveillance</h1>
            <p id="currentDateTime" class="text-gray-600 mt-2"></p>
        </div>

        <!-- Camera Feed Section -->
        <div id="camera_section" class="mt-8">
            
            <div class="text-center">
                <div class="flex justify-center" style="height: 350px">
                    <div id="my_camera" style="width:640px; height:400px; border:1px solid black;"></div>
                </div>
                <div class="mt-5">
                    <br>
                    <button id="startRecord" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Start Record</button>
                    <button id="stopRecord" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded ml-2">Stop Record</button>
                </div>
            </div>
        </div>

        <!-- Recorded Footages Table -->
        <div class="mt-10">
            <h2 class="text-xl font-bold mb-4">Recorded Footages</h2>
            <table class="min-w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Date</th>
                        <th class="border px-4 py-2 text-left">Time Recorded</th>
                        <th class="border px-4 py-2 text-left">Footage</th>
                        <th class="border px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Data -->
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">15/02/2024</td>
                        <td class="border px-4 py-2">6:30 AM - 7:00 PM</td>
                        <td class="border px-4 py-2 text-center">
                            <img src="https://via.placeholder.com/50" alt="Footage Thumbnail" class="inline-block">
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">14/02/2024</td>
                        <td class="border px-4 py-2">6:30 AM - 7:00 PM</td>
                        <td class="border px-4 py-2 text-center">
                            <img src="https://via.placeholder.com/50" alt="Footage Thumbnail" class="inline-block">
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Webcam
            Webcam.set({
                width: 640,
                height: 350,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');

            // Display Current Date and Time
            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
            }
            updateDateTime();
            setInterval(updateDateTime, 60000); // Update every minute

            // Start and Stop Recording (Placeholder functionality)
            $('#startRecord').click(function() {
                alert('Recording started!');
            });

            $('#stopRecord').click(function() {
                alert('Recording stopped!');
            });
        });
    </script>
    @endpush
</x-app-layout>