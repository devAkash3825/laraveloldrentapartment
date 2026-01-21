@extends('user.layout.app')
@section('content')
@section('title', 'RentApartement | Contact-Us')

<style>
  section#contact-form {
    padding: 100px 0;
    position: relative;
  }

  #contact-form .form {
    width: 100%;
    /* max-width: 820px; */
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    overflow: hidden;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    z-index: 999999;
    position: relative;
  }

  #contact-form .contact-form {
    background-color: var(--colorPrimary);
    position: relative;
  }

  #contact-form .circle {
    border-radius: 50%;
    background: linear-gradient(135deg, transparent 20%, var(--colorPrimary));
    position: absolute;
  }

  #contact-form .circle.one {
    width: 130px;
    height: 130px;
    top: 130px;
    right: -40px;
  }

  #contact-form .circle.two {
    width: 80px;
    height: 80px;
    top: 10px;
    right: 30px;
  }

  #contact-form .contact-form:before {
    content: "";
    position: absolute;
    width: 26px;
    height: 26px;
    background-color: var(--colorPrimary);
    transform: rotate(45deg);
    top: 50px;
    left: -13px;
  }

  #contact-form form {
    padding: 3.8rem 2.2rem;
    z-index: 10;
    overflow: hidden;
    position: relative;
  }

  #contact-form .title {
    color: #fff;
    font-weight: 500;
    font-size: 2rem;
    line-height: 1;
    margin-bottom: 0.7rem;
  }

  #contact-form .input-container {
    position: relative;
    margin: 1rem 0;
  }

  #contact-form .input {
    width: 100%;
    outline: none;
    border: 2px solid #fafafa;
    background: none;
    padding: 0.6rem 1.2rem;
    color: #fff;
    font-weight: 500;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
    border-radius: 5px;
    transition: 0.3s;
  }

  #contact-form textarea.input {
    padding: 0.8rem 1.2rem;
    min-height: 150px;
    border-radius: 5px;
    resize: none;
    overflow-y: auto;
  }

  #contact-form .input-container label {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    padding: 0 0.4rem;
    color: #fafafa;
    font-size: 0.9rem;
    font-weight: 400;
    pointer-events: none;
    z-index: 1000;
    transition: 0.5s;
  }

  #contact-form .input-container.textarea label {
    top: 1rem;
    transform: translateY(0);
  }

  #contact-form .btn {
    padding: 0.6rem 1.3rem;
    background-color: #fff;
    border: 2px solid #fafafa;
    font-size: 0.95rem;
    color: #1abc9c;
    line-height: 1;
    border-radius: 5px;
    outline: none;
    cursor: pointer;
    transition: 0.3s;
    margin: 0;
    width: 100%;
  }

  #contact-form .btn:hover {
    background-color: transparent;
    color: #fff;
  }

  #contact-form .input-container span {
    position: absolute;
    top: 0;
    left: 25px;
    transform: translateY(-50%);
    font-size: 0.8rem;
    padding: 0 0.4rem;
    color: transparent;
    pointer-events: none;
    z-index: 500;
  }

  #contact-form .input-container span:before,
  #contact-form .input-container span:after {
    content: "";
    position: absolute;
    width: 10%;
    opacity: 0;
    transition: 0.3s;
    height: 5px;
    background-color: var(--colorPrimary);
    top: 50%;
    transform: translateY(-50%);
  }

  #contact-form .input-container span:before {
    left: 50%;
  }

  #contact-form .input-container span:after {
    right: 50%;
  }

  #contact-form .input-container.focus label {
    top: 0;
    transform: translateY(-50%);
    left: 25px;
    font-size: 0.8rem;
  }

  #contact-form .input-container.focus span:before,
  #contact-form .input-container.focus span:after {
    width: 50%;
    opacity: 1;
  }

  #contact-form .contact-info {
    padding: 3.8rem 2.2rem;
    position: relative;
  }

  #contact-form .contact-info .title {
    color: var(--colorPrimary);
  }

  #contact-form .text {
    color: #333;
    margin: 1.5rem 0 2rem 0;
    font-size: 18px;
  }

  #contact-form .information {
    display: flex;
    color: #555;
    margin: 0.7rem 0;
    align-items: center;
    font-size: 0.95rem;
  }

  #contact-form .info a {
    color: var(--colorPrimary);
    font-size: 18px;
  }

  #contact-form .information i {
    color: var(--colorPrimary);
    font-size: 18px;
  }

  #contact-form .icon {
    width: 28px;
    margin-right: 0.7rem;
  }

  #contact-form .social-media {
    padding: 2rem 0 0 0;
  }

  #contact-form .social-media p {
    color: #333;
    font-size: 18px;
    padding-bottom: 10px;
  }

  #contact-form .social-icons {
    display: flex;
    margin-top: 0.5rem;
  }

  #contact-form .social-icons a {
    width: 35px;
    height: 35px;
    border-radius: 5px;
    background: linear-gradient(45deg, var(--colorSecondary), var(--colorPrimary));
    color: #fff;
    text-align: center;
    line-height: 35px;
    margin-right: 0.5rem;
    transition: 0.3s;
  }

  #contact-form .social-icons a:hover {
    transform: scale(1.05);
  }

  #contact-form .contact-info:before {
    content: "";
    position: absolute;
    width: 110px;
    height: 100px;
    border: 22px solid var(--colorPrimary);
    border-radius: 50%;
    bottom: -77px;
    right: 50px;
    opacity: 0.3;
  }

  #contact-form .big-circle {
    position: absolute;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: linear-gradient(to bottom,var(--colorPrimary), var(--colorPrimary));
    bottom: 50%;
    right: 58%;
    transform: translate(-40%, 38%);
  }

  #contact-form .big-circle:after {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    background-color: #fafafa;
    border-radius: 50%;
    top: calc(50% - 180px);
    left: calc(50% - 180px);
  }

  #contact-form .square {
    position: absolute;
    height: 400px;
    top: 50%;
    left: 50%;
    transform: translate(181%, 11%);
    opacity: 0.2;
  }

  @media (max-width: 850px) {
    #contact-form .form {
      grid-template-columns: 1fr;
    }

    #contact-form .contact-info:before {
      bottom: initial;
      top: -75px;
      right: 65px;
      transform: scale(0.95);
    }

    #contact-form .contact-form:before {
      top: -13px;
      left: initial;
      right: 70px;
    }

    #contact-form .square {
      transform: translate(140%, 43%);
      height: 350px;
    }

    #contact-form .big-circle {
      bottom: 75%;
      transform: scale(0.9) translate(-40%, 30%);
      right: 50%;
    }

    #contact-form .text {
      margin: 1rem 0 1.5rem 0;
    }

    #contact-form .social-media {
      padding: 1.5rem 0 0 0;
    }
  }

  @media (max-width: 480px) {
    #contact-form .container {
      padding: 1.5rem;
    }

    #contact-form .contact-info:before {
      display: none;
    }

    #contact-form .square,
    #contact-form .big-circle {
      display: none;
    }

    #contact-form form,
    #contact-form .contact-info {
      padding: 1.7rem 1.6rem;
    }

    #contact-form .text,
    #contact-form .information,
    #contact-form .social-media p {
      font-size: 0.8rem;
    }

    #contact-form .title {
      font-size: 1.15rem;
    }

    #contact-form .social-icons a {
      width: 30px;
      height: 30px;
      line-height: 30px;
    }

    #contact-form .icon {
      width: 23px;
    }

    #contact-form .input {
      padding: 0.45rem 1.2rem;
    }

    #contact-form .btn {
      padding: 0.45rem 1.2rem;
    }
  }
