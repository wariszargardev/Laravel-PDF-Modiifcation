<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Response;

class PdfCertificateController extends Controller
{
    public function generateCertificate()
    {
        $pdf = new Fpdi('L'); // 'L' = Landscape

        // Load source PDF template (ensure the file exists in storage/app/public or wherever appropriate)
        $templatePath = public_path('certificate.pdf');
        $pagecount = $pdf->setSourceFile($templatePath);

        $tpl = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($tpl);

        $pdf->SetFont('Helvetica');

        // Name
        $pdf->SetFontSize(30);
        $pdf->SetXY(10, 89);
        $pdf->Cell(0, 10, 'Muhammad Waris', 0, 0, 'C');

        // Reason
        $pdf->SetFontSize(20);
        $pdf->SetXY(80, 105);
        $pdf->Cell(150, 10, 'Full Stack Laravel & Vue.js Developer', 0, 0, 'C');

        // Date
        $pdf->SetFontSize(20);
        $pdf->SetXY(118, 122);
        $pdf->Cell(20, 10, date('d'), 0, 0, 'C');

        $pdf->SetXY(160, 122);
        $pdf->Cell(30, 10, date('M'), 0, 0, 'C');

        $pdf->SetXY(200, 122);
        $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

        // Output PDF to browser
        return response($pdf->Output('S', 'certificate.pdf'))
            ->header('Content-Type', 'application/pdf');
    }


    public function addHeaderFooterImagesDownload()
    {
        $sourcePdf = public_path('gigCertificate.pdf'); 
        $outputPdf = public_path('updated_with_images.pdf');

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourcePdf);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Add header image
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 10, 10, $size['width'] - 20); // adjust X, Y, Width

            // Add footer image
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 10, $size['height'] - 30, $size['width'] - 20); // adjust as needed
        }

        $pdf->Output($outputPdf, 'F');

        return response()->download($outputPdf);
    }

    
    public function addHeaderFooterImages()
    {
        $sourcePdf = public_path('samplePDF.pdf'); 
        // $outputPdf = public_path('updated_with_images.pdf');

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourcePdf);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Add header image
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 10, 10, $size['width'] - 20); // adjust X, Y, Width

            // Add footer image
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 10, $size['height'] - 30, $size['width'] - 20); // adjust as needed
        }

        // $pdf->Output($outputPdf, 'F');

        return response($pdf->Output('S', 'certificate.pdf'))
            ->header('Content-Type', 'application/pdf');
    }

}
