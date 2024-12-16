
<h1>Chirps dengan #{{ $hashtag->name }}</h1>

@foreach($chirps as $chirp)
    <div>{{ $chirp->message }}</div>
@endforeach
/>
