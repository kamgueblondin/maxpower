<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        // recuperation de tous les utilisateurs
        $contacts = User::where('id', '!=', auth()->id())->get();

        // on recuper une collection d'elements
        // on compte les méssages non vues
        $vuIds = Message::select(\DB::raw('`user_id` as sender_id, count(`user_id`) as messages_count'))
            ->where('recepteur', auth()->id())
            ->where('vu', false)
            ->groupBy('user_id')
            ->get();

        $contacts = $contacts->map(function($contact) use ($vuIds) {
            $contactvu = $vuIds->where('sender_id', $contact->id)->first();

            $contact->vu = $contactvu ? $contactvu->messages_count : 0;

            return $contact;
        });

        return view('users.chat')->with('contacts',$contacts);
    }

    public function getMessagesFor($id)
    {
        Message::where('user_id', $id)->where('recepteur', auth()->id())->update(['vu' => true]);

        $messages = Message::where(function($q) use ($id) {
            $q->where('user_id', auth()->id());
            $q->where('recepteur', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('user_id', $id);
            $q->where('recepteur', auth()->id());
        })
        ->get();

        return view('users.chat')->with('contacts');
    }

    public function getMessageByUser($id)
    {
        Message::where('user_id', $id)->where('recepteur', auth()->id())->update(['vu' => true]);
        $messages = Message::where(function($q) use ($id) {
            $q->where('user_id', auth()->id());
            $q->where('recepteur', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('user_id', $id);
            $q->where('recepteur', auth()->id());
        })
        ->get();
        $contacts = User::where('id', '!=', auth()->id())->get();

        $vuIds = Message::select(\DB::raw('`user_id` as sender_id, count(`user_id`) as messages_count'))
            ->where('recepteur', auth()->id())
            ->where('vu', false)
            ->groupBy('user_id')
            ->get();

        $contacts = $contacts->map(function($contact) use ($vuIds) {
            $contactvu = $vuIds->where('sender_id', $contact->id)->first();

            $contact->vu = $contactvu ? $contactvu->messages_count : 0;

            return $contact;
        });

        return view('users.chat',['messages'=>$messages,'contacts'=>$contacts,'recepteurM'=>$id]);
    }
    public function refreshMessage($id)
    {
        Message::where('user_id', $id)->where('recepteur', auth()->id())->update(['vu' => true]);
        $messages = Message::where(function($q) use ($id) {
            $q->where('user_id', auth()->id());
            $q->where('recepteur', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('user_id', $id);
            $q->where('recepteur', auth()->id());
        })
        ->get();
        $contacts = User::where('id', '!=', auth()->id())->get();


        return view('partials.message',['messages'=>$messages,'recepteurM'=>$id]);
    }

        public function refreshContact($id)
    {
        $contacts = User::where('id', '!=', auth()->id())->get();
        $vuIds = Message::select(\DB::raw('`user_id` as sender_id, count(`user_id`) as messages_count'))
            ->where('recepteur', auth()->id())
            ->where('vu', false)
            ->groupBy('user_id')
            ->get();

        $contacts = $contacts->map(function($contact) use ($vuIds) {
            $contactvu = $vuIds->where('sender_id', $contact->id)->first();

            $contact->vu = $contactvu ? $contactvu->messages_count : 0;

            return $contact;
        });

        return view('partials.contact',['contacts'=>$contacts,'recepteurM'=>$id]);
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'expediteur' => auth()->user()->name,
            'recepteur' => $request->recepteur,
            'contenu' => $request->contenu,
			'user_id' => auth()->user()->getId(),
        ]);
		$message->save();
		
		return redirect('messages/'.$request->recepteur);
    }
}
