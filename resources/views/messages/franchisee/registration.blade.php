<div class="card">
    <div class="card-body">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Registration Successful!</h4>
            <p>Thank you for registering with us, now you can start ordering from us in your login portal .</p>
            <p>Here is the credential for your login :- <br/>
                <strong>Username</strong> : <strong>{{$email}}</strong>
                <strong>Password</strong> : <strong>{{$password}}</strong>
            .</p>
            <hr>
            <a href="{{route('franchisee.login',['email'=>$email])}}" class="btn btn-primary">Login Here</a>
        </div>
    </div>
</div>
