@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Video Games</h2>

    <!-- Filter by Genre -->
    <label for="genre">Filter by Genre:</label>
    <select id="genre" name="genre" onchange="fetchGames()">
        <option value="">All</option>
    </select>

    <!-- Sorting -->
    <label for="sort">Sort by Release Date:</label>
    <select id="sort" name="sort" onchange="fetchGames()">
        <option value="desc">Newest First</option>
        <option value="asc">Oldest First</option>
    </select>

    <!-- Games List -->
    <div id="game-list"></div>
</div>

<script>
    async function fetchGenres() {
        try {
            const response = await fetch('/api/genres');
            const genres = await response.json();

            const genreSelect = document.getElementById('genre');

            genres.forEach(genre => {
                let option = document.createElement('option');
                option.value = genre;
                option.textContent = genre;
                genreSelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error fetching genres:', error);
        }
    }

    async function fetchGames() {
        const genre = document.getElementById('genre').value;
        const sort = document.getElementById('sort').value;

        let url = `/api/video-games?sort=${sort}`;
        if (genre) {
            url += `&genre=${genre}`;
        }

        const response = await fetch(url, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        });
        const games = await response.json();

        let gameListHTML = "";
        games.forEach(game => {
            gameListHTML += `<p><strong>${game.title}</strong> (${game.release_date}) - ${game.genre}</p>`;
        });

        document.getElementById('game-list').innerHTML = gameListHTML;
    }

    // Fetch genres on page load
    fetchGenres();
    fetchGames();
</script>
@endsection
