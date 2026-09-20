<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $profile::NAME }} — CV</title>
    <style>{!! $css !!}</style>
</head>
<body>

<div class="header">
    @if($photo)<img class="header__photo" src="{{ $photo }}" alt="">@endif
    <div class="header__title">
        <div class="header__name">{{ mb_strtoupper($profile::NAME) }}</div>
        <div class="header__role">{{ $profile::TITLE }}</div>
        <div class="header__location">{{ $profile::LOCATION }}</div>
    </div>
</div>

<div class="sidebar">

    <div class="section">
        <div class="section__title">Contacts</div>
        <div class="section__rule"></div>
        <table>
            @foreach(array_merge($contacts, $socials) as $line)
                <tr>
                    <td class="contact__icon">{{ $line['icon'] }}</td>
                    <td class="contact__text">
                        @if(!empty($line['url']))
                            <a href="{{ $line['url'] }}">{{ $line['text'] }}</a>
                        @else
                            {{ $line['text'] }}
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
            @foreach($skills_top as $skill)
                <div>{{ $skill }}</div>
            @endforeach
        </div>
        <div class="skills__list">
            @foreach($skills_groups as $group => $items)
                <div class="skills__group-title">{{ $group }}</div>
                <div>{{ implode(', ', $items) }}</div>
            @endforeach
            <div class="skills__group-title">Familiar with</div>
            <div>{{ implode(', ', $skills_familiar) }}</div>
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

        @foreach($portfolio as $index => $project)
            <table class="project">
                <tr>
                    @if($index % 2 === 0)
                        <td class="project__text">
                            @foreach($project['text'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </td>
                        <td class="project__side">
                            <div class="project__name">{{ $project['title'] }}</div>
                            <div class="project__stack">{{ implode(', ', $project['stack']) }}</div>
                        </td>
                        <td class="project__media">
                            @if($project['image'])<img src="{{ $project['image'] }}" alt="">@endif
                        </td>
                        <td class="project__gutter"></td>
                    @else
                        <td class="project__media project__media--left">
                            @if($project['image'])<img src="{{ $project['image'] }}" alt="">@endif
                        </td>
                        <td class="project__side">
                            <div class="project__name">{{ $project['title'] }}</div>
                            <div class="project__stack">{{ implode(', ', $project['stack']) }}</div>
                        </td>
                        <td class="project__text">
                            @foreach($project['text'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </td>
                        <td class="project__gutter"></td>
                    @endif
                </tr>
            </table>
        @endforeach
    </div>
@endif

</body>
</html>
