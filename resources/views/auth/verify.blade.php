<form method="POST" action="{{ route('verification.verify') }}">
    @csrf
    <input type="hidden" name="user" value="{{ $user }}">
    <label for="code">Введите код:</label>
    <input type="text" name="code" id="code" required>
    @if ($errors->has('code'))
        <div>{{ $errors->first('code') }}</div>
    @endif
    <button type="submit">Подтвердить</button>
</form>