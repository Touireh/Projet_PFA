<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User; // Importez le modèle User si ce n'est pas déjà fait
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class CourrierController extends Controller

{
    public function showSendCourrierForm()
    {
        return view('sendcourrier');
    }
    public function sendCourrier(Request $request)
    {
        $sender = Auth::user(); // Utilisateur qui envoie le courrier
        $recipientEmail = $request->input('recipient_email');
        $recipient = User::where('email', $recipientEmail)->first();
       // $recipient = User::find($request->input('recipient_id')); // Utilisateur destinataire
    
        $courrier = new Courrier();
        $courrier->sender()->associate($sender);
        if ($recipient) {
            $courrier->recipient()->associate($recipient);
        } else {
            return redirect()->back()->withErrors(['recipient_email' => 'Invalid recipient email.']);
        }
       // $courrier->recipient()->associate($recipient);
        $courrier->subject = $request->input('subject');
        $courrier->content = $request->input('content');
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('courrier_files'); // Emplacement où les fichiers seront stockés
    
            $courrier->file_path = $filePath;
        }
    
        $courrier->save();
        return redirect()->back()->with('success', 'Le courrier a été envoyé avec succès !');
    }

    public function inbox()
    {
        $user = Auth::user(); // Utilisateur connecté
        $receivedMessages = Courrier::where('recipient_id', $user->id)->get();
    
        return view('inbox', ['receivedMessages' => $receivedMessages]);

    }
    public function deleteMessages(Request $request)
    {
        // Récupérer les ID des messages sélectionnés à supprimer
        $messageIds = $request->input('messages');

        // Supprimer les messages de la base de données (ou déplacer vers la corbeille)
        // par exemple, en utilisant la méthode delete() sur le modèle Courrier
        Courrier::whereIn('id', $messageIds)->delete();

        // Rediriger vers la page de la boîte de réception avec un message de succès
        return Redirect::route('inbox')->with('success', 'Les messages ont été supprimés avec succès.');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search_query');
        
        // Perform the search query using your desired logic
        $receivedMessages = Courrier::where('subject', 'like', '%'.$searchQuery.'%')
                                    ->orWhere('content', 'like', '%'.$searchQuery.'%')
                                    ->get();
        
        return view('mailbox.index', compact('receivedMessages'));
    }

    
    public function logout()
    {   
        auth()->logout();
        return redirect()->route('getLogin')->with('success','You have been successfully logged out ');
    }
}
