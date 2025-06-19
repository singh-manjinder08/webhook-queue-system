<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueuedWebhookRequest;
use App\Http\Requests\UpdateQueuedWebhookRequest;
use App\Models\QueuedWebhook;
use App\Events\WebhookDispatched;
use App\Http\Resources\QueuedWebhookResource;

class QueuedWebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return QueuedWebhookResource::collection(QueuedWebhook::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQueuedWebhookRequest $request)
    {
        $webhook = QueuedWebhook::create([
            'transaction_id' => $request->transaction_id,
            'event_type' => $request->event_type,
            'payload' => $request->payload,
        ]);

        event(new WebhookDispatched($webhook));

        return response()->json(['message' => 'Queued webhook created.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(QueuedWebhook $queued_webhook)
    {
        return new QueuedWebhookResource($queued_webhook);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QueuedWebhook $queued_webhook)
    {
        return view('webhooks.edit', compact('queued_webhook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQueuedWebhookRequest $request, QueuedWebhook $queued_webhook)
    {
        $queued_webhook->update($request->validated());

        $queued_webhook->refresh();

        if ($request->wantsJson())
        {
            return response()->json([
                'message' => 'Queued webhook updated successfully.',
                'data' => new QueuedWebhookResource($queued_webhook),
            ]);
        }

        return redirect()->route('webhooks.monitor')->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QueuedWebhook $queued_webhook)
    {
        $queued_webhook->delete();

        return response()->json([
            'message' => 'Queued webhook deleted successfully.'
        ], 200);
    }

    public function monitor()
    {
        $webhooks = QueuedWebhook::latest()->paginate(20);

        return view('webhooks.monitor', compact('webhooks'));
    }
}
