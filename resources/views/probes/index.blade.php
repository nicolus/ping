<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if($probes->isNotEmpty())
        <div class="card shadow-sm my-4">
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
                @foreach($probes as $probe)
                    <tr>
                        <td class="align-middle ps-3">{{ $probe->name }}</td>
                        <td class="align-middle">{{ $probe->url }}</td>
                        <td class="align-middle">
                            @if($probe->isOnline())
                                <i class="bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi-x-circle-fill text-danger"></i>
                            @endif
                            <span class="text-muted">{{ $probe->latestCheck?->status }}</span>
                        </td>
                        <td>{{$probe->latestCheck?->time ? $probe->latestCheck?->time .'ms' : ''}}</td>
                        <td class="align-middle text-end">
                            <a href="{{route('probes.edit', $probe)}}" class="btn btn-primary btn-sm display-on-row-hover" title="Edit">
                                <i class="bi-pencil-fill"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>{{ __("You don't have any Probes setup to monitor your services right now. You can add one below") }}</p>
    @endif
    <div class="card shadow-sm p-2">
        <div class="card-body">
            <form action="{{ route('probes.store') }}" method="post">
                @csrf()
                <p> Add a new URL to monitor : </p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                    <input type="text" class="form-control" name="url" placeholder="https://url-to-monitor.com" required>
                    <button class="btn btn-primary" id="basic-addon2">+ Add</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
