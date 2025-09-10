<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Afficher la page de contact (déjà gérée par la route home)
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Traiter l'envoi du formulaire de contact
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'project_type' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'first_name.required' => 'Le prénom est requis.',
            'last_name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être valide.',
            'project_type.required' => 'Le type de projet est requis.',
            'message.required' => 'Le message est requis.',
            'message.max' => 'Le message ne peut pas dépasser 2000 caractères.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            ContactMessage::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.'
            ], 500);
        }
    }

    /**
     * Afficher la liste des messages de contact (admin)
     */
    public function indexAdmin(Request $request)
    {
        $query = ContactMessage::query();
        
        // Filtrer par statut d'archivage
        if ($request->has('filter') && $request->filter === 'archived') {
            $query->archived();
        } else {
            $query->active(); // Par défaut, afficher seulement les messages actifs
        }
        
        $messages = $query->orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = ContactMessage::active()->unread()->count();
        $archivedCount = ContactMessage::archived()->count();
        
        return view('admin.contact-messages', compact('messages', 'unreadCount', 'archivedCount'));
    }

    /**
     * Marquer un message comme lu
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marqué comme lu'
        ]);
    }

    /**
     * Marquer un message comme non lu
     */
    public function markAsUnread(ContactMessage $message)
    {
        $message->markAsUnread();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marqué comme non lu'
        ]);
    }

    /**
     * Archiver un message
     */
    public function archive(ContactMessage $message)
    {
        $message->archive();
        
        return response()->json([
            'success' => true,
            'message' => 'Message archivé avec succès'
        ]);
    }

    /**
     * Désarchiver un message
     */
    public function unarchive(ContactMessage $message)
    {
        $message->unarchive();
        
        return response()->json([
            'success' => true,
            'message' => 'Message désarchivé avec succès'
        ]);
    }

    /**
     * Obtenir le nombre de messages non lus (pour l'API)
     */
    public function unreadCount()
    {
        $count = ContactMessage::active()->unread()->count();
        
        return response()->json(['count' => $count]);
    }
}