<div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
            <span class="bi bi-check-circle-fill"></span>
            <div>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
            <span class="bi bi-exclamation-triangle-fill"></span>
            <div>
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>

