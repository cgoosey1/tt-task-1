<?php

class SearchModel
{
    /**
     * Get all profiles including email address that match a search term
     *
     * @param $term
     * @return array
     */
    public function getSearchData($term) : array
    {
        // Create our database connection, not need to confuse this function with this extra logic.
        // Normally I would create the DB instance in a more central place like the constructor
        // ready to be easily used, but this felt like overkill for this task.
        $pdo = $this->getDB();

        // It wasn't a specification of the task, but seemed wise to return the default email address,
        // this approach assumes each profile always has a default.
        $query = $pdo->prepare("SELECT `profiles`.`UserRefID`, `Firstname`, `Surname`, `emailaddress` FROM `profiles` "
            . "LEFT JOIN emails ON `profiles`.`UserRefID` = `emails`.`UserRefID`"
            . "WHERE CONCAT(`Firstname`, ' ', `Surname`) LIKE ? AND `default` = 1");
        // Escape our search term
        $query->execute(['%' . $term . '%']);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a DB PDO instance
     *
     * @return PDO
     */
    public function getDB() : PDO {
        // Not a big fan of storing the environment variables in the code, but didn't
        // think it was worth creating a config system
        $host = '127.0.0.1';
        $db   = 'toucantech';
        $user = 'root';
        $pass = 'root';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    }
}