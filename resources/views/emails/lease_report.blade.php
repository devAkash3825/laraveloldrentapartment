<!DOCTYPE html>
<html>
<head>
    <title>New Lease Report Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header { background: #f4f4f4; padding: 10px; border-bottom: 1px solid #ddd; margin-bottom: 20px; }
        .details-row { margin-bottom: 10px; }
        .label { font-weight: bold; width: 200px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Lease Report</h2>
        </div>
        <p>A new lease report has been submitted by <strong>{{ $renter->UserName }}</strong> (Email: {{ $renter->Email }}).</p>
        
        <div class="details-row">
            <span class="label">Name on Lease:</span> {{ $details['username'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">New Address:</span> {{ $details['address'] ?? 'N/A' }} {{ $details['apt'] ?? '' }}
        </div>
        <div class="details-row">
            <span class="label">City/State/Zip:</span> {{ $details['city'] ?? 'N/A' }}, {{ $details['state'] ?? 'N/A' }} {{ $details['zipcode'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Move-in Date:</span> {{ $details['movedate'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Lease Term:</span> {{ $details['lengthlease'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Rent Amount:</span> {{ $details['rentamount'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Community/Landlord:</span> {{ $details['namecommunityorlandlords'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Landlord Phone:</span> {{ $details['landlordtelephone'] ?? 'N/A' }}
        </div>
        <div class="details-row">
            <span class="label">Assisted By:</span> {{ $details['assisted_by'] ?? 'N/A' }}
        </div>

        <p>You can view the full details in the Admin Panel.</p>
    </div>
</body>
</html>
