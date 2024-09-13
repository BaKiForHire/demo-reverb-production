@component('mail::message')
# Auction Update

An update has been made to the auction: **{{ $auction->title }}**.

@component('mail::button', ['url' => route('auctions.show', $auction->id)])
View Auction
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
