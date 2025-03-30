<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Live Camera Feed') }}
        </h2>
    </x-slot>

    <div class="max-w-[1150px] m-auto px-3"> 
        <div id="camera_section">
            <div class="text-center mt-5">
                <div class="flex justify-center" style="height: 350px">
                    <div id="my_camera" style="width:640px; height:400px; border:1px solid black;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script>
        $(document).ready(function() {
            Webcam.set({
                width: 640,
                height: 400,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        });
    </script>
    @endpush
</x-app-layout>
