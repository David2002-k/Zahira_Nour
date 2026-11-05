<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = Message::query()
            ->with('client.user')
            ->latest()
            ->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message): View
    {
        $message->load(['client.user', 'reponses.admin.user']);

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => ['required', Rule::in(['non_lu', 'lu', 'traite'])],
        ]);

        $message->update(['statut' => $validated['statut']]);

        return to_route('admin.messages.show', $message)
            ->with('success', 'Statut du message mis à jour.');
    }

    public function reply(Request $request, Message $message): RedirectResponse
    {
        $validated = $request->validate([
            'contenu' => ['required', 'string', 'max:10000'],
        ]);
        $admin = Admin::query()->firstOrCreate([
            'user_id' => $request->user()->getKey(),
        ]);

        $message->reponses()->create([
            'admin_id' => $admin->getKey(),
            'contenu' => $validated['contenu'],
        ]);
        $message->update(['statut' => 'traite']);

        return to_route('admin.messages.show', $message)
            ->with('success', 'Réponse envoyée.');
    }
}
