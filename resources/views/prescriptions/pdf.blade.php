<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription - {{ $prescription->patient->patient_name ?? 'Patient' }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        body {
            font-family: 'Helvetica Neue', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .prescription-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #0056b3;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .doctor-info h1 {
            margin: 0 0 5px 0;
            color: #0056b3;
            font-size: 24px;
            font-weight: 700;
        }
        .doctor-info .degrees {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .doctor-info .details {
            font-size: 13px;
            color: #555;
            line-height: 1.8;
        }
        .clinic-logo {
            text-align: right;
        }
        .prescription-title {
            text-align: center;
            font-size: 18px;
            color: #0056b3;
            font-weight: 600;
            margin: 20px 0;
            letter-spacing: 2px;
        }
        .patient-section {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            border-left: 4px solid #0056b3;
        }
        .patient-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .patient-section td {
            padding: 5px 15px 5px 0;
            font-size: 14px;
        }
        .patient-section .label {
            color: #666;
            font-weight: 600;
            width: 100px;
        }
        .rx-section {
            margin: 40px 0;
        }
        .rx-symbol {
            font-size: 60px;
            color: #0056b3;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .medicines-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .medicines-table th {
            background: #0056b3;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }
        .medicines-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .medicines-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .timing-badges {
            display: flex;
            gap: 5px;
        }
        .timing-badge {
            background: #e3f2fd;
            color: #0056b3;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        .section {
            margin: 30px 0;
        }
        .section-title {
            font-size: 16px;
            color: #0056b3;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }
        .badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .badge {
            background: #e3f2fd;
            color: #0056b3;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
        }
        .signature-section {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            border-top: 2px solid #333;
            padding-top: 8px;
            width: 250px;
            text-align: center;
        }
        .signature-name {
            font-weight: 600;
            color: #333;
        }
        .signature-details {
            font-size: 12px;
            color: #666;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #888;
        }
        .prescription-id {
            text-align: center;
            font-size: 11px;
            color: #aaa;
            margin-top: 20px;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <!-- Header with Doctor Info -->
        <div class="header">
            <div class="doctor-info">
                <h1>Dr. {{ $prescription->doctor->name ?? 'N/A' }}</h1>
                @if($prescription->doctor->degrees)
                    <div class="degrees">{{ implode(', ', json_decode($prescription->doctor->degrees, true) ?? []) }}</div>
                @endif
                <div class="details">
                    @if($prescription->doctor->license)
                        <div>License #: {{ $prescription->doctor->license }}</div>
                    @endif
                    @if($prescription->doctor->email)
                        <div>Email: {{ $prescription->doctor->email }}</div>
                    @endif
                    @if($prescription->doctor->phone)
                        <div>Phone: {{ $prescription->doctor->phone }}</div>
                    @endif
                    @if($prescription->doctor->address)
                        <div>Address: {{ $prescription->doctor->address }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="prescription-title">PRESCRIPTION</div>

        <!-- Patient Information -->
        <div class="patient-section">
            <table>
                <tr>
                    <td class="label">Patient Name:</td>
                    <td><strong>{{ $prescription->patient->patient_name ?? 'N/A' }}</strong></td>
                    <td class="label">Age:</td>
                    <td>{{ $prescription->patient->age ?? 'N/A' }} years</td>
                </tr>
                <tr>
                    <td class="label">Sex:</td>
                    <td>{{ ucfirst($prescription->patient->sex ?? 'N/A') }}</td>
                    <td class="label">Date:</td>
                    <td>{{ $prescription->created_at->format('d M Y') }}</td>
                </tr>
                @if($prescription->patient->unique_id)
                <tr>
                    <td class="label">Patient ID:</td>
                    <td colspan="3">{{ $prescription->patient->unique_id }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Rx Symbol -->
        <div class="rx-section">
            <div class="rx-symbol">Rx</div>

            <!-- Medicines Table -->
            @if($prescription->medicines)
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Medicine</th>
                            <th style="width: 20%;">Dosage</th>
                            <th style="width: 30%;">Timing</th>
                            <th style="width: 20%;">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(json_decode($prescription->medicines, true) ?? [] as $medicine)
                            <tr>
                                <td><strong>{{ $medicine['name'] ?? 'N/A' }}</strong></td>
                                <td>{{ $medicine['dosage'] ?? 'N/A' }}</td>
                                <td>
                                    @if(isset($medicine['time']['value']) && is_array($medicine['time']['value']))
                                        <div class="timing-badges">
                                            @foreach($medicine['time']['value'] as $time)
                                                <span class="timing-badge">{{ ucfirst($time) }}</span>
                                            @endforeach
                                        </div>
                                        @if(isset($medicine['time']['display']))
                                            <div style="font-size: 11px; color: #888; margin-top: 3px;">{{ $medicine['time']['display'] }}</div>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $medicine['duration']['display'] ?? ($medicine['duration'] ?? 'N/A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Problems Section -->
        @if($prescription->problem)
            @php $problems = json_decode($prescription->problem, true) ?? []; @endphp
            @if(count($problems) > 0)
                <div class="section">
                    <div class="section-title">Problems / Diagnosis</div>
                    <div class="badges">
                        @foreach($problems as $problem)
                            <span class="badge">{{ $problem }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <!-- Tests Section -->
        @if($prescription->tests)
            @php $tests = json_decode($prescription->tests, true) ?? []; @endphp
            @if(count($tests) > 0)
                <div class="section">
                    <div class="section-title">Recommended Tests</div>
                    <div class="badges">
                        @foreach($tests as $test)
                            <span class="badge">{{ $test }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <!-- Doctor Signature -->
        <div class="signature-section">
            <div class="signature-line">
                <div class="signature-name">Dr. {{ $prescription->doctor->name ?? 'N/A' }}</div>
                @if($prescription->doctor->degrees)
                    <div class="signature-details">{{ implode(', ', json_decode($prescription->doctor->degrees, true) ?? []) }}</div>
                @endif
                @if($prescription->doctor->license)
                    <div class="signature-details">License #: {{ $prescription->doctor->license }}</div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>
                @if($prescription->doctor->phone)
                    Phone: {{ $prescription->doctor->phone }}
                @endif
            </div>
            <div>
                @if($prescription->doctor->email)
                    {{ $prescription->doctor->email }}
                @endif
            </div>
        </div>

        <!-- Prescription ID -->
        <div class="prescription-id">
            Prescription ID: #{{ $prescription->id }} | Generated on {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>
</body>
</html>
