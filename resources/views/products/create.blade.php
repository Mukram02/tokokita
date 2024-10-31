<x-app-layout>
  <div class="py-12">
        
        <div class=" flex mt-6  "> 
          <h2 class="font-semibold text-xl">Add Product</h2> 
        </div>

        <div class="mt-4"  x-data="{ imageUrl: '/storage/noimage.png' }">
          <form enctype="multipart/form-data"  method="POST" action="{{ route('products.store') }}" class="flex gap-8 ">
              @csrf <!-- CSRF token untuk keamanan form -->

              <div class="w-1/2">
                <img :src="imageUrl" class="rounded-md" />
              </div>
              <div class="w-1/2" >
                  <!-- Foto -->
                  <div class="mt-4">
                      <x-input-label for="foto" :value="__('foto')" />
                      <x-text-input 
                      accept="image/*" 
                      id="foto" 
                      class="block mt-1 w-full border p-2" 
                      type="file" 
                      name="foto"
                      required 
                      @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                      <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                  </div>
                  <!-- Nama Produk -->
                  <div class="mt-4">
                      <x-input-label for="nama" :value="__('Nama Produk')" />
                      <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required />
                      <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                  </div>
            
                  <!-- Harga Produk -->
                  <div class="mt-4">
                      <x-input-label for="harga" :value="__('Harga Produk')" />
                      <x-text-input id="harga" class="block mt-1 w-full" type="text" name="harga" :value="old('harga')" required />
                      <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                  </div>
            
                  <!-- Deskripsi Produk -->
                  <div class="mt-4">
                      <x-input-label for="deskripsi" :value="__('Deskripsi Produk')" />
                      <textarea id="deskripsi" class="block mt-1 w-full rounded-md" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                      <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                  </div>
            
                  <!-- Submit Button -->
                  <div class=" flex items-center justify-center mt-4">
                      <x-primary-button>
                          {{ __('Submit') }}
                      </x-primary-button>
                  </div>
              </div>
          </form>
        </div>
        
      
  </div>
</x-app-layout>
