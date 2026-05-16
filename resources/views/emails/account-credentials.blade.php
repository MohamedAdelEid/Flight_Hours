@component('mail::message')
# مرحباً {{ $user->name }}

تم إنشاء حسابك في نظام ساعات الطيران بنجاح.

## بيانات تسجيل الدخول

@component('mail::panel')
**البريد الإلكتروني:** {{ $user->email }}

**كلمة المرور:** {{ $password }}
@endcomponent

يمكنك تسجيل الدخول من خلال الرابط التالي:

@component('mail::button', ['url' => route('login')])
تسجيل الدخول
@endcomponent

> **تنبيه هام:** يرجى تغيير كلمة المرور بعد تسجيل الدخول لأول مرة للحفاظ على أمان حسابك.

إذا لم تقم بإنشاء هذا الحساب، يرجى التواصل مع الإدارة فوراً.

شكراً،<br>
{{ config('app.name') }}
@endcomponent