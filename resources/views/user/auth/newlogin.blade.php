@extends('user/layout/app')
@section('content')
<style>
.flex {
    display: flex;
    align-items: center;
}

.login-container {
    padding: 0 15px;
    justify-content: center;
}

.facebook-page {
    justify-content: space-between;
    max-width: 1000px;
    width: 100%;
}

.facebook-page .text {
    margin-bottom: 90px;
}

.facebook-page h1 {
    color: #1877f2;
    font-size: 4rem;
    margin-bottom: 10px;
}

.facebook-page p {
    font-size: 1rem;
    white-space: nowrap;
    margin-top: 10px;
}

.login-form {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1),
        0 8px 16px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

.login-form input {
    height: 55px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 1rem;
    padding: 0 14px;
}

.login-form input:focus {
    outline: none;
    border-color: #1877f2;
}

::placeholder {
    color: #777;
    font-size: 1.063rem;
}

.link {
    display: flex;
    flex-direction: column;
    text-align: center;
    gap: 15px;
}

.link .login {
    border: none;
    outline: none;
    cursor: pointer;
    /* background: #1877f2; */
    background: #42b72a;
    padding: 15px 0;
    border-radius: 6px;
    color: #fff;
    font-size: 1.25rem;
    font-weight: 600;
    transition: 0.2s ease;
}

.link .login:hover {
    /* background: #0d65d9; */
    background:#020304;
}

.login-form a {
    text-decoration: none;
}

.link .forgot {
    color: #1877f2;
    font-size: 0.875rem;
}

.link .forgot:hover {
    text-decoration: underline;
}

hr {
    border: none;
    height: 1px;
    background-color: #ccc;
    margin-bottom: 20px;
    margin-top: 20px;
}

.button {
    margin-top: 25px;
    text-align: center;
    margin-bottom: 20px;
}

.button a {
    padding: 15px 20px;
    background: #42b72a;
    border-radius: 6px;
    color: #fff;
    font-size: 1.063rem;
    font-weight: 600;
    transition: 0.2s ease;
}

.button a:hover {
    background: #3ba626;
}

@media (max-width: 900px) {
    .facebook-page {
        flex-direction: column;
        text-align: center;
    }

    .facebook-page .text {
        margin-bottom: 30px;
    }
}

@media (max-width: 460px) {
    .facebook-page h1 {
        font-size: 3.5rem;
    }

    .facebook-page p {
        font-size: 1.3rem;
    }

    .login-form {
        padding: 15px;
    }
}
</style>
<div class="section-services section-t8">
    <div class="container">
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    </div>
    <div class="login-container flex">
   
        <div class="facebook-page flex">
            <div class="text">
                <img src="{{asset('img/logovitalg.png')}}" alt="" srcset="" style="width:300px;height:150px;">
                <p> If you already have a renter profile, please log in now to review rentals <br> we have matched to
                    you. </p>
                <p> If not, please fill out the New Member Registration here <a href="">Register Here </a>. </p>
            </div>
            <form action="{{route('login')}}" class="login-form" method="POST">
                @csrf
                <input type="text" placeholder="Username" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <div class="link">
                    <button type="submit" class="login">Login</button>
                    <a href="#" class="forgot">Forgot password?</a>
                </div>
                <hr>
                <div class="button">
                    <a href="#">Create new account</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection