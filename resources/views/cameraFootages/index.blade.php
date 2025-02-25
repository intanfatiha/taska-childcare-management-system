<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Webcam Recorder') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Webcam Area -->
                    <div class="flex justify-center items-center mt-3">
                    <div id="container" class="flex justify-center items-center border border-gray-300" style="width: 600px; height: 350px; overflow: hidden;">
                        <video autoplay="true" id="videoElement" class="object-cover w-full h-full"></video>
                    </div>
                    </div>
                    @if(auth()->user()->role==='admin')
                    <div class="flex justify-center items-center mt-6 gap-4">
                        <button id="startBtn" class="btn btn-primary px-6 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 focus:outline-none">Start Record</button>
                        <button id="stopBtn" class="btn btn-danger px-6 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 focus:outline-none" disabled>Stop Record</button>
                    </div>

                    <!-- Recorded Videos Table -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Recorded Videos</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Recorded</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Footage</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                            
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <video width="200" controls>

                                                </video>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this?');">
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
                                        </tr>
                           
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                No recordings found
                                            </td>
                                        </tr>
                             
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let video = document.querySelector("#videoElement");
            let startBtn = document.querySelector("#startBtn");
            let stopBtn = document.querySelector("#stopBtn");

            let mediaRecorder;
            let recordedChunks = [];

            if(navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                        mediaRecorder = new MediaRecorder(stream);

                        mediaRecorder.ondataavailable = function(event) {
                            if (event.data.size > 0) {
                                recordedChunks.push(event.data);
                            }
                        };

                        mediaRecorder.onstop = async function() {
                            let blob = new Blob(recordedChunks, {
                                type: 'video/webm'
                            });
                            recordedChunks = [];

                            // Create FormData and send to server
                            const formData = new FormData();
                            formData.append('video', blob, `recording_${new Date().toISOString()}.webm`);

                            try {
                                const response = await fetch('/recordings', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                });

                                if (response.ok) {
                                    // Reload page to show new recording
                                    window.location.reload();
                                } else {
                                    console.error('Upload failed');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        };
                    })
                    .catch(function (error) {
                        console.log("Something went wrong!", error);
                    });
            }

            startBtn.addEventListener('click', function() {
                mediaRecorder.start();
                startBtn.disabled = true;
                stopBtn.disabled = false;
            });

            stopBtn.addEventListener('click', function() {
                mediaRecorder.stop();
                startBtn.disabled = false;
                stopBtn.disabled = true;
            });
        });
    </script>
    @endpush
</x-app-layout>