<div class="dashboard-menu">
      <nav class="navbar navbar-default">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="{{ Active::pattern('traveller/dashboard*') }}"><a href="{{route('frontend.traveller.dashboard')}}">Dashboard <span class="sr-only">(current)</span></a></li>
              <li class="{{ Active::pattern('traveller/profile*') }}"><a href="{{route('frontend.traveller.profile')}}">Profile</a></li>
              <li class="{{ Active::pattern('traveller/account*') }}"><a href="{{route('frontend.traveller.account')}}">Account</a></li>
              <li class="{{ Active::pattern('traveller/history*') }}"><a href="{{route('frontend.traveller.history')}}">Package Purchased History</a></li>
              <li class="{{ Active::pattern('traveller/image*') }}"><a href="{{route('frontend.traveller.image')}}">Passport Image Upload</a></li>
              
            </ul>
            
            
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>