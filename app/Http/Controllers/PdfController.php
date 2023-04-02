<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class PdfController extends Controller
{
    public function index()
    {
        try {
            $pdfText = Pdf::getText(public_path() . "/assets/pdf/pdf.pdf", "C:\poppler\bin\pdftotext");
            // Do something with the text
            Log::error($pdfText);
            return view('viewPdf', ['text' => $pdfText]);
        } catch (\Throwable $th) {
            return Log::error($th->getMessage());
        }
    }
}
