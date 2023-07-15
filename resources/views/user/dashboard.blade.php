@if(session('success'))
    <div class="text-success text-center">{{ session('success') }}</div>
@endif

<div class="info">
    @if(auth()->user())
        <div class="text-danger text-center">{{ auth()->user()->name }}</div>
    @endif
</div>