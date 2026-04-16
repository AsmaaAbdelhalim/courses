<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function downloadCertificate($id)
{
    $result = Result::with('exam.course')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->where('passed', 1)
        ->firstOrFail();

    $data = [
        'user' => Auth::user(),
        'exam' => $result->exam,
        'course' => $result->exam->course,
        'result' => $result,
    ];

    $pdf = Pdf::loadView('certificate.download', $data);

    return $pdf->download('certificate_'.$result->code.'.pdf');
}

}