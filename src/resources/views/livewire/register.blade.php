<div>
    {{-- <x-validation-errors class="mb-4 text-red-500" /> --}}
    <form wire:submit.prevent="register">
        <label for="name">名前</label>
        <input type="text" id="name" wire:model.lazy="name" ><br>
        @error('name')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        
        <label for="email">メールアドレス</label>
        <input type="email" id="email" wire:model.lazy="email" ><br>
        @error('email')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        
        <label for="password">パスワード</label>
        <input type="password" id="password" wire:model.lazy="password" ><br>
        @error('password')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <button>登録する</button>
    </form>
</div>
