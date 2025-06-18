@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Queued Webhook</h2>

    <form method="POST" action="{{ route('webhooks.update', $queued_webhook) }}">
        @csrf
        @method('PUT')

        <a href="{{ route('webhooks.monitor') }}" class="btn btn-secondary mt-3">Back to Monitor</a>
        <input type="hidden" name="last_attempt_at" value="{{ now() }}">

        <div class="mb-3">
            <label for="status">Status</label>

            <select name="status" class="form-control" required>
                <option value="pending" {{ $queued_webhook->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="inprogress" {{ $queued_webhook->status === 'inprogress' ? 'selected' : '' }}>In Progress</option>
                <option value="hold" {{ $queued_webhook->status === 'hold' ? 'selected' : '' }}>Hold</option>
                <option value="pending" {{ $queued_webhook->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ $queued_webhook->status === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="retry_attempts">Retry Attempts</label>
            <input type="number" class="form-control" name="retry_attempts" value="{{ $queued_webhook->retry_attempts }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
