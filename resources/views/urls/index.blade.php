<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
                    <td>{{$url->name}}</td>
                    <td>{{$url->url}}</td>
                    <td>{{$url->latestCheck?->status}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
