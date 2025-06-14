<x-app-layout>
    <!-- <div class="max-w-[1150px] m-auto px-3"> -->

    <!-- Header Section -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-gradient-to-r from-indigo-50 to-purple-100 p-6 rounded-lg shadow-sm">
                
                <!-- Title and Subtitle -->
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 mb-1">
                        {{ __('Kid Live Camera') }}
                    </h2>
                    <p class="text-gray-600 mt-1">Watch your child live and never miss a smile</p>
                </div>

                <!-- Running Date & Time -->
                <div class="mt-4 md:mt-0 text-gray-600 font-medium text-lg" id="currentDateTime"></div> 
            </div>
        </div>
    </div>

    <!-- Camera Feed Section -->
    <div id="camera_section" class="mt-1 flex flex-col items-center">
        <!-- Live Camera Container -->
        <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-xl border border-gray-300">
            <video autoplay="true" id="videoElement" class="w-full h-auto"></video>
        </div>

        <!-- Admin Control Buttons -->
        @if(auth()->user()->role === 'admin')
        <div id="controls" class="mt-6">
            <button id="startBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded">Start Record</button>
            <button id="stopBtn" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded ml-4" disabled>Stop Record</button>
        </div>
        @endif
    </div>
@if(auth()->user()->role === 'admin')
    <!-- Recorded Footages Table -->
    <div class="mt-10">
        <h2 class="text-xl font-bold mb-2">Recorded Footages</h2>
        <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
            <thead>
                <tr class="bg-gradient-to-r from-purple-500 to-blue-500 text-white">
                    <th class="border px-4 py-2 text-left">Date</th>
                    <th class="border px-4 py-2 text-left">Time Recorded</th>
                    <th class="border px-4 py-2 text-left">Footage</th>
                    
                        <th class="border px-4 py-2 text-left">Action</th>
                   
                </tr>
            </thead>
            <tbody id="footageTable">
                @foreach ($cameraFootages as $footage)
                    <tr class="hover:bg-blue-50 border-b border-gray-200 transition-colors">
                        <td class="border px-4 py-2 text-center">{{ $footage->date }}</td>
                        <td class="border px-4 py-2 text-center">{{ $footage->start_time }} - {{ $footage->end_time }}</td>
                        <td class="border px-4 py-2 text-center">
                            <video src="{{ asset($footage->file_location) }}" controls class="w-20 h-12 mx-auto"></video>
                        </td>

                        @if(auth()->user()->role === 'admin')
                        <td class="border px-4 py-2 text-center">
                            <form method="POST" action="{{ route('camera-footages.destroy', $footage->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
         @endif
    </div>
</div>

<!-- Script Section -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("JS loaded for user role: {{ auth()->user()->role }}");

        const video = document.querySelector("#videoElement");
        @if(auth()->user()->role === 'admin')
            const startBtn = document.querySelector("#startBtn");
            const stopBtn = document.querySelector("#stopBtn");
        @endif

        let mediaRecorder;
        let recordedChunks = [];
        let start_time;

        // Initialize webcam
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true }) 
                .then(function (stream) {
                    video.srcObject = stream;
                    @if(auth()->user()->role === 'admin')
                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.ondataavailable = function (event) {
                        if (event.data.size > 0) {
                            recordedChunks.push(event.data);
                        }
                    };

                    mediaRecorder.onstop = function () {
                        const blob = new Blob(recordedChunks, { type: 'video/webm' });
                        recordedChunks = [];

                        const formData = new FormData();
                        formData.append('footagedocument', blob, `recording_${Date.now()}.webm`);
                        formData.append('start_time', start_time);
                        formData.append('end_time', new Date().toLocaleTimeString());
                        formData.append('date', new Date().toISOString().slice(0, 10));

                        fetch('{{ route("camera-footages.store") }}', {
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
                                location.reload();
                            } else {
                                alert('Failed to save footage.');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving footage:', error);
                        });
                    };
                    @endif
                })
                .catch(function (error) {
                    console.error("Error accessing webcam:", error);
                    alert("Error: No supported webcam interface found.");
                });
        } else {
            console.error("getUserMedia not supported");
            alert("Error: getUserMedia not supported.");
        }

        // Admin controls
        @if(auth()->user()->role === 'admin')
        startBtn.addEventListener('click', function () {
            start_time = new Date().toLocaleTimeString();
            mediaRecorder.start();
            startBtn.disabled = true;
            stopBtn.disabled = false;
            alert("Recording started!");
        });

        stopBtn.addEventListener('click', function () {
            mediaRecorder.stop();
            startBtn.disabled = false;
            stopBtn.disabled = true;
            alert("Recording stopped!");
        });
        @endif

        // Running Date & Time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', 
                hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true 
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleString('en-US', options);
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    });
</script>
@endpush
</x-app-layout>
