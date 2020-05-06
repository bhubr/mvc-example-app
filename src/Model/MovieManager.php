<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class MovieManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'movie';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $movie
     * @return int
     */
    public function insert(array $movie): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (`title`, `image_url`, `release_year`, `description`, `genre_id`) VALUES " .
            " (:title, :image_url, :release_year, :description, :genre_id)");
        $statement->bindValue('title', $movie['title'], \PDO::PARAM_STR);
        $statement->bindValue('image_url', $movie['image_url'], \PDO::PARAM_STR);
        $statement->bindValue('release_year', $movie['release_year'], \PDO::PARAM_INT);
        $statement->bindValue('description', $movie['description'], \PDO::PARAM_STR);
        $statement->bindValue('genre_id', $movie['genre_id'], \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function update($id, $movie) {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE . " SET " .
            "title = :title, image_url = :image_url, release_year = :release_year, description = :description, genre_id = :genre_id " .
            "WHERE id = :id"
        );
        $statement->bindValue('title', $movie['title'], \PDO::PARAM_STR);
        $statement->bindValue('image_url', $movie['image_url'], \PDO::PARAM_STR);
        $statement->bindValue('release_year', $movie['release_year'], \PDO::PARAM_INT);
        $statement->bindValue('description', $movie['description'], \PDO::PARAM_STR);
        $statement->bindValue('genre_id', $movie['genre_id'], \PDO::PARAM_INT);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}