</style>
<!-- Premium Header -->
<div class="header-premium-gradient py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white fw-bold display-5 mb-2">Contact Us</h1>
                <p class="text-white opacity-75 lead mb-0">We'd love to hear from you!</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none small">Home</a></li>
                        <li class="breadcrumb-item active text-white fw-bold small" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- <section id="get_in_touch">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="contact_box">
                    <div class="contact_box_icon">
                        <i class="fal fa-phone-square-alt"></i>
                    </div>
                    <div class="contact_box_text">
                        <a href="callto: {{ $contact?->phone }}">{{ $contact?->phone }}</a>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact_box">
                    <div class="contact_box_icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact_box_text">
                        <a href="mailto: {{ $contact?->email }}">{{ $contact?->email }}</a>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact_box">
                    <div class="contact_box_icon">
                        <i class="fal fa-map-marker-alt"></i>
                    </div>
                    <div class="contact_box_text">
                        <a href="">{{ $contact?->address }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>message here</h2>
                <form action="" method="POST" id="submitcontactus">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="contact_input">
                                <input type="text" placeholder="Name" name="name">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact_input">
                                <input type="email" placeholder="Email" name="email">
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="contact_input">
                                <input type="text" placeholder="Subject" name="subject">
                            </div>
                        </div>
                        <div class="col-xl-12 mb-5">
                            <div class="contact_input">
                                <textarea cols="3" rows="5" placeholder="Message" name="message"></textarea>
                                <button class="read_btn" type="submit">send message</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-12">
                <div class="contact_map">
                    {!! $contact?->map_link !!}
                </div>
            </div>
        </div> --}}
    </div>
