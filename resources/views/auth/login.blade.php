<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
         <div class="mb-3">
                  <label for="email" :value="__('Email')"  class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username":value="old('email')" required autofocus autocomplete="username"  />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

        

        <!-- Password -->
        <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                     @if (Route::has('password.request'))
                         <a href="{{ route('password.request') }}">
                            <small>{{ __('Forgot your password?') }}</small>
                        </a>
                    @endif
                    
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" required autocomplete="current-password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
                </div>

        

        <!-- Remember Me -->
         <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> {{ __('Remember me') }} </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit"> {{ __('Log in') }}</button>
                </div>

       

        
    </form>
</x-guest-layout>
