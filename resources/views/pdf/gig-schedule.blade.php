@extends('pdf.certificate-template')

@section('certificate-content')
    <div class="certificate-content">
        <!-- Your specific certificate content goes here -->
        <h1>Schedule Certificate</h1>
        
        <!-- Add your dynamic content here -->
        @if(isset($data))
            <!-- Example of how to use dynamic data -->
            <div class="details">
                <p><strong>Date:</strong> {{ $data['date'] ?? date('Y-m-d') }}</p>
                <p><strong>Certificate Number:</strong> {{ $data['certificate_number'] ?? '' }}</p>
                <!-- Add more fields as needed -->
            </div>
        @endif
    </div>
@endsection 