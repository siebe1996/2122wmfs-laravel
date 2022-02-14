<!DOCTYPE HTML>
<html>
<head>
    <title>Concertagenda - {{ $concert[0]->title }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]<script src="asset('js/ie/html5shiv.js'}}"></script><![endif]-->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    <!--[if lte IE 8]<link rel="stylesheet" href="asset('css/ie8.css')}}" /><![endif]-->
</head>
<body id="top">

<!-- Header -->
<header id="header">
    <h1><a href="..."><strong>Concertagenda</strong></a></h1>
</header>

<!-- Main -->
<div id="main">
    <!-- Event table -->
    <section id="concert">
        <header class="major">
            <h2>{{ $concert[0]->title }}</h2>
        </header>
        <div class="table-wrapper">
            <table>
                <tbody>
                <tr>
                    <th>Datum</th>
                    <td>{{ $concert[0]->start_date }}</td>
                </tr>
                <tr>
                    <th>Locatie</th>
                    <td>{{ $concert[0]->location }}</td>
                </tr>
                <tr>
                    <th>Prijs</th>
                    <td>
                        {{ $concert[0]->price }} &euro;
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="box alt">
                <div class="row 50% uniform">
                    <div class="4u"><a href="http://localhost/v4/public/concerts/1/images/3" class="image fit thumb"><img src="http://localhost/v4/public/images/tomorrow1.jpg" alt="" /></a></div>
                    <div class="4u"><a href="http://localhost/v4/public/concerts/1/images/4" class="image fit thumb"><img src="http://localhost/v4/public/images/tomorrow2.jpg" alt="" /></a></div>
                </div>
            </div>
            <p><a href="http://localhost/v4/public">Terug naar overzicht</a></p>
        </div>
    </section>
</div>

<!-- Footer -->
<footer id="footer">
    <ul class="icons">
        <li><a href="https://twitter.com/odiseehogesch" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="https://www.facebook.com/odiseehogeschool" class="icon fa-facebook-square"><span class="label">Facebook</span></a></li>
        <li><a href="http://www.odisee.be/" class="icon fa-globe"><span class="label">Website</span></a></li>
        <li><a href="mailto:events@odisee.be" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
    </ul>
    <ul class="copyright">
        <li>&copy; <a href="http://www.ikdoeict.be/" title="IkDoeICT.be">IkDoeICT.be</a></li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
    </ul>
</footer>

<!-- Scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.poptrox.min.js')}}"></script>
<script src="{{asset('js/skel.min.js')}}"></script>
<script src="{{asset('js/util.js')}}"></script>
<!--[if lte IE 8]<script src="asset('js/ie/respond.min.js')}}"></script><![endif]-->
<script src="{{asset('js/main.js')}}"></script>

</body>
</html>
