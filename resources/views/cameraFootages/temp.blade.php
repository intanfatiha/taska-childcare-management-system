<x-app-layout>
       <div class="max-w-[1150px] m-auto px-3">
        <!-- Add CSRF meta tag for AJAX requests -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Title and Date/Time -->
        <div class="text-left mt-5">
            <h1 class="text-5xl font-bold">Kid Live Camera</h1>
            <p id="currentDateTime" class="text-gray-600 mt-2"></p>
        </div>

        <!-- Status Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Camera Feed Section -->
        <div id="camera_section" class="mt-10 flex flex-col items-center">
            <!-- Live Camera Container -->
            <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-xl border border-gray-300">
                <video id="my_camera" autoplay muted class="w-full h-auto"></video>
            </div>

            <!-- Control Buttons -->
            <div class="mt-6">
                <button id="startRecord" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded">Start Record</button>
                <button id="stopRecord" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded ml-4" disabled>Stop Record</button>
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
                <tbody id="footageTable">
                    @foreach ($cameraFootages as $footage)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $footage->date }}</td>
                            <td class="border px-4 py-2">{{ $footage->start_time }} - {{ $footage->end_time }}</td>
                            <td class="border px-4 py-2 text-center">
                                <video src="{{ asset($footage->file_location) }}" controls class="w-20 h-12"></video>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <form method="POST" action="{{ route('cameraFootages.destroy', $footage->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const videoElement = document.getElementById('my_camera');
    const startButton = document.getElementById('startRecord');
    const stopButton = document.getElementById('stopRecord');
    const footageTable = document.getElementById('footageTable');

    let mediaRecorder;
    let recordedChunks = [];
    let startTime; // Add variable to track when recording started

    // Display current date and time
    function updateDateTime() {
        const now = new Date();
        document.getElementById('currentDateTime').textContent = 
            now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
    }
    
    // Update date/time every second
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Request access to the user's camera and microphone
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(stream => {
            // Attach the stream to the video element
            videoElement.srcObject = stream;

            // Initialize MediaRecorder
            mediaRecorder = new MediaRecorder(stream);

            // Handle dataavailable event to collect recorded chunks
            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            // Handle stop event to save the recorded video
            mediaRecorder.onstop = () => {
                const endTime = new Date(); // Record end time
                const blob = new Blob(recordedChunks, { type: 'video/webm' });
                const formData = new FormData();
                
                // Create a file from the blob
                const file = new File([blob], `footage_${Date.now()}.webm`, {type: 'video/webm'});
                formData.append('footage', file);
                
                // Add start and end times to the form data
                formData.append('start_time', startTime.toTimeString().split(' ')[0]);
                formData.append('end_time', endTime.toTimeString().split(' ')[0]);
                
                // Add CSRF token properly
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                console.log('Sending request with form data:', {
                    hasFile: formData.has('footage'),
                    startTime: formData.get('start_time'),
                    endTime: formData.get('end_time'),
                    csrfToken: csrfToken ? 'present' : 'missing'
                });

                // Send the footage to the server
                fetch('/camera-footages', {  // Use direct URL instead of route helper
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    // Check if response is ok before trying to parse JSON
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Server error response:', text);
                            throw new Error(`Server responded with ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success response:', data);
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload the page to display the new footage
                    } else {
                        alert('Failed to save footage: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error saving footage:', error);
                    alert('Error saving footage. Check the console for details.');
                });

                // Reset recorded chunks
                recordedChunks = [];
            };

            // Enable the Start Record button
            startButton.disabled = false;
        })
        .catch(error => {
            console.error('Error accessing media devices:', error);
            alert('Could not access camera and microphone. Please check your permissions.');
        });

    // Start recording
    startButton.addEventListener('click', () => {
        startTime = new Date(); // Record start time
        mediaRecorder.start();
        startButton.disabled = true;
        stopButton.disabled = false;
        console.log('Recording started at:', startTime);
    });

    // Stop recording
    stopButton.addEventListener('click', () => {
        mediaRecorder.stop();
        startButton.disabled = false;
        stopButton.disabled = true;
        console.log('Recording stopped at:', new Date());
    });
});
    </script>
    @endpush
</x-app-layout>