
<x-app-layout>
    <div class="max-w-[1150px] m-auto px-3">
        <!-- Title and Date/Time -->
        <div class="text-left mt-5">
            <h1 class="text-5xl font-bold">Kid Live Camera</h1>
            <p id="currentDateTime" class="text-gray-600 mt-2"></p>
        </div>

        <!-- Camera Feed Section -->
        <div id="camera_section" class="mt-10 flex flex-col items-center">
            <!-- Live Camera Container -->
            <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-xl border border-gray-300">
                <video autoplay="true" id="videoElement" class="w-full h-auto"></video>
            </div>

            <!-- Control Buttons -->
            <div id="controls" class="mt-6">
                <button id="startBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded">Start Record</button>
                <button id="stopBtn" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded ml-4" disabled>Stop Record</button>
            </div>
        </div>

    
        <!-- Recorded Footages Section
        <div id="recordedVideo" class="mt-10">
            <h2 class="text-xl font-bold mb-4">Recorded Video:</h2>
            <video id="playback" controls class="w-full max-w-lg mx-auto"></video>
        </div> -->

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
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.querySelector("#videoElement");
            const playback = document.querySelector("#playback");
            const startBtn = document.querySelector("#startBtn");
            const stopBtn = document.querySelector("#stopBtn");

            let mediaRecorder;
            let recordedChunks = [];
            let start_time;

            // Check for webcam support and initialize
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                        mediaRecorder = new MediaRecorder(stream);

                        // Collect recorded chunks
                        mediaRecorder.ondataavailable = function (event) {
                            if (event.data.size > 0) {
                                recordedChunks.push(event.data);
                            }
                        };

                        // Handle recording stop
                        mediaRecorder.onstop = function () {
                            const blob = new Blob(recordedChunks, { type: 'video/webm' });
                            console.log(blob.type); // Should output "video/webm"
                            recordedChunks = [];

                            const url = URL.createObjectURL(blob);
                            playback.src = url;

                            const formData = new FormData();
                            formData.append('footagedocument', blob, `recording_${Date.now()}.webm`);
                            formData.append('start_time', start_time);
                            formData.append('end_time', new Date().toLocaleTimeString());
                            formData.append('date', new Date().toISOString().slice(0, 10));

                            // Send the recorded video to the server
                            fetch('{{ route('cameraFootages.store') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert(data.message);
                                    location.reload(); // Reload the page to display the new footage
                                } else {
                                    alert('Failed to save footage.');
                                }
                            })
                            .catch(error => {
                                console.error('Error saving footage:', error);
                            });
                        };
                    })
                    .catch(function (error) {
                        console.error("Error accessing webcam:", error);
                        alert("Error: No supported webcam interface found.");
                    });
            } else {
                console.error("getUserMedia not supported");
                alert("Error: getUserMedia No supported webcam interface found.");
            }

            // Start recording
            startBtn.addEventListener('click', function () {
                start_time = new Date().toLocaleTimeString();
                mediaRecorder.start();
                startBtn.disabled = true;
                stopBtn.disabled = false;
                alert("Recording started!");
            });

            // Stop recording
            stopBtn.addEventListener('click', function () {
                mediaRecorder.stop();
                startBtn.disabled = false;
                stopBtn.disabled = true;
                alert("Recording stopped!");
            });

            // Display current date and time
            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
            }
            updateDateTime();
            setInterval(updateDateTime, 60000); // Update every minute
        });
    </script>
    @endpush
</x-app-layout>