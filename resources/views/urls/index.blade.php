<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if($urls->isNotEmpty())
        <div class="card my-4">

            <table class="table mb-0 table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($urls as $url)
                    <tr>
                        <td>{{ $url->name }}</td>
                        <td>{{ $url->url }}</td>
                        <td><i class="bi bi-check-circle-fill"></i>{{ $url->latestCheck?->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>You don't have any URLs to monitor right now. You can add one below
    @endif

    <form action="{{route('urls.store')}}" method="post">
        @csrf()
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
            <input type="text" class="form-control" name="url" placeholder="https://url-to-monitor.com" required>
            <button class="btn btn-primary" id="basic-addon2">+ Add</button>
        </div>
    </form>

</x-app-layout>
