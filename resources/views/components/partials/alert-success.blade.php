@if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif