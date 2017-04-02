<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("css/home.css") }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .top-left {
                position: absolute;
                top: 18px;
                left: 10px;
            }
            .top-left.links > a {
                font-size: 20px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-left links">
                    <a href="{{ url('/') }}">Mazad</a>
                </div>
                <div class="top-right links">
                        <a href="#search">Search</a>
                        <a href="{{ url('/about') }}">About Us</a>
                    @if (Auth::check())
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="carousel carousel-showmanymoveone slide" id="itemslider">
                                <div class="carousel-inner">
                          
                                    @foreach($items as $item)
                                        <div class="item">
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                <a href="{{ URL("item") }}/{{ $item->id }}">
                                                    <img src="{{ $item->image }}" class="img-responsive center-block">
                                                </a>
                                                <span class="badge">{{ $item->bids }}</span>
                                                <h4 class="text-center">{{ $item->name }}</h4>
                                                <h5 class="text-center">{{ $item->price }} EGP</h5>
                                                <span class="user" data-toggle="tooltip" data-placement="top" title="{{ $item->user->name }}">
                                                    <img src="{{ $item->user->avatar }}" class="img-responsive" alt="{{ $item->user->name }}">
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="slider-control">
                                <a class="left carousel-control" href="#itemslider" data-slide="prev">
                                    <img src="https://s12.postimg.org/uj3ffq90d/arrow_left.png" alt="Left" class="img-responsive">
                                </a>
                                <a class="right carousel-control" href="#itemslider" data-slide="next">
                                    <img src="https://s12.postimg.org/djuh0gxst/arrow_right.png" alt="Right" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div id="search">
            <button type="button" class="close">×</button>
            <form method="POST">
                {{ csrf_field() }}
                <input type="search" name="search" autocomplete="off" placeholder="type keyword(s) here">
            </form>
            <div class="row">
                <div class="container">
                    <div id="output"></div>
                </div>
            </div>
        </div>

        <script src="{{ asset("js/app.js") }}"></script>
        <script>
            $(function () {
                $('a[href="#search"]').on('click', function(event) {
                    event.preventDefault();
                    $('#search').addClass('open');
                    $('#search > form > input[type="search"]').focus();
                });
                
                $('#search, #search button.close').on('click keyup', function(event) {
                    if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                        $(this).removeClass('open');
                    }
                });
                
                
                $('#search form').on('keyup',function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: 'search',
                        data: $(this).serialize(),
                        type: "POST",
                        success: function(response) {
                            $("#output").html(response);
                        }
                    });
                });
            });

            (function(){
                $(".item:first").addClass("active");
                $('#itemslider').carousel({ interval: 1500 });
            }());

            (function(){
                $('.carousel-showmanymoveone .item').each(function(){
                    var itemToClone = $(this);
                    for (var i=1; i<6; i++) {
                        itemToClone = itemToClone.next();
                        if (!itemToClone.length) {
                            itemToClone = $(this).siblings(':first');
                        }

                    itemToClone.children(':first-child').clone()
                        .addClass("cloneditem-"+(i))
                        .appendTo($(this));
                    }
                });
                $('[data-toggle="tooltip"]').tooltip();
            }());

        </script>
    </body>
</html>