</section> -->


<section id="contact-form">
  <div class="container">
    <span class="big-circle"></span>
    <div class="form">
      <div class="contact-info">
        <h3 class="title">Let's get in touch</h3>
        <p class="text">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe
          dolorum adipisci recusandae praesentium dicta!
        </p>

        <div class="info">
          <div class="information">
            <i class="fas fa-map-marker-alt"></i> &nbsp &nbsp

            <p> <a href="">{{ $contact?->address }}</a></p>
          </div>
          <div class="information">
            <i class="fas fa-envelope"></i> &nbsp &nbsp
            <p> <a href="mailto: {{ $contact?->email }}">{{ $contact?->email }}</a></p>
          </div>
          <div class="information">
            <i class="fas fa-phone"></i>&nbsp&nbsp
            <p> <a href="callto: {{ $contact?->phone }}">{{ $contact?->phone }}</a></p>
          </div>
        </div>

        <div class="social-media">
          <p>Connect with us :</p>
          <div class="social-icons">
            <a href="#">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="contact-form">
        <span class="circle one"></span>
        <span class="circle two"></span>

        <form action="" method="POST" id="submitcontactus">
          @csrf
          <div class="row">
            <div class="col-xl-6">
              <div class="contact_input">
                <input type="text" placeholder="Name" name="name">
              </div>
            </div>
            <div class="col-xl-6">
              <div class="contact_input">
                <input type="email" placeholder="Email" name="email">
              </div>
            </div>

            <div class="col-xl-12">
              <div class="contact_input">
                <input type="text" placeholder="Subject" name="subject">
              </div>
            </div>
            <div class="col-xl-12 mb-5">
              <div class="contact_input">
                <textarea cols="3" rows="5" placeholder="Message" name="message"></textarea>
                <button class="read_btn" type="submit">send message</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
  $("#submitcontactus").submit(function(e) {
    e.preventDefault();
    var url = "{{ route('submit-contact-us') }}";
    var formData = $(this).serialize();
    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function() {
        $('.read_btn').html(
          `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...`
        )
        $('.read_btn').prop('disabled', true);
      },
      success: function(response) {
        if (response.message) {
          toastr.success(response.message);
          $("#submitcontactus")[0].reset();
          $('.read_btn').html(`Submit`)
          $('.read_btn').prop('disabled', false);
        }
      },
      error: function(xhr) {
        toastr.error("An error occurred. Please try again.");
        $('.read_btn').html(
          `Submit`
        )
        $('.read_btn').prop('disabled', false);
      },
    });

    $(this).addClass('was-validated');
  });
</script>
@endpush