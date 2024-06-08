
    <h1>Edit Aircraft</h1>
    <form action="{{ route('aircraft.update', $aircraft) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="aircraft_name">Name:</label>
        <input type="text" id="aircraft_name" name="aircraft_name" value="{{ $aircraft->aircraft_name }}">
        @error('aircraft_name')
        <div>{{ $message }}</div>
        @enderror
        <label for="aircraft_code">Code:</label>
        <input type="text" id="aircraft_code" name="aircraft_code" value="{{ $aircraft->aircraft_code }}">
        @error('aircraft_code')
        <div>{{ $message }}</div>
        @enderror
        <button type="submit">Update</button>
    </form>

