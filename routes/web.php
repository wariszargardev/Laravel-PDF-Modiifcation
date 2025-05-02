<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfCertificateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/certificate', [PdfCertificateController::class, 'generateCertificate']);
Route::get('/add-header-footer-images', [PdfCertificateController::class, 'addHeaderFooterImages']);


// PDF Certificate Routes
Route::get('/certificate/preview', [PdfCertificateController::class, 'previewCertificate'])->name('certificate.preview');
Route::get('/certificate/generate', [PdfCertificateController::class, 'addHeaderFooterImages'])->name('certificate.generate');
Route::get('/certificate/generate-with-content', [PdfCertificateController::class, 'addHeaderFooterImagesWithContent'])->name('certificate.generate.with.content');
