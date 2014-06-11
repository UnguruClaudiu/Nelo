<html xmlns="http://www.w3.org/1999/xhtml" lang="ro" xml:lang="ro">
<head>
    <title>{{ $page_title }}</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css" media="all" /> 
	<link rel="stylesheet" href="{{ asset('css/slider.css') }}" type="text/css" media="all" />         	
    <link rel="stylesheet" href="{{ asset('http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css') }}" type="text/css" media="all" />
	
    <script type="text/javascript" src="{{ asset('javascript/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('javascript/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('modal/jquery.fancybox.js?v=2.1.4') }}"></script>                              
    <script type="text/javascript" src="{{ asset('javascript/check_fields.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('javascript/general.js') }}"></script>
    <script type="text/javascript" src="{{ asset('raty-master/lib/jquery.raty.js') }}"></script>
    <script type="text/javascript" src="{{ asset('javascript/stars.js') }}"></script>
	<script type="text/javascript" src="{{ asset('javascript/highcharts.js') }}"></script>
	<script type="text/javascript" src="{{ asset('javascript/exporting.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('modal/jquery.fancybox.css?v=2.1.4') }}" media="screen" />        
</head>
<body>
    <header>
        @section('top')
        
            <?php 
            $user = Session::get('username');
			$admin = Session::get('admin');
            if ($user) { ?>
            <nav>
            	<p>Bun venit <?php echo Session::get('username'); ?>!</p>
            	<ul>
                    <li><a href="{{ asset('home') }}">Acasă</a></li>
                    <li><a href="{{ asset('home/account/' . Session::get('user_id') ) }}">Contul dumneavostră</a></li>
                    @if ($admin == -1)
                    	<li><a href="{{ asset('admin') }}">Pagina de admin</a></li>
                    @endif
                    @if ($admin > 0)
                    	<li><a href="{{ asset('administrator/' . Session::get('user_id') ) }}">Administrare hotel</a></li> 
                    @endif
                    <li><a href="{{ asset('logout') }}">Log out</a></li>
                </ul>
            </nav>
            <?php } else { ?>
            <nav>
            	<ul>
                    <li><a href="{{ asset('home') }}">Acasă</a></li>
                    <li><a href="{{ asset('login') }}">Autentificaţi-vă</a></li>
            	</ul>
            </nav>
            <?php } ?> 
        @show
    </header>
    
    <article>
    	
        @if( isset($ok_message ) )
        @if( $ok_message != '' )
        <div class="msg msg-ok">
            <p>{{ $ok_message or '' }}</p>
        </div>
        @endif
        @endif
        
        @if( isset($error_message ) )
        @if( $error_message != '' )
        <div class="msg msg-error">
            <p>{{ $error_message or '' }}</p>
        </div>
        @endif
        @endif
        @yield('content')
    </article>
	
	<script type='text/javascript' src="{{ asset('javascript/easing.js') }}"></script>
	<script type='text/javascript' src="{{ asset('javascript/respond.js') }}"></script>
	<script type='text/javascript' src="{{ asset('javascript/init.js') }}"></script>
	<script type='text/javascript' src="{{ asset('javascript/swiper-slider.js') }}"></script>
</body>
</html>