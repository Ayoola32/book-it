@foreach ($categories as $category)
    <h2>{{ $category->name }}</h2>

    @if ($category->subCategories->isEmpty())
        <p><em>No active services</em></p>
    @else
        @foreach ($category->subCategories as $service)
            <h4>{{ $service->name }}</h4>

            @if ($service->employees->isEmpty())
                <p><em>No employees assigned</em></p>
            @else
                @foreach ($service->employees as $employee)
                    @if ($employee->user)
                            <p>Name: {{ $employee->user->name }}</p>
                            <p>Email: {{ $employee->user->email }}</p>
                            <p>Phone: {{ $employee->user->phone }}</p>
                    @endif
                @endforeach
            @endif

        @endforeach
    @endif
@endforeach
