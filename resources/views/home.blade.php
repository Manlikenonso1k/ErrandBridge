@extends('layouts.app')

@section('title', 'ErrandBridge | Home')

@section('content')
<main class="main" id="top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/img/gallery/logo.png') }}" height="45" alt="logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
          <li class="nav-item px-2"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="#start-here">Get Started</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="#services">Our Services</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="#find-us">Find Us</a></li>
        </ul>
        <a class="btn btn-primary order-1 order-lg-0 ms-lg-3" href="{{ url('/sender/login') }}">Login</a>
      </div>
    </div>
  </nav>

  <section class="py-xxl-10 pb-0" id="home">
    <div class="bg-holder bg-size" style="background-image:url({{ asset('assets/img/gallery/hero-header-bg.png') }});background-position:top center;background-size:cover;"></div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5 col-xl-6 col-xxl-7 order-0 order-md-1 text-end">
          <img class="pt-7 pt-md-0 w-100" src="{{ asset('assets/img/illustrations/hero.png') }}" alt="hero-header" />
        </div>
        <div class="col-md-75 col-xl-6 col-xxl-5 text-md-start text-center py-8">
          <h1 class="fw-normal fs-6 fs-xxl-7">Launch your errands with</h1>
          <h1 class="fw-bolder fs-6 fs-xxl-7 mb-2">trusted runners, fast.</h1>
          <p class="fs-1 mb-5">Sign up as a Sender or Runner, then continue in your dashboard for KYC, task tracking, and updates.</p>
          <a class="btn btn-primary me-2" href="{{ url('/sender/register') }}" role="button">Create Sender Account<i class="fas fa-arrow-right ms-2"></i></a>
          <a class="btn btn-outline-primary" href="{{ url('/runner/register') }}" role="button">Create Runner Account</a>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" id="start-here">
    <div class="container">
      <div class="row justify-content-center text-center mb-4">
        <div class="col-lg-8">
          <h5 class="text-danger">START HERE</h5>
          <h2>Choose your account path</h2>
        </div>
      </div>
      <div class="row g-4 justify-content-center">
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4 text-center">
              <h4 class="mb-3">Sender</h4>
              <p class="text-700">Post errands, monitor progress, and manage deliveries.</p>
              <a class="btn btn-primary w-100 mb-2" href="{{ url('/sender/register') }}">Register as Sender</a>
              <a class="btn btn-outline-primary w-100" href="{{ url('/sender/login') }}">Sender Login</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4 text-center">
              <h4 class="mb-3">Runner</h4>
              <p class="text-700">Accept errands, complete jobs, and earn from deliveries.</p>
              <a class="btn btn-danger w-100 mb-2" href="{{ url('/runner/register') }}">Register as Runner</a>
              <a class="btn btn-outline-danger w-100" href="{{ url('/runner/login') }}">Runner Login</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4 text-center">
              <h4 class="mb-3">Admin</h4>
              <p class="text-700">Review KYC, manage settings, and oversee platform activity.</p>
              <a class="btn btn-outline-dark w-100" href="{{ url('/admin/login') }}">Admin Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-7" id="services">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5 text-center mb-3">
          <h5 class="text-danger">SERVICES</h5>
          <h2>Our services for you</h2>
        </div>
      </div>
      <div class="row h-100 justify-content-center">
        <div class="col-md-4 pt-4 px-md-2 px-lg-3">
          <div class="card h-100 px-lg-5 card-span">
            <div class="card-body d-flex flex-column justify-content-around">
              <div class="text-center pt-5"><img class="img-fluid" src="{{ asset('assets/img/icons/services-1.svg') }}" alt="..." />
                <h5 class="my-4">Business Services</h5>
              </div>
              <p>Offering home delivery around the city, where your products will be at your doorstep within 48-72 hours.</p>
              <div class="text-center my-5">
                <div class="d-grid">
                  <button class="btn btn-outline-danger" type="button">Learn more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 pt-4 px-md-2 px-lg-3">
          <div class="card h-100 px-lg-5 card-span">
            <div class="card-body d-flex flex-column justify-content-around">
              <div class="text-center pt-5"><img class="img-fluid" src="{{ asset('assets/img/icons/services-2.svg') }}" alt="..." />
                <h5 class="my-4">Statewide Services</h5>
              </div>
              <p>Offering home delivery around the city, where your products will be at your doorstep within 48-72 hours.</p>
              <div class="text-center my-5">
                <div class="d-grid">
                  <button class="btn btn-danger hover-top btn-glow border-0" type="button">Learn more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 pt-4 px-md-2 px-lg-3">
          <div class="card h-100 px-lg-5 card-span">
            <div class="card-body d-flex flex-column justify-content-around">
              <div class="text-center pt-5"><img class="img-fluid" src="{{ asset('assets/img/icons/services-3.svg') }}" alt="..." />
                <h5 class="my-4">Personal Services</h5>
              </div>
              <p>You can trust us to safely deliver your most sensitive documents to the specific area in a short time.</p>
              <div class="text-center my-5">
                <div class="d-grid">
                  <button class="btn btn-outline-danger" type="button">Learn more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="pt-7 pb-0">
    <div class="container">
      <div class="row">
        <div class="col-6 col-lg mb-5"><div class="text-center"><img src="{{ asset('assets/img/icons/awards.png') }}" alt="..." /><h1 class="text-primary mt-4">26+</h1><h5 class="text-800">Awards won</h5></div></div>
        <div class="col-6 col-lg mb-5"><div class="text-center"><img src="{{ asset('assets/img/icons/states.png') }}" alt="..." /><h1 class="text-primary mt-4">65+</h1><h5 class="text-800">States covered</h5></div></div>
        <div class="col-6 col-lg mb-5"><div class="text-center"><img src="{{ asset('assets/img/icons/clients.png') }}" alt="..." /><h1 class="text-primary mt-4">689K+</h1><h5 class="text-800">Happy clients</h5></div></div>
        <div class="col-6 col-lg mb-5"><div class="text-center"><img src="{{ asset('assets/img/icons/goods.png') }}" alt="..." /><h1 class="text-primary mt-4">130M+</h1><h5 class="text-800">Goods delivered</h5></div></div>
        <div class="col-6 col-lg mb-5"><div class="text-center"><img src="{{ asset('assets/img/icons/business.png') }}" alt="..." /><h1 class="text-primary mt-4">130M+</h1><h5 class="text-800">Business hours</h5></div></div>
      </div>
    </div>
  </section>

  <section class="py-7">
    <div class="container-fluid">
      <div class="row flex-center">
        <div class="bg-holder bg-size" style="background-image:url({{ asset('assets/img/gallery/quote.png') }});background-position:top;background-size:auto;margin-left:-270px;margin-top:-45px;"></div>
        <div class="col-md-8 col-lg-5 text-center">
          <h5 class="text-danger">TESTIMONIAL</h5>
          <h2>Our Awesome Clients</h2>
        </div>
      </div>
      <div class="row pt-6 justify-content-center">
        <div class="col-md-10 col-lg-8 text-center">
          <p class="lead mb-0">This Laravel version keeps the original template content and routing, so the site can run locally with Blade views.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
          <img src="{{ asset('assets/img/illustrations/callback.png') }}" alt="..." />
          <h5 class="text-danger">REQUEST A CALLBACK</h5>
          <h2>We will contact in the shortest time.</h2>
          <p class="text-muted">Monday to Friday, 9am-5pm.</p>
        </div>
        <div class="col-md-6 col-lg-5 col-xl-4">
          <form class="row">
            <div class="mb-3"><input class="form-control form-quriar-control" type="text" placeholder="Name" /></div>
            <div class="mb-3"><input class="form-control form-quriar-control" type="email" placeholder="Email" /></div>
            <div class="mb-5"><textarea class="form-control form-quriar-control border-400" placeholder="Message" style="height: 150px"></textarea></div>
            <div class="d-grid"><button class="btn btn-primary" type="button">Send Message<i class="fas fa-paper-plane ms-2"></i></button></div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section id="find-us" class="py-7">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5 mb-6 text-center">
          <h5 class="text-danger">FIND US</h5>
          <h2>Access us easily</h2>
        </div>
        <div class="col-12">
          <div class="card card-span rounded-2 mb-3">
            <div class="row">
              <div class="col-md-6 col-lg-7 d-flex"><img class="w-100 fit-cover rounded-md-start rounded-top rounded-md-top-0" src="{{ asset('assets/img/gallery/map.svg') }}" alt="map" /></div>
              <div class="col-md-6 col-lg-5 d-flex flex-center">
                <div class="card-body">
                  <h5>Contact with us</h5>
                  <p class="text-700 my-4"><i class="fas fa-map-marker-alt text-warning me-3"></i><span>2277 Lorem Ave, San Diego, CA 22553</span></p>
                  <p><i class="fas fa-phone-alt text-warning me-3"></i><span class="text-700">Monday - Friday: 10 am - 10pm<br /><span class="ps-4">Sunday: 11 am - 9pm</span></span></p>
                  <p><i class="fas fa-envelope text-warning me-3"></i><a class="text-700" href="mailto:info@example.com"> info@example.com</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-900 pb-0 pt-5">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-6 mb-4"><a class="text-decoration-none" href="#top"><img src="{{ asset('assets/img/gallery/footer-logo.png') }}" height="51" alt="" /></a>
          <p class="text-500 my-4">The most trusted Courier<br />company in your area.</p>
        </div>
        <div class="col-12 text-center py-4">
          <p class="fs--1 my-2 fw-bold text-200">All rights Reserved &copy; Courier Template</p>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
