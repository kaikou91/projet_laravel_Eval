<x-layout>
  <x-slot name="title">   
    {{ $anime->title }}
  </x-slot>

  <article class="anime">
    <header class="anime--header">
      <div>
        <img alt="" src="/covers/{{ $anime->cover }}" />
      </div>
      <h1>{{ $anime->title }}</h1>
    </header>
    <p>{{ $anime->description }}</p>
    <div>
      <div class="actions">
        <div>
          <a class="cta" href="/anime/{{ $anime->id }}/new_review">Écrire une critique</a>
        </div>
        <form action="/anime/{{ $anime->id }}/add_to_watch_list" method="POST">
          <button class="cta">Ajouter à ma watchlist</button>
        </form>
      </div>

      <!-- afficher les critiques  -->  
      <div class="">
      <ul class="cta">
            <h2>Avis donner :</h2>
            @foreach ($critiques as $critique)
                <li class="list">
                {{ $critique->username }} : {{ $critique->comment }} </br>
                Note : {{ $critique->rating }} 
                </li>
            @endforeach                                        
        </ul>
      </div>     
       
               
    </div>
  </article>
</x-layout>
