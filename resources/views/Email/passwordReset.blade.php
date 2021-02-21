@component('mail::message')
# Reset hasła w systemie wypożyczeń samochodów zastępczych

Kliknij przycisk poniżej, aby przejść do zmiany hasła.

@component('mail::button', ['url' => 'http://localhost:4200/changepassword?token='.$token->token])
Resetuj hasło
@endcomponent


@endcomponent

