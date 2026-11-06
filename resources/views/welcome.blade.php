<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Découvrez la sélection de cadeaux et d’accessoires Zahira Nour." />
  <link rel="shortcut icon" href="{{ asset('front-end/images/favicon.png') }}" type="image/x-icon">

  <title>Zahira Nour | Boutique</title>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/bootstrap.css') }}" />
  <link href="{{ asset('front-end/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('front-end/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
  <div class="hero_area" id="accueil">
    <!-- header section strats -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container" aria-label="Navigation principale">
        <a class="navbar-brand" href="{{ url('/') }}#accueil">
          <span>
            Zahira Nour
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Ouvrir ou fermer le menu">
          <span class=""></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#accueil" aria-current="page">Accueil <span class="sr-only">(page actuelle)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#boutique">
                Boutique
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ asset('front-end/why.html') }}">
                Pourquoi nous
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ asset('front-end/testimonial.html') }}">
                Témoignages
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contactez-nous</a>
            </li>
          </ul>
          <div class="user_option">
            @if (Auth::check())
              @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span>Tableau de bord</span>
                </a>
              @else
                <a href="{{ route('client.dashboard') }}">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <span>Mon espace</span>
                </a>
              @endif
            @else
              <a href="{{ route('login') }}">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Se connecter</span>
              </a>
              <a href="{{ route('register') }}">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>S’inscrire</span>
              </a>
            @endif
          </div>
        </div>
      </nav>
    </header>

    <!-- end header section -->
    <!-- slider section -->

    <section class="slider_section">
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7">
                    <div class="detail-box">
                      <h1>
                        Bienvenue chez <br>
                        Zahira Nour
                      </h1>
                      <p>
                        Trouvez une attention délicate pour faire plaisir à ceux qui comptent.
                      </p>
                      <a href="#boutique">
                        Découvrir la boutique
                      </a>
                    </div>
                  </div>
                  <div class="col-md-5 ">
                    <div class="img-box">
                      <img src="{{ asset('front-end/images/image3.jpeg') }}" alt="Sélection de produits de la boutique Zahira Nour" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </section>

    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- boutique section -->

  <section class="shop_section layout_padding" id="boutique">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nos produits
        </h2>
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p1.png') }}" alt="Bague" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Bague
                </h6>
                <h6>
                  Prix
                  <span>
                    $200
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p2.png') }}" alt="Montre" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Montre
                </h6>
                <h6>
                  Prix
                  <span>
                    $300
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p3.png') }}" alt="Peluche" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Peluche
                </h6>
                <h6>
                  Prix
                  <span>
                    $110
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p4.png') }}" alt="Bouquet de fleurs" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Bouquet de fleurs
                </h6>
                <h6>
                  Prix
                  <span>
                    $45
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p5.png') }}" alt="Peluche" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Peluche
                </h6>
                <h6>
                  Prix
                  <span>
                    $95
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p6.png') }}" alt="Bouquet de fleurs" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Bouquet de fleurs
                </h6>
                <h6>
                  Prix
                  <span>
                    $70
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p7.png') }}" alt="Montre" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Montre
                </h6>
                <h6>
                  Prix
                  <span>
                    $400
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            <a href="{{ route('client.boutique.index') }}">
              <div class="img-box">
                <img src="{{ asset('front-end/images/p8.png') }}" alt="Bague" loading="lazy">
              </div>
              <div class="detail-box">
                <h6>
                  Bague
                </h6>
                <h6>
                  Prix
                  <span>
                    $450
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  Nouveau
                </span>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href="{{ route('client.boutique.index') }}">
          Voir tous les produits
        </a>
      </div>
    </div>
  </section>

  <!-- Boutique section -->







  <!-- contact section -->

  <section class="contact_section" id="contact">
    <div class="container px-0">
      <div class="heading_container ">
        <h2>Contactez-nous</h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe
                src="https://maps.google.com/maps?q=Zahira%20Nour&t=&z=13&ie=UTF8&iwloc=&output=embed"
                title="Rechercher Zahira Nour sur Google Maps"
                width="600"
                height="300"
                style="border: 0; width: 100%; height: 100%"
                loading="lazy"
                allowfullscreen>
              </iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <form action="#">
            <div>
              <input type="text" placeholder="Prénom" aria-label="Prénom" />
            </div>
            <div>
              <input type="text" placeholder="Nom" aria-label="Nom" />
            </div>
            <div>
              <input type="email" placeholder="Adresse e-mail" aria-label="Adresse e-mail" />
            </div>
            <div>
              <input type="text" placeholder="Sujet" aria-label="Sujet" />
            </div>
            <div>
              <textarea class="message-box" placeholder="Votre message" aria-label="Votre message" rows="4"></textarea>
            </div>
            <div class="d-flex ">
              <button type="submit">
                Envoyer
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- info section -->

  <section class="info_section  layout_padding2-top">
    <div class="info_container ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <h6>
              À PROPOS
            </h6>
            <p>
              Zahira Nour vous accompagne dans le choix d’attentions délicates pour les petits et grands moments.
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="info_form ">
              <h5>
                Nos nouveautés
              </h5>
              <form action="#">
                <input type="email" placeholder="Votre adresse e-mail" aria-label="Votre adresse e-mail">
                <button>
                  S’inscrire
                </button>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              BESOIN D'AIDE
            </h6>
            <p>
              Une question ? Retrouvez le formulaire de contact pour nous laisser un message.
            </p>
          </div>
          <div class="col-md-6 col-lg-3">
            <h6>
              CONTACTEZ-NOUS
            </h6>
            <div class="info_link-box">
              <a href="#contact">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>Accéder au formulaire de contact</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- pied de page -->
    <footer class=" footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> Tous droits réservés par
          <a href="https://html.design/">Web Tech Knowledge</a>
        </p>
      </div>
    </footer>
    <!-- pied de page -->

  </section>

  <!-- end info section -->


  <script src="{{ asset('front-end/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('front-end/js/bootstrap.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="{{ asset('front-end/js/custom.js') }}"></script>

</body>

</html>