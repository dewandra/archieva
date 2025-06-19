<div class="card login-card">
    <div class="card-body text-center">
        
        <img src="{{ asset('img/archievault.png') }}" alt="Archievault Logo" class="login-logo-img mb-4">
        
        <form wire:submit="login">
            <div class="mb-3">
                <input wire:model="email" type="email" class="form-control custom-input" id="emailInput" placeholder="Email address" required>
                @error('email') <span class="text-danger small d-block text-start">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <input wire:model="password" type="password" class="form-control custom-input" id="passwordInput" placeholder="Password" required>
                @error('password') <span class="text-danger small d-block text-start">{{ $message }}</span> @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-custom-login">SIGN IN</button>
            </div>
        </form>
        
    </div>
</div>