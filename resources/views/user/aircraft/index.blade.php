
    <h1>Aircraft List</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul>
        @foreach($aircrafts as $aircraft)
            <li>{{ $aircraft->aircraft_name }} -
                <a href="{{ route('aircraft.edit', $aircraft) }}">Edit</a>
                - <a href="{{ route('aircraft.show', $aircraft) }}">View</a>
                <form action="{{ route('aircraft.destroy', $aircraft) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

