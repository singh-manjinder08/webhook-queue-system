@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Queued Webhooks</h2>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Transaction ID</th>
                <th>Event Type</th>
                <th>Status</th>
                <th>Retry Attempts</th>
                <th>Last Attempt</th>
                <th>Response Log</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($webhooks as $webhook)
                <tr>
                    <td>{{ $webhook->id }}</td>
                    <td>{{ $webhook->transaction_id }}</td>
                    <td>{{ $webhook->event_type }}</td>
                    <td>
                        <span class="badge bg-{{ match($webhook->status) {
                            'pending' => 'warning',
                            'inprogress' => 'info',
                            'hold' => 'secondary',
                            'failed' => 'danger',
                            default => 'success',
                        } }}">
                            {{ ucfirst($webhook->status) }}
                        </span>
                    </td>
                    <td>{{ $webhook->retry_attempts }}</td>
                    <td>{{ $webhook->last_attempt_at ?? '-' }}</td>
                    <td>
                       @if ($webhook->response_log)
                            <details>
                                <summary class="cursor-pointer text-blue-600 hover:underline">View Response Log</summary>
                                <pre class="bg-gray-100 p-2 rounded mt-2 text-sm text-gray-800 overflow-auto">
                        {{ json_encode($webhook->response_log, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                </pre>
                            </details>
                        @else
                            <span class="text-gray-500">None</span>
                        @endif

                    </td>
                    <td>{{ $webhook->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('queued-webhooks.edit', $webhook->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No queued webhooks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination (if needed) -->
    <div class="d-flex justify-content-center">
        {{ $webhooks->links() }}
    </div>
@endsection
