<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $profile::NAME }} — CV</title>
    <style>{!! $css !!}</style>
</head>
<body>

<table>
    <tr>
        <td class="header__photo">
            @if($photo)<img src="{{ $photo }}" alt="">@endif
        </td>
        <td class="header__main">
            <div class="header__name">{{ mb_strtoupper($profile::NAME) }}</div>
            <div class="header__role">{{ mb_strtoupper($profile::TITLE) }}</div>
            <div class="header__contacts">
                {{ $profile::LOCATION }} |
                <a href="mailto:{{ $profile::EMAIL }}">{{ $profile::EMAIL }}</a> |
                {{ $profile::PHONE }} |
                @foreach($socials as $social)
                    <a href="{{ $social['url'] }}">{{ $social['label'] }}</a>@if(!$loop->last) | @endif
                @endforeach
            </div>
        </td>
    </tr>
</table>

<div class="section">
    <div class="section__title">PROFESSIONAL SUMMARY</div>
    <div class="summary">{{ $summary }}</div>
</div>

<div class="section">
    <div class="section__title">SKILLS</div>
    <table class="skills">
        <tr>
            @foreach($skill::columns(6) as $column)
                <td>
                    @foreach($column as $item)
                        <div>• {{ $item }}</div>
                    @endforeach
                </td>
            @endforeach
        </tr>
    </table>
</div>

<div class="section">
    <div class="section__title">LANGUAGES</div>
    <div class="languages">
        @foreach($languages as $lang)
            <span><b>{{ $lang['name'] }}:</b> {{ $lang['level'] }}</span>
        @endforeach
    </div>
</div>

<div class="section">
    <div class="section__title">PROFESSIONAL EXPERIENCE</div>
    @foreach($experience as $item)
        <div class="entry">
            <table class="entry__head">
                <tr>
                    <td class="entry__title">{{ $item['role'] }}@if($item['company']), {{ $item['company'] }}@endif</td>
                    <td class="entry__meta">{{ $item['location'] }}, {{ $item['from'] }} to {{ $item['to'] }}</td>
                </tr>
            </table>
            @if(!empty($item['summary']))
                <div class="entry__text">{{ $item['summary'] }}</div>
            @endif
            @foreach($item['items'] as $line)
                <div class="entry__line">- {{ $line }}</div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="section">
    <div class="section__title">EDUCATION</div>
    @foreach($education as $item)
        <div class="entry">
            <table class="entry__head">
                <tr>
                    <td class="entry__title">{{ $item['school'] }}, {{ $item['degree'] }}, {{ $item['location'] }}</td>
                    <td class="entry__meta">{{ $item['from'] }} to {{ $item['to'] }}</td>
                </tr>
            </table>
        </div>
    @endforeach
</div>

</body>
</html>
