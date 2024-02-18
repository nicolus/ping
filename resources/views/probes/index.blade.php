<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1>Hello</h1>
    <div x-data="urls" @urlUpdate.window="updateUrl($event)">
        <template x-if="urls.length > 0">
            <div class="card shadow-sm my-4">
                <table class="table mb-0 table-striped table_borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">URL</th>
                            <th scope="col">Status</th>
                            <th scope="col">Time</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <template x-for="url in urls">
                        <tr>
                            <td class="align-middle ps-3" x-text="url.name"></td>
                            <td class="align-middle" x-text="url.url"></td>
                            <td class="align-middle">
                                <template x-if="url.latest_check?.status">
                                    <span class="badge" :class="url.latest_check.status < 300 ? 'bg-success' : 'bg-danger'" x-text="url.latest_check.status" ></span>
                                </template>
                                <template x-if="!url.latest_check?.status">
                                    <span class="badge bg-danger" >error</span>
                                </template>
                            </td>
                            <td x-text="url.latest_check?.time ? url.latest_check?.time + 'ms' : ''"></td>
                            <td x-text="url.created_ago"></td>
                            <td class="align-middle text-end">
                                <a :href="url.edit_link" class="btn btn-primary btn-sm display-on-row-hover" title="Edit">
                                    <i class="bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <div x-text="url.name"></div>
                    </template>
                    </tbody>
                </table>
            </div>
        </template>
    </div>
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('urls', () => ({
                urls: [],
                async init() {
                    this.urls = (await (await fetch('/api/urls')).json()).data;
                    this.updateTimeForAllUrls();
                    window.setInterval(async () => {
                        this.updateTimeForAllUrls();
                    }, 1000);
                    Echo.private(`App.Models.User.1`).notification((e) => {
                        if (e.type === 'App\\Notifications\\CheckNotification'){
                            this.updateUrl(e.probe)
                        }
                    });
                },
                updateTimeForAllUrls() {
                    this.urls.forEach((url) => {
                        this.updateTimeUrl(url);
                    })
                },
                updateTimeUrl(url) {
                    let timeFormatter = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });
                    url.created_ago = timeFormatter.format(Math.round((Date.parse(url.latest_check.created_at) - Date.now())/1000), 'seconds');
                },
                updateUrl(url) {
                    let index = this.urls.findIndex(u => u.id === url.id);
                    if (index >= 0) {
                        this.urls[index] = url;
                        this.urls[index].created_ago = 'Just now';
                    }
                }
            }))
        });
    </script>
</x-app-layout>