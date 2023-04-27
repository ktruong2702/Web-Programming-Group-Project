const url = 'https://www.omdbapi.com/?s=marvel&page=1&apikey=e6fc297e';

fetch(url)
  .then(response => response.json())
  .then(data => {
    const movies = data.Search;
    movies.map((movie) => {
      const title = movie.Title;
      const poster = movie.Poster;
      const listItem = `<li><img src="${poster}" alt="${title}"><h2>${title}</h2></li>`;
      document.querySelector('.movies').innerHTML += listItem;
    });
  })
  .catch(err => console.error(err));
