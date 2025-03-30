<x-app-layout>
  

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

            <div class="bg-white p-6 rounded-lg shadow-md">

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h1 class="text-xl font-bold mb-3 text-center " > REGISTRATION REJECTION</h1>

                    <!-- Name Field -->
                    <div class="form-control w-full mb-2">
                        <label class="label">
                            <span class="label-text">Father Email</span>
                        </label>
                        <input type="email" name="father_email" class="input input-bordered w-full" placeholder="Enter father email" value="">
                    </div>
                    @error('father_email')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-control w-full mb-2">
                        <label class="label">
                            <span class="label-text">Mother Email</span>
                        </label>
                        <input type="email" name="mother_email" class="input input-bordered w-full" placeholder="Enter mother email" value="">
                    </div>
                    @error('mother_email')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-control w-full mb-2">
                        <label class="label">
                            <span class="label-text">Guardian Email (if nescessary)</span>
                        </label>
                        <input type="email" name="guardian_email" class="input input-bordered w-full" placeholder="Enter guardian email" value="">
                    </div>
                    @error('guardian_email')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                  <!-- Activity Description Field -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Reason of Rejection</span>
                        </label>
                        <textarea name="rejection_reason" class="textarea textarea-bordered w-full" placeholder="" rows="4"></textarea>
                    </div>
                    @error('rejection_reason')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror
                  

                    <div class="flex items-center justify-center gap-3 mt-6">
                        <button type="submit" class="btn btn-primary  px-10 py-2 w-100">Submit</button>
                       
                        <a href="{{ route('childrenRegisterRequest') }}" class="btn btn-primary  px-10 py-2 w-100">Cancel
                        </a>

                    </div>

                
                </form>
            </div>
        </div>
    </div>
</x-app-layout>