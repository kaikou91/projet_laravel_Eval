
<x-layout>
  <ul role="list" class="anime-list">
  @foreach($addToWatchLists as $addToWatchList)
      <li class="flow">
        <div class="flow">
          <div>
            <img alt="" src="/covers/{{  $addToWatchList->cover }}" />
          </div>
          <h2>
            {{  $addToWatchList->title }}
          </h2>
        </div>
        <a class="cta" href="/anime/{{  $addToWatchList->id }}">Voir</a>
      </li>
    @endforeach
  </ul>
</x-layout>

