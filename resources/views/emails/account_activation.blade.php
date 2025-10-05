@component('mail::message')

<h1>Thank you for registering!</h1>

Dear {{ $username }}, please use the link below to log in to your account.

<a href="https://app.houser.loc/login">https://app.houzer.loc/login</a>

Your login is your email.<br>
Your password is: {{ $password }}

@endcomponent
