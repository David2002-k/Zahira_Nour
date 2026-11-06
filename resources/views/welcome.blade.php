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
      <nav class="navbar navbar-expand-lg custom_nav-container home-nav" aria-label="Navigation principale">
        <a class="navbar-brand home-brand" href="{{ url('/') }}#accueil">
          <span class="brand-name">
            <span class="brand-name-red">Zahira</span>
            <span class="brand-name-black">Nour</span>
          </span>
        </a>
        <button class="navbar-toggler home-nav-toggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Ouvrir ou fermer le menu">
          <span></span>
        </button>

        <div class="collapse navbar-collapse home-nav-menu" id="navbarSupportedContent">
          <ul class="navbar-nav home-nav-links">
            <li class="nav-item">
              <a class="nav-link" href="#accueil" aria-current="page">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#boutique">Boutique</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ asset('front-end/why.html') }}">Pourquoi nous</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ asset('front-end/testimonial.html') }}">Témoignages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contactez-nous</a>
            </li>
          </ul>
          <div class="user_option home-user-options">
            @if (Auth::check())
              @if (Auth::user()->role === 'admin')
                <a class="home-account-link" href="{{ route('admin.dashboard') }}">Mon tableau de bord</a>
              @else
                <a class="home-account-link" href="{{ route('client.dashboard') }}">Mon espace</a>
              @endif
            @else
              <a class="home-login-link" href="{{ route('login') }}">Se connecter</a>
              <a class="home-register-link" href="{{ route('register') }}">Créer un compte</a>
            @endif
          </div>
        </div>
      </nav>
    </header>

    <section class="home-hero" aria-labelledby="home-hero-title">
      <div class="home-hero-copy">
        <p class="home-eyebrow"><span aria-hidden="true">✦</span> Le plaisir d’offrir</p>
        <h1 id="home-hero-title">
          Les petites attentions<br>
          <span>font les grands bonheurs.</span>
        </h1>
        <p class="home-hero-description">
          Des cadeaux choisis avec soin pour célébrer les personnes qui comptent, dans chaque moment de la vie.
        </p>
        <div class="home-hero-actions">
          <a class="home-button home-button-primary" href="#boutique">Découvrir la boutique <span aria-hidden="true">→</span></a>
          <a class="home-button home-button-secondary" href="#contact">Nous contacter</a>
        </div>
        <div class="home-hero-note">
          <span class="home-note-icon" aria-hidden="true">♡</span>
          <span>Une sélection pensée pour faire plaisir</span>
        </div>
      </div>
      <div class="home-hero-visual">
        <div class="home-hero-image-wrap">
          <img src="{{ asset('front-end/images/image3.jpeg') }}" alt="Une sélection de cadeaux et d’accessoires Zahira Nour">
        </div>
        <div class="home-visual-stamp" aria-hidden="true">
          <span>Choisi</span>
          <span>avec amour</span>
          <span class="home-stamp-heart">♡</span>
        </div>
      </div>
    </section>
  </div>

  <section class="shop_section layout_padding home-products" id="boutique">
    <div class="container">
      <div class="heading_container heading_center">
        <p class="home-section-eyebrow">Une attention pour chaque occasion</p>
        <h2>Nos coups de cœur</h2>
        <p class="home-section-description">Découvrez des idées cadeaux qui feront sourire ceux que vous aimez.</p>
      </div>
      <div class="row home-products-grid">
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

  <section class="contact_section home-contact" id="contact">
    <div class="container">
      <div class="heading_container">
        <p class="home-section-eyebrow">Nous sommes à votre écoute</p>
        <h2>Parlons de votre prochaine attention</h2>
        <p class="home-section-description">Une question ou besoin d’un conseil ? Écrivez-nous, nous serons ravis de vous aider.</p>
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
    <footer class="footer_section home-footer">
      <div class="container">
        <a class="home-footer-brand" href="{{ url('/') }}#accueil"><span>Zahira</span> Nour</a>
        <p>&copy; <span id="displayYear">{{ date('Y') }}</span> Zahira Nour. Tous droits réservés.</p>
      </div>
    </footer>

  </section>


  <script src="{{ asset('front-end/js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('front-end/js/bootstrap.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="{{ asset('front-end/js/custom.js') }}"></script>

</body>

</html>