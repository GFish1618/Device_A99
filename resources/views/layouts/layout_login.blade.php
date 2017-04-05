<?php use App\Repositories\FileRepository; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'A99') }}</title>

    <!-- Styles -->
    <link href="{{url('/css/app.css')}}" rel="stylesheet">
    <link href="{{url('/css/profile_card.css')}}" rel="stylesheet">
    <link href="{{url('/css/breadcrumbs.css')}}" rel="stylesheet">


    <link rel="shortcut icon" href="{{url('/logo899.ico')}}" type="image/x-icon"/> 
    <link rel="icon" href="{{url('/logo899.ico')}}" type="image/x-icon"/>



    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body style="background-color: #e9ebee; margin:0; padding:0; height:100%; width:100%; ">
<div class="container-fluid" style="padding-left:0 !important;padding-right:0 !important;height:100%;
  width:100%;
  overflow:hidden;" >
    <div class="row">
        <div class="col-md-8" style="padding-left:0 !important;padding-right:0 !important" >
            <div id="gallery" class="cf">
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/James-D-e1465181631894.jpg">
                    <div class="gallery-caption">
                    <h2>James</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Owtee-Bingayan-e1465184558469.jpg">
                    <div class="gallery-caption">
                    <h2>Owtee</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Jacq-5-e1465180682601.jpg">
                    <div class="gallery-caption">
                    <h2>Jacq</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Eve-Sastre-e1465181559510.jpg">
                    <div class="gallery-caption">
                    <h2>Eve</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Mar-Pena-e1465181653748.jpg">
                    <div class="gallery-caption">
                    <h2>Mar</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/06/luigi-amante.jpg">
                    <div class="gallery-caption">
                    <h2>Luigi</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/06/Jon-Krabbe.jpg">
                    <div class="gallery-caption">
                    <h2>Jon</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Tiger-e1465181603248.jpg">
                    <div class="gallery-caption">
                    <h2>Tiger</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Nina-1-e1465181479574.jpg">
                    <div class="gallery-caption">
                    <h2>Nina</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/James-Songalia-e1465181192711.jpg">
                    <div class="gallery-caption">
                    <h2>James</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Isabelle-Final-1-e1465181532177.jpg">
                    <div class="gallery-caption">
                    <h2>Isabelle</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Catherine-Maquiran-e1465181580926.jpg">
                    <div class="gallery-caption">
                    <h2>Catherine</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2017/03/Ayrah-1.jpg">
                    <div class="gallery-caption">
                    <h2>Ayrah</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2017/03/Rose-1.jpg">
                    <div class="gallery-caption">
                    <h2>Rose</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/11/Klinton-Ballecer.jpeg">
                    <div class="gallery-caption">
                    <h2>Klinton</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Mary-Ann-e1465180714641.jpg">
                    <div class="gallery-caption">
                    <h2>Mary Ann</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/Susette-Ignacio-e1465181431156.jpg">
                    <div class="gallery-caption">
                    <h2>Susette</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/karl-esculano-e1465184748820.jpg">
                    <div class="gallery-caption">
                    <h2>Karl</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/John-Marco-Alcaria-e1465181232536.jpg">
                    <div class="gallery-caption">
                    <h2>Marco</h2>
                    </div>
                </a>
                <a href="#" class="gallery-slide">
                    <img src="https://www.august99.com/wp-content/uploads/2016/05/IMG_6966-e1465181322539.jpg">
                    <div class="gallery-caption">
                    <h2>Blaissie</h2>
                    </div>
                </a>
                
                </div>
        </div>
        <div class="col-md-4" style="padding-left:0 !important;padding-right:0 !important" >
            <div class="row" style="text-align:center; margin-top:25%;">

            <img src="/logo899.ico" alt="Smiley face"  width="200">
            <h1>August99</h1>
            </div>
            <div class="row">
            <div class="col-md-12" style="text-align:center">
            @yield('content')
            </div>
            </div>

        </div>
    </div>
</div>
<style>
.cf:before,
.cf:after {
  content: " ";
  display: table;
}

.cf:after {
  clear: both;
}

*,
*:after,
*:before {
  transition: all 0.5s ease;
}

img {
  max-width: 100%;
  height: auto;
}

body {
  background: black;
}

#gallery {
  width: 100%;
  max-width: 100%;
  height:100%;
  max-height:100%;
  margin: 0 auto;
  position: relative;
  font-family: Verdana;
}

#gallery .gallery-caption {
  color: white;
  background-color: rgba(255, 255, 255, 0);
  border-radius: 50%;
  text-align: center;
  position: absolute;
  top: 100%;
  left: 5%;
  width: 90%;
  height: 90%;
  margin: 0 auto;
  text-shadow: -1px 1px 0 black, -2px 2px 0 black;
  text-transform: uppercase;
}

#gallery .gallery-slide:hover .gallery-caption {
  top: 5%;
}

#gallery .gallery-slide {
  margin: 0;
  padding: 0;
  float: left;
  width: auto;
  max-width: 300px;
  height:180px;
  position: relative;
  overflow: hidden;
}

#gallery .gallery-slide:after {
  position: absolute;
  content: "";
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

#gallery:hover .gallery-slide:after {
  background: rgba(0, 0, 0, 0.5);
}

#gallery .gallery-slide:hover:after {
  background: transparent;
}

#gallery .gallery-slide:hover img {
  transform: scale(1.3) rotate(-10deg);
}

@media only screen and (min-width:480px) {
  #gallery .gallery-slide {
    width: 50%;
  }
}

@media only screen and (min-width:640px) {
  #gallery .gallery-slide {
    width: 25%;
  }
}

@media only screen and (min-width:767px) {
  #gallery {}
}

</style>

<!-- Scripts -->
    <script src="{{ url('/js/app.js') }}"></script>
</body>
</html>