<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfCertificateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/certificate', [PdfCertificateController::class, 'generateCertificate']);
Route::get('/add-header-footer-images', [PdfCertificateController::class, 'addHeaderFooterImages']);