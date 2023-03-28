<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('URL Edit') }}
        </h2>
    </x-slot>
    <div class="card shadow-sm p-2">
        <div class="card-body">
            <h5 class="card-title">Edit URL :</h5>
            <form class="d-inline" action="{{ route('probes.update', $url) }}"  method="post">
                @csrf
                @method('PUT')
                <x-input-label value="{{$url->name}}" name="name" required />
                <x-input-label value="{{$url->url}}" name="url" required />
                <button class="btn btn-primary px-3"><i class="bi bi-check fs-5 me-1"></i> Save</button>
            </form>
            <form class="d-inline"  action="{{ route('probes.destroy', $url)}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger px-3"><i class="bi bi-x fs-5 me-1"></i> Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>
