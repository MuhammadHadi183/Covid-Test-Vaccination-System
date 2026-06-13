<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2>Appointment Confirmed</h2>
    <p>Dear {{ $appointment->patient->user->name ?? 'Patient' }},</p>
    <p>Your appointment has been confirmed. Below are the details of your appointment:</p>
    
    <div style="background-color: #f8fafb; border: 1px solid #e8ecef; border-radius: 8px; padding: 20px; margin: 20px 0;">
        <p><strong>Hospital:</strong> {{ $appointment->hospital->hospital_name ?? 'N/A' }}</p>
        <p><strong>Type:</strong> {{ $appointment->type === 'covid_test' ? 'COVID Test' : 'Vaccination' }}</p>
        <p><strong>Date:</strong> {{ $appointment->appointment_date->format('d F Y') }}</p>
        <p><strong>Time:</strong> {{ $appointment->time_slot ?? 'N/A' }}</p>
        <p><strong>Assigned Doctor:</strong> {{ $appointment->doctor_name ?? 'Not assigned yet' }}</p>
        
        @if($appointment->notes)
            <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
        @endif
    </div>
    
    <p>Please make sure to arrive on time. If you need to cancel or reschedule, please contact the hospital directly.</p>
    <br>
    <p>Regards,<br>Apex Immunity Partners</p>
</body>
</html>
