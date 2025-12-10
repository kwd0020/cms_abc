<x-dashboard>
    <h2> All Tenants </h2>

    @if($greeting == "hello")
        <p>Content within directive</p>
    @endif

    <ul>
        @foreach($tenants as $tenant)
            <li>
                <x-card href="/tenants/{{$tenant['tenant_id']}}" :highlight="$tenant['service'] == 'Banking' ">
                    <h3>{{ $tenant["name"]}} , {{$tenant["service"]}} , {{$tenant["tenant_id"]}}</h3>
                </x-card>
            </li>
        @endforeach
    </ul>
</x-dashboard>