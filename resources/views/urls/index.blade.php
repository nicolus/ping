<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if($urls->isNotEmpty())
        <div class="card my-4">
            <table class="table mb-0 table-striped table_borderless">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">Status</th>
                    <th scope="col">Time</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($urls as $url)
                    <tr>
                        <td class="align-middle ps-3">{{ $url->name }}</td>
                        <td class="align-middle">{{ $url->url }}</td>
                        <td class="align-middle">
                            @if($url->isOnline())
                                <i class="bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi-x-circle-fill text-danger"></i>
                            @endif
                            <span class="text-muted">{{ $url->latestCheck?->status }}</span>
                        </td>
                        <td>{{$url->latestCheck?->time ? $url->latestCheck?->time .'ms' : ''}}</td>
                        <td class="align-middle text-end">
                            <a class="btn btn-primary btn-sm display-on-row-hover" title="Edit">
                                <i class="bi-pencil-fill"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>{{ __("You don't have any URLs to monitor right now. You can add one below") }}</p>
    @endif

    <form action="{{ route('urls.store') }}" method="post">
        @csrf()
        <p> Add a new URL to monitor : </p>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="Name" required>
            <input type="text" class="form-control" name="url" placeholder="https://url-to-monitor.com" required>
            <button class="btn btn-primary" id="basic-addon2">+ Add</button>
        </div>
    </form>
</x-app-layout>
