<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarrantySupportMail;

class MailController extends Controller
{
    public function sendWarrantySupportEmail(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'productName' => 'required|string',
            'requestPurpose' => 'required|string',
        ]);

        try {
            $toEmail = config('mail.from.address'); 
            Mail::to($toEmail)->send(new WarrantySupportMail($request->all()));

            return response()->json(['message' => 'Gửi thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gửi thất bại', 'error' => $e->getMessage()]);
        }
    }
}
