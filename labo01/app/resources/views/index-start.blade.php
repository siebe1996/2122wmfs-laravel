<!DOCTYPE HTML>
<html>
	<head>
		<title>Concertagenda - Overzicht</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="{{asset('css/main.css')}}" />
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
	</head>
	<body id="top">

		<!-- Header -->
			<header id="header">
				<h1><a href="index.php"><strong>Concertagenda</strong></a></h1>
			</header>

		<!-- Main -->
			<div id="main">
				<!-- Event table -->
					<section id="event_table">
						<header class="major">
							<h2>Overzicht concerten</h2>
						</header>
						<form method="get" action="{{ url('concerts') }}">
							<div class="row uniform 50%">
								<div class="6u 12u$(xsmall)"></div>
								<div class="3u 12u$(xsmall)">
									<input type="text" name="search" id="search" value="" placeholder="Zoekterm" />
								</div>
								<div class="3u 12u$(xsmall)">
									<input type="submit" value="Zoeken" class="special fit small" style="height: 3.4em"/>
								</div>
							</div>
						</form>
						<div class="table-wrapper">
                            @if($concerts)
							<table>
								<thead>
									<tr>
										<th>Datum</th>
										<th>Naam en locatie</th>
										<th>Prijs</th>
									</tr>
								</thead>
								<tbody>
                                @foreach($concerts as $concert)
									<tr>
										<td>{{ $concert->start_date }}</td>
										<td>{{ $concert->title }} ({{ $concert->location }})<br/>
											<form method="post" action="{{ url('concerts/'.$concert->id.'/toggle') }}" style="margin: 0">
                                                @csrf
                                                <input type="hidden" name="event_id" value="{{ $concert->id }}" />
												<input type="hidden" name="moduleAction" value="switch" />
												<input type="submit" value="voeg toe aan favorieten" class="small" style="line-height:0em; height: 2em"/>
											</form>
										</td>
										<td>{{ $concert->price }} &euro;</td>
									</tr>
                                @endforeach
								</tbody>
							</table>
                            @else
                            <p>no concerts available</p>
                            @endif
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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>
