<?php

namespace App\Http\Controllers;

use App\Mail\CorreoBoleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function enviarBoleta(Request $request)
    {

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'pdf_data' => 'required|string',
            'correo' => 'required|email',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Datos de entrada inválidos.', 'errors' => $validator->errors()], 400);
        }
        
        $pdfData = $request->input('pdf_data');
        $recipientEmail = $request->input('correo');
        
        try {
            $fileName = 'boleta.pdf';
            
            // Send the email
            Mail::to($recipientEmail)->send(new CorreoBoleta($pdfData, $fileName));

            return response()->json(['success' => true, 'message' => 'PDF enviado por correo electrónico con éxito!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al enviar el PDF: ' . $e->getMessage()], 500);
        }
    }
}
