@if (session('message'))
<div class="alert-messages">
  <div class="alert alert-{{ session('status') !== null ? session('status') : 'info' }}">
    {{ session('message') }}
  </div>
</div>
@endif
