// Titles: https://omdbapi.com/?s=thor&page=1&apikey=e6fc297e
// details: http://www.omdbapi.com/?i=tt3896198&apikey=e6fc297e

const movieSearchBox = document.getElementById('movie-search-box');
const searchList = document.getElementById('search-list');
const resultGrid = document.getElementById('result-grid');

// load movies from API
async function loadMovies(searchTerm) {
  const URL = `https://omdbapi.com/?s=${searchTerm}&page=1&apikey=e6fc297e`;
  const res = await fetch(`${URL}`);
  const data = await res.json();
  // console.log(data.Search);
  if (data.Response == "True") displayMovieList(data.Search);
}

function findMovies() {
  let searchTerm = (movieSearchBox.value).trim();
  if (searchTerm.length > 0) {
    searchList.classList.remove('hide-search-list');
    loadMovies(searchTerm);
  } else {
    searchList.classList.add('hide-search-list');
  }
}

function displayMovieList(movies) {
  searchList.innerHTML = "";
  for (let idx = 0; idx < movies.length; idx++) {
    let movieListItem = document.createElement('div');
    movieListItem.dataset.id = movies[idx].imdbID; // setting movie id in  data-id
    movieListItem.classList.add('search-list-item');
    if (movies[idx].Poster != "N/A")
      moviePoster = movies[idx].Poster;
    else
      moviePoster = "image_not_found.png";

    movieListItem.innerHTML = `
        <div class = "search-item-thumbnail">
            <img src = "${moviePoster}">
        </div>
        <div class = "search-item-info">
            <h3>${movies[idx].Title}</h3>
            <p>${movies[idx].Year}</p>
            <p>IMDb ID: ${movies[idx].imdbID}</p>

        </div>
        `;
    searchList.appendChild(movieListItem);
  }
  loadMovieDetails();
}

function loadMovieDetails() {
  const searchListMovies = searchList.querySelectorAll('.search-list-item');
  searchListMovies.forEach(movie => {
    movie.addEventListener('click', async () => {
      // console.log(movie.dataset.id);
      searchList.classList.add('hide-search-list');
      movieSearchBox.value = "";
      const result = await fetch(`http://www.omdbapi.com/?i=${movie.dataset.id}&apikey=e6fc297e`);
      const movieDetails = await result.json();
      // console.log(movieDetails);
      displayMovieDetails(movieDetails);
    });
  });
}


function getCurrentUser() {
  return fetch('get_current_user.php')
    .then(response => {
      if (response.ok) {
        return response.json();
      } else {
        throw new Error('Failed to fetch current user');
      }
    })
    .catch(error => {
      console.error('Error fetching current user:', error);
      return null;
    });
}


function displayMovieDetails(details) {
  resultGrid.innerHTML = `
    <div class = "movie-poster">
        <img src = "${(details.Poster != "N/A") ? details.Poster : "image_not_found.png"}" alt = "movie poster">
    </div>
    <div class = "movie-info">
        <h3 class = "movie-title">${details.Title}</h3>
        <ul class = "movie-misc-info">
          <li class = "year">Year: ${details.Year}</li>
          <li class = "rated">Ratings: ${details.Rated}</li>
          <li class = "released">Released: ${details.Released}</li>            
        </ul>
        <p class = "genre"><b>Genre:</b> ${details.Genre}</p>
        <p class = "writer"><b>Writer:</b> ${details.Writer}</p>
        <p class = "actors"><b>Actors: </b>${details.Actors}</p>
        <p class = "plot"><b>Plot:</b> ${details.Plot}</p>
        <p class = "imdbID"><b>IMDb ID:</b> ${details.imdbID}</p>
        <p class = "language"><b>Language:</b> ${details.Language}</p>
        <p class = "awards"><b><i class = "fas fa-award"></i></b> ${details.Awards}</p>
        <p>Rating: <span id="rating"></span></p>
        <ul class="ratings-list">
          ${details.Ratings.map(rating => `
            <li>${rating.Source}: ${rating.Value}</li>
          `).join('')}
        </ul>
    </div>
 `;

document.querySelector('#rating-form input[name="movie_id"]').value = details.imdbID;


async function updateRating(movie_id) {
  try {
    const response = await fetch(`get_movie_rating.php?movie_id=${movie_id}`);
    if (response.ok) {
      const data = await response.json();
      if (data.rating) {
        document.getElementById('rating').innerText = data.rating;
      } else {
        document.getElementById('rating').innerText = 'Not rated yet';
      }
    } else {
      console.error('Failed to fetch movie rating');
    }
  } catch (error) {
    console.error('Error fetching movie rating:', error);
  }
}


async function submitRating(event) {
  event.preventDefault();

  const formData = new FormData();
  formData.append('movie_id', movie_id);
  formData.append('rating', event.target.rating.value);
  formData.append('user_id', event.target.user_id.value);
  
  const response = await fetch('submit_rating.php', {
    method: 'POST',
    body: formData,
  });

  if (response.ok) {
    const result = await response.json();
    if (result.success) {
      updateRating(formData.get('movie_id'));
      alert('Rating submitted successfully!');
    } else {
      alert('Failed to submit rating. Please try again.');
    }
  } else {
    alert('Failed to submit rating. Please try again.');
  }
}

 const ratingForm = document.getElementById('rating-form');

// Update user rating form with current rating if user is logged in
getCurrentUser().then(user => {
  if (user !== null) {
    // Update the user_id value in the hidden input field
    const userIdInput = ratingForm.querySelector('input[name="user_id"]');
    userIdInput.value = user.id;

    // Get the current user rating
    const ratingInput = ratingForm.querySelector('input[name="rating"]');
    const movie_id = details.imdbID;
    const userId = user.id;
    fetch(`get_user_rating.php?movie_id=${movie_id}&user_id=${userId}`)
      .then(response => response.json())
      .then(data => {
        if (data.rating) {
          ratingInput.value = data.rating;
        }
      })
      .catch(error => {
        console.error('Error fetching user rating:', error);
      });
  } else {
    // If user is null, remove the 'user_id' input field from the form
    ratingForm.querySelector('input[name="user_id"]').remove();
  }
});
}

ratingForm.addEventListener('submit', submitRating);


// Add event listener to movie links
window.addEventListener('click', (event) => {
    if(event.target.className != "form-control"){
        searchList.classList.add('hide-search-list');
    }
});