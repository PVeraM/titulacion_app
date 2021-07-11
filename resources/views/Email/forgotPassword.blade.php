@component('mail::message')
# Change Password

@component('mail::button', ['url' => env("FRONT_URL").'/reset-password?token='.$token])
    Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
