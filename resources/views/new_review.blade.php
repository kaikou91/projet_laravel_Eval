<x-layout>
  <x-slot name="title">
    Nouvelle critique de [nom de l'anime]
  </x-slot>

  <h1>Nouvelle Critique de [{{ $anime->title }}]</h1>

<!-- formulaire de critique -->
  <form action="/anime/{id}" method="POST">
    @csrf 
    <label for="pet-select">Attribuer la note:</label>
  
    <select name="pets" id="pet-select">
        <!-- <option value="">Tapez votre note ici</option> -->
        <option value="1" selected>1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
    </select>
    <div>

        <input type="hidden" id="idAnime" name="idAnime" value="{{ $anime->id }}">
        
        <input type="hidden" id="idUser" name="idUser" value="{{ Auth::user()->id }}">
    </div>
    
    <div>
        <label for="msg">Message :</label>
        <textarea id="msg" name="user_message"></textarea>
    </div>
    <div class="button">
        <button type="submit">Envoyer le message</button>
    </div>
  </form>

</x-layout>
