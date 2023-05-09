<html lang="ua">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=UTF-8">
    <title>CV</title>
    <link rel="stylesheet" href="./src/resources/css/styles.css"/>
</head>
<body>
    <table class="main_table">
        <tr class="head">
            <td>
                <img src="./src/resources/img/my_photo.jpg" width="220">
            </td>
            <td>
                <div class="title">
                    <div>
                        <h4 >YURII TYMCHUCK</h4>
                        <h3>Senior Full-Stack Developer</h3>
                        <h4>Php (Laravel + VueJS)</h4>
                    </div>
                </div>
            </td>
        </tr>
        <tr valign="top">
            <td class="left-menu">
                <div class="contacts menu-block">
                    <div class="contacts__phone">+34 613 46 46 99</div>
                    <div class="contacts__email">Yurich84@gmail.com</div>
                    <div class="contacts__tg">Yurich84</div>
                    <div class="contacts__skype">Yurkoo008</div>
                    <div class="contacts__address">Spain, Santa-Cruz-de-Tenerife</div>
                    <div class="contacts__ln">https://linkedin.com/in/yuriy-timchuk</div>
                    <div class="contacts__dev">https://dev.to/yurich84</div>
                    <div class="contacts__github">https://github.com/Yurich84</div>
                </div>
                <div class="languages menu-block">
                    @foreach($languages as $lang)
                        <div>{{ $lang['name'] }}: {{ $lang['level'] }}</div>
                    @endforeach
                </div>
                <div class="skills menu-block">
                    <div class="skills__main-stack">
                        <h5>Main Stack</h5>
                        @foreach($skills_top as $skill)
                            <div>{{ $skill }}</div>
                        @endforeach
                    </div>
                    <div class="skills__stack">
                        <h5>All Skills</h5>
                        @foreach($skills_main as $skill)
                            <div>{{ $skill }}</div>
                        @endforeach
                    </div>
                    <div class="skills__familiar">
                        <h5>Familiar with</h5>
                        @foreach($skills_familiar as $skill)
                            <div>{{ $skill }}</div>
                        @endforeach
                    </div>
                </div>
            </td>
            <td class="main_content">
                <div class="experience">
                    <h3>Experience</h3>
                    @foreach($experience as $item)
                        <div class="experience__block main-block">
                            <div class="main-block__date">{{ $item['from'] }} - {{ $item['to'] }}</div>
                            <div class="main-block__delimiter"></div>
                            <div class="main-block__content">
                                <div class="main-block__role">{{ $item['role'] }}</div>
                                <div class="main-block__company">{{ $item['company'] }}</div>
                                <div class="main-block__description">
                                    {!! $item['description'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="education">
                    <h3>Education</h3>
                    @foreach($education as $item)
                        <div class="education__block main-block">
                            <div class="main-block__date">{{ $item['from'] }} - {{ $item['to'] }}</div>
                            <div class="main-block__delimiter"></div>
                            <div class="main-block__content">
                                <div class="main-block__role">{{ $item['role'] }}</div>
                                <div class="main-block__description">
                                    {{ $item['description'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
