<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\MovieManager;
use App\Model\GenreManager;

/**
 * Class MovieController
 *
 */
class MovieController extends AbstractController
{
  public function index() {
    $movieManager = new MovieManager();
    $movies = $movieManager->selectAll();

    return $this->twig->render('Movie/index.html.twig', ['movies' => $movies]);
  }

  public function add() {
    // Traitement de la requête en POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newMovie = [
        'title' => $_POST['title'],
        'image_url' => $_POST['image_url'],
        'release_year' => (int)$_POST['release_year'],
        'description' => $_POST['description'],
        'genre_id' => (int)$_POST['genre_id']
      ];
      $movieManager = new MovieManager();
      $id = $movieManager->insert($newMovie);
      header("Location: /movie/add");
    }

    // Traitement requête en GET

    // On va chercher la liste des genres
    // On récupère [ ['id' => 1, 'name' => 'Science-fiction'], ... ]
    $genreManager = new GenreManager();
    $genres = $genreManager->selectAll();

    return $this->twig->render('Movie/add.html.twig', ['genres' => $genres]);
  }

  public function edit(int $id) {
    // Traitement de la requête en POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedMovie = [
        'title' => $_POST['title'],
        'image_url' => $_POST['image_url'],
        'release_year' => (int)$_POST['release_year'],
        'description' => $_POST['description'],
        'genre_id' => (int)$_POST['genre_id']
      ];
      $movieManager = new MovieManager();
      $movieManager->update($id, $updatedMovie);
      header("Location: /movie/edit/" . $id);
    }

    // GET
    $movieManager = new MovieManager();
    $movie = $movieManager->selectOneById($id);

    $genreManager = new GenreManager();
    $genres = $genreManager->selectAll();

    return $this->twig->render('Movie/edit.html.twig', ['genres' => $genres, 'movie' => $movie]);
  }
}