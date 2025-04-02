@component('mail::message')
# Сброс пароля

Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.

@component('mail::button', ['url' => config('app.frontend_url') . '/reset-password?token=' . $token])
Сбросить пароль
@endcomponent

Если вы не запрашивали сброс пароля, никаких дополнительных действий не требуется.

С уважением,<br>
{{ config('app.name') }}
@endcomponent