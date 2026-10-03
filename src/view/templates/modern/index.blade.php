<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $profile['name'] }} — CV</title>
    <style>{!! $css !!}</style>
</head>
<body>

<div class="header">
    @if($photo)<img class="header__photo" src="{{ $photo }}" alt="">@endif
    <div class="header__title">
        <div class="header__name">{{ mb_strtoupper($profile['name']) }}</div>
        <div class="header__role">{{ $profile['title'] }}</div>
        <div class="header__location">{{ $profile['location'] }}</div>
    </div>
</div>

<div class="sidebar">

    <div class="section">
        <div class="section__title">Contacts</div>
        <div class="section__rule"></div>
        <table>
            @foreach(array_merge($contacts, $socials) as $line)
                {{-- У соцмереж показуємо назву, як у classic, а не голу адресу --}}
                @php($text = ($line['label'] ?? '') ?: $line['text'])
                <tr>
                    <td class="contact__icon">
                        @if($line['iconImage'])
                            <img src="{{ $line['iconImage'] }}" alt="">
                        @else
                            {{ $line['icon'] }}
                        @endif
                    </td>
                    <td class="contact__text">
                        @if(!empty($line['url']))
                            <a href="{{ $line['url'] }}">{{ $text }}</a>
                        @else
                            {{ $text }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
        <div class="section__title">Languages</div>
        <div class="section__rule"></div>
        @foreach($languages as $lang)
            <div class="lang"><span class="lang__name">{{ $lang['name'] }}:</span> {{ $lang['level'] }}</div>
        @endforeach
    </div>

    <div class="section">
        <div class="section__title">Skills</div>
        <div class="section__rule"></div>
        <div class="skills__top">
            @foreach($skills->top() as $skill)
                <div>{{ $skill }}</div>
            @endforeach
        </div>
        <div class="skills__list">
            @foreach($skills->groups() as $group => $items)
                <div class="skills__group-title">{{ $group }}</div>
                <div>{{ implode(', ', $items) }}</div>
            @endforeach
            <div class="skills__group-title">Familiar with</div>
            <div>{{ implode(', ', $skills->familiar()) }}</div>
        </div>
    </div>

</div>

<div class="content">

    <div class="section">
        <div class="section__title">Summary</div>
        <div class="section__rule"></div>
        <div class="summary">{{ $summary }}</div>
    </div>

    <div class="section">
        <div class="section__title">Experience</div>
        <div class="section__rule"></div>
        @foreach($experience as $item)
            <table class="item">
                <tr>
                <td class="item__date">{{ $item['from'] }}<br>{{ $item['to'] }}</td>
                <td class="item__body">
                    <div class="item__dot"></div>
                    <div class="item__role">{{ $item['role'] }}@if($item['company']), {{ $item['company'] }}@endif</div>
                    <div class="item__meta">{{ $item['location'] }}</div>
                    @if(!empty($item['summary']))
                        <div class="item__line">{{ $item['summary'] }}</div>
                    @endif
                    @foreach($item['items'] as $line)
                        <div class="item__line">— {{ $line }}</div>
                    @endforeach
                </td>
                </tr>
            </table>
        @endforeach
    </div>

    <div class="section">
        <div class="section__title">Education</div>
        <div class="section__rule"></div>
        @foreach($education as $item)
            <table class="item">
                <tr>
                <td class="item__date">{{ $item['from'] }}<br>{{ $item['to'] }}</td>
                <td class="item__body">
                    <div class="item__dot"></div>
                    <div class="item__role">{{ $item['degree'] }}</div>
                    <div class="item__meta">{{ $item['school'] }}, {{ $item['location'] }}</div>
                </td>
                </tr>
            </table>
        @endforeach
    </div>

</div>

@if($portfolio)
    <div class="portfolio">
        <div class="portfolio__title">PORTFOLIO</div>

        @foreach($portfolio as $project)
            <div class="project">
                <div class="project__title">{{ $project['title'] }}</div>
                {{-- Картинка чергується ліворуч/праворуч: зигзаг читається легше за стовпчик однакових рядків --}}
                @php($mediaRight = $loop->odd === false)
                <table class="project__body">
                    <tr>
                        @unless($mediaRight)
                            <td class="project__media">
                                @if($project['image'])<img src="{{ $project['image'] }}" alt="">@endif
                            </td>
                        @endunless
                        <td class="project__text">
                            @foreach($project['text'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                            @if($project['stack'])
                                <div class="project__stack"><b>Stack:</b> {{ implode(', ', $project['stack']) }}</div>
                            @endif
                        </td>
                        @if($mediaRight)
                            <td class="project__media project__media--right">
                                @if($project['image'])<img src="{{ $project['image'] }}" alt="">@endif
                            </td>
                        @endif
                        <td class="project__gutter"></td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
@endif

</body>
</html>
