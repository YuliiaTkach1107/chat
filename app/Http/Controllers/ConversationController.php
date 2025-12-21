<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\SimpleAskService;

class ConversationController extends Controller
{

    public function __construct(private SimpleAskService $askService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conversations = auth()->user()->conversations()
                        ->with(['messages' => fn($q) => $q->latest()->limit(1)])
                        ->orderBy('updated_at','desc')
                        ->get();

        return Inertia::render('Conversation/Index',[
            'conversations'=>$conversations,
            'meta' => [
                'title' => 'Mes conversations – PsyBot',
                'description' => 'Consultez toutes vos conversations avec PsyBot. Retrouvez et poursuivez vos discussions facilement.',
                'url' => route('conversation.index') // полная ссылка для SSR
    ],
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'first_message' => 'nullable|string',
        ]);
        $conversation = auth()->user()->conversations()->create([
            'title' => $request->title ?? 'Nouvelle conversation',
            'selected_model' => $this->askService::DEFAULT_MODEL, 
        ]);

        if ($request->filled('message')) {
        $conversation->messages()->create([
            'role' => 'user',
            'content' => $request->message,
        ]);
    }
        return redirect()->route('conversation.show',[
            'conversation' => $conversation,
            'autoSend'=>true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);

        $conversations = auth()->user()->conversations()
        ->orderBy('updated_at', 'desc')
        ->get();
        
        $conversation->load([
            'messages' => fn($q) => $q->orderBy('created_at','asc')
        ]);
        // Получаем список моделей
         $askService = app(SimpleAskService::class);
         $models = $askService->getModels(); 

        return Inertia::render('Conversation/Show', [
            'conversations' => $conversations,
            'conversation' => $conversation,
            'messages' => $conversation->messages,
            'models' => $models,
            'selectedModel' => $conversation->selected_model,
            'meta' => [
                'title' => ($conversation->title ?? 'Nouvelle conversation') . ' – PsyBot',
                'description' => 'Continuez votre conversation avec PsyBot. Partagez vos pensées et recevez du soutien psychologique.'
    ]
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Conversation $conversation)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conversation $conversation)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $conversation->update(['title' => $request->title]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
               abort_if($conversation->user_id !== auth()->id(), 403);
               $conversation->messages()->delete();
               $conversation->delete();
               return redirect()->route('conversation.index')
                     ->with('success', 'La conversation a été supprimée avec succès.');
                      
        
    }

    public function selectModel(Request $request){
        $request->validate([
            'selected_model' => 'required|string',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);
        $conversation = Conversation::find($request->conversation_id);
    abort_if($conversation->user_id !== auth()->id(), 403);

    $conversation->selected_model = $request->selected_model;
    $conversation->save();
        return back();
    }

}