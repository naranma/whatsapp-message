<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return view('message.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $message = new Message();
        $message->fill($request->input());
        $message->save();

        return redirect()->route('message.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::find($id);
        return view('message.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }


    public function start($id)
    {
        $message = Message::find($id);
        $ws = new \App\Services\WhatsappService();
        $path = './storage/app/chrome/Profile-' . $message->id;
        $ws->create($path);

        $message->session_id = $ws->getSessionID();
        $message->save();

        return redirect()->back();
    }
    public function stop($id)
    {
        $message = Message::find($id);
        if($message->session_id){
            $ws = new \App\Services\WhatsappService();
            $ws->createBySessionID($message->session_id);
            $ws->close();
        }

        $message->session_id = '';
        $message->save();
        
        return redirect()->back();
    }
    public function clear($id)
    {
        
    }

    public function createWhatsapp($id)
    {
        $image = null;
        $message = Message::find($id);

        if($message->session_id){
            $ws = new \App\Services\WhatsappService();
            $ws->createBySessionID($message->session_id);
            $ws->createWhatsappSession();
            $image = $ws->getWhatsappQRCodeBase64();
        }

        return view('message.qrcode', compact('message', 'image'));
    }

    public function getWhatsappQRCode($id)
    {
        $image = null;
        $message = Message::find($id);

        if($message->session_id){
            $ws = new \App\Services\WhatsappService();
            $ws->createBySessionID($message->session_id);
            $image = $ws->getWhatsappQRCodeBase64();
        }

        return view('message.qrcode', compact('message', 'image'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);

        $message = Message::find($id);

        if($message->session_id){
            $ws = new \App\Services\WhatsappService();
            $ws->createBySessionID($message->session_id);
            $ws->sendMessage($request->phone, $request->message);
        }

        return redirect()->back();

    }



}
