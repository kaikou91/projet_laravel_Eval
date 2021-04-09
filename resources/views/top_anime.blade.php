<x-layout>
    <x-slot name="title">   
    dd{{$topAnimes}}
    </x-slot>
    <h1>Top des animes</h1>
    

    <ul role="list" class="anime-list">
        @foreach($topAnimes as $topAnime)
        <li class="flow">
            <div class="flow">
            <div>
                <img alt="" src="/covers/{{ $topAnime->cover }}" />
            </div>
            <h2>
                {{ $topAnime->title }}
            </h2>
            </div>
            <a class="cta" href="">Note général : </br> {{ $topAnime->moyenne }}</a>
        </li>
        @endforeach
    </ul>


</x-layout>