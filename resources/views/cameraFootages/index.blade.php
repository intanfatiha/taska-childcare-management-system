<x-app-layout>
    <div class="max-w-[1150px] m-auto px-3">
        <!-- Title and Date/Time -->
        <div class="text-left mt-5">
            <h1 class="text-5xl font-bold">Kid Live Camera</h1>
            <p id="currentDateTime" class="text-gray-600 mt-2"></p>
        </div>

        <!-- Camera Feed Section -->
        <div id="camera_section" class="mt-8">
            <div class="text-center">
                <div id="container" class="flex justify-center" style="height: 375px; border: 10px #333 solid;">
                    <video autoplay="true" id="videoElement" style="width: 500px; height: 375px; background-color: #666;"></video>
                </div>
                <div id="controls" class="mt-5">
                    <button id="startBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Start Recording</button>
                    <button id="stopBtn" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded ml-2" disabled>Stop Recording</button>
                </div>
            </div>
        </div>

        <!-- Recorded Footages Section -->
        <div id="recordedVideo" class="mt-10">
            <h2 class="text-xl font-bold mb-4">Recorded Video:</h2>
            <video id="playback" controls class="w-full max-w-lg mx-auto"></video>
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
                            recordedChunks = [];

                            const url = URL.createObjectURL(blob);
                            playback.src = url;

                            // Download the recorded video
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `recording_${new Date().toISOString().slice(0, 10)}.webm`;
                            a.click();
                        };
                    })
                    .catch(function (error) {
                        console.error("Error accessing webcam:", error);
                        alert("Error: No supported webcam interface found.");
                    });
            } else {
                console.error("getUserMedia not supported");
                alert("Error: No supported webcam interface found.");
            }

            // Start recording
            startBtn.addEventListener('click', function () {
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