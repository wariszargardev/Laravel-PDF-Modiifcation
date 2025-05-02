<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use setasign\Fpdi\Fpdi;
use Barryvdh\DomPDF\Facade\Pdf;

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

    
    public function addHeaderFooterImages($data = [])
    {
        // First generate the HTML content from blade
        $html = View::make('pdf.gig-schedule', compact('data'))->render();
        
        // Create temporary PDF from HTML
        $tempPdf = public_path('temp_gigSchedule.pdf');
        PDF::loadHTML($html)->save($tempPdf);

        // Now process with FPDI
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($tempPdf);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Add header image
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 0, 0, $size['width']);

            // Add footer image
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 0, $size['height'] - 30, $size['width']);
        }

        // Clean up temporary file
        if (file_exists($tempPdf)) {
            unlink($tempPdf);
        }

        return response($pdf->Output('S', 'certificate.pdf'))
            ->header('Content-Type', 'application/pdf');
    }


    
    public function addHeaderFooterImagesOld($data = [])
    {
        // First generate the HTML content from blade
        $html = View::make('pdf.gig-schedule', compact('data'))->render();
        
        // Create temporary PDF from HTML
        $tempPdf = public_path('temp_gigSchedule.pdf');
        PDF::loadHTML($html)->save($tempPdf);

        // Now process with FPDI
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($tempPdf);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Add header image
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 0, 0, $size['width']);

            // Add footer image
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 0, $size['height'] - 30, $size['width']);
        }

        // Clean up temporary file
        if (file_exists($tempPdf)) {
            unlink($tempPdf);
        }

        return response($pdf->Output('S', 'certificate.pdf'))
            ->header('Content-Type', 'application/pdf');
    }

    // Add a method to preview the certificate
    public function previewCertificate($data = [])
    {
        return view('pdf.gig-schedule', compact('data'));
    }

    public function addHeaderFooterImagesWithContent($data = [])
    {
        // Generate HTML content from blade for before and after sections
        $beforeHtml = View::make('pdf.gig-schedule', compact('data'))->render();
        $afterHtml = View::make('pdf.gig-schedule', compact('data'))->render();
        
        // Create temporary PDFs from HTML
        $beforePdf = public_path('temp_before.pdf');
        $afterPdf = public_path('temp_after.pdf');
        PDF::loadHTML($beforeHtml)->save($beforePdf);
        PDF::loadHTML($afterHtml)->save($afterPdf);

        // Load source PDF
        $sourcePdf = public_path('samplePDF.pdf');
        
        // Create final PDF
        $pdf = new Fpdi();
        
        // Add pages from before PDF
        $beforePageCount = $pdf->setSourceFile($beforePdf);
        for ($pageNo = 1; $pageNo <= $beforePageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            // Add header and footer to each page
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 0, 0, $size['width']);
            
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 0, $size['height'] - 30, $size['width']);
        }
        
        // Add pages from source PDF
        $sourcePageCount = $pdf->setSourceFile($sourcePdf);
        for ($pageNo = 1; $pageNo <= $sourcePageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            // Add header and footer to each page
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 0, 0, $size['width']);
            
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 0, $size['height'] - 30, $size['width']);
        }
        
        // Add pages from after PDF
        $afterPageCount = $pdf->setSourceFile($afterPdf);
        for ($pageNo = 1; $pageNo <= $afterPageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            // Add header and footer to each page
            $headerPath = public_path('Header.png');
            $pdf->Image($headerPath, 0, 0, $size['width']);
            
            $footerPath = public_path('Footer.png');
            $pdf->Image($footerPath, 0, $size['height'] - 30, $size['width']);
        }

        // Clean up temporary files
        if (file_exists($beforePdf)) {
            unlink($beforePdf);
        }
        if (file_exists($afterPdf)) {
            unlink($afterPdf);
        }

        return response($pdf->Output('S', 'certificate.pdf'))
            ->header('Content-Type', 'application/pdf');
    }
}
