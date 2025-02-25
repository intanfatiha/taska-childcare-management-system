<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                    <table class="table">
                      <!-- head -->
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Photo</th>
                          <th>Capacity</th>
                          <!-- request action ni dekat sidebar.blade -->
                          @if(request('action')=='update'||request('action')=='delete'||request('action')=='reserve')
                          <th> Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        <!-- row 1 -->
                        @foreach($rooms as $index => $room)
                        {{-- @foreach($rooms as $room) --}}
                        <tr>
                          <!-- {{-- <th>{{ $loop->iteration }}</th> --}} -->
                          <td>{{ $rooms->firstItem() + $index }}</td>
                          <td>{{ $room->name }}</td> 
                          <td>
                          @if ($room->photo)
                              <img src="{{ asset('uploads/rooms/'.$room->photo) }}" style="width:100px;">
                            @else
                              No photo
                            @endif
                          </td>
                          
                          <td>{{ $room->capacity }}</td>
                          @if(request('action')=='update')
                          <!-- <td> <a href="" class="btn btn-primary" >Update</a></td> -->
                          <td> <a href="{{route('rooms.edit',$room->id)}}" ><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a></td>
                          @endif

                          @if(request('action')=='delete')
                          <!-- <td> <a href="" class="btn btn-primary" >Delete</a></td> -->
                          <td> 
                            <form action="{{ route('rooms.destroy',$room->id) }}" method="POST">
                              @csrf 
                              @method('DELETE')
                              <button type="submit"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-copy-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path stroke="none" d="M0 0h24v24H0z" /><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" /><path d="M4.012 16.737a2 2 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /><path d="M11.5 11.5l4.9 5" /><path d="M16.5 11.5l-5.1 5" /></svg></button>

                            </form>
                          </td>
                          @endif

                          <!-- kalau ada route ni akn pegi route dekat web.php, then pegi roomreservation.php -->
                          @if(request('action')=='reserve')                 
                          <td> <a href="{{ route('roomreservations.create',['room_id' => $room->id]) }}" ><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-door"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 12v.01" /><path d="M3 21h18" /><path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16" /></svg></a></td>
                          @endif

                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{ $rooms->appends(['action' => request('action')])->links() }}
                  </div>
            </div>
        </div>
    </div>
</x-app-layout>
