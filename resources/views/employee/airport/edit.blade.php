
    <h1>Edit Airport</h1>
    <form action="{{ route('airport.update', $airport) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="airport_name">Name:</label>
        <input type="text" id="airport_name" name="airport_name" value="{{ $airport->airport_name }}">
        @error('airport_name')
        <div>{{ $message }}</div>
        @enderror
        <label for="airport_code">Code:</label>
        <input type="text" id="airport_code" name="airport_code" value="{{ $airport->airport_code }}">
        @error('airport_code')
        <div>{{ $message }}</div>
        @enderror
        <button type="submit">Update</button>
    </form>

