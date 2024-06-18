<x-mail::message>
# Order Shipped

Your Profile has been updated

<x-mail::button :url="$url">
Verify Update
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
