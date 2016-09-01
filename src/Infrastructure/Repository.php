<?php

namespace Shortl\Shortl\Infrastructure;

use Shortl\Shortl\Contracts\Dto;

/**
 * Class Repository
 * @package Shortl\Shortl\Infrastructure
 */
abstract class Repository
{

    const fetchMode = \PDO::FETCH_ASSOC;

    /**
     * @var \PDO
     */
    private $connection;


    /**
     * @var string
     */
    protected $primary_key = 'id';


    /**
     * @var string
     */
    protected $table = '';


    /**
     * Repository constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->connection = new \PDO($config['connection_string'], $config['username'], $config['password']);
    }


    /**
     * @param Dto $dto
     * @param string $method
     * @param null $identifier
     * @param array $args
     * @return Dto
     */
    public function __invoke(Dto $dto, string $method, $identifier = null, $args = []) : Dto
    {
        return $this->{$method}($dto, $identifier, $args);
    }


    /**
     * @param Dto $dto
     * @param $identifier
     * @return Dto
     * @throws EntityNotFound
     */
    public function get(Dto $dto, $identifier) : Dto
    {
        $statement = $this->connection->prepare(sprintf('select * from %s where %s = :identifier', $this->table, $this->primary_key));
        return $this->retrieve($statement, $dto, $identifier);
    }


    /**
     * @param Dto $dto
     * @param $identifier
     * @param array $args
     * @return mixed
     * @throws EntityNotFound
     */
    public function find(Dto $dto, $identifier, $args = [])
    {
        $statement = $this->connection->prepare(sprintf('select * from %s where %s = :identifier', $this->table, $args['column']));
        return $this->retrieve($statement, $dto, $identifier);
    }


    /**
     * @param \PDOStatement $statement
     * @param Dto $dto
     * @param $identifier
     * @return mixed
     * @throws EntityNotFound
     */
    private function retrieve(\PDOStatement $statement, Dto $dto, $identifier)
    {
        $statement->execute(
            [
                ':identifier' => $identifier
            ]
        );

        $result = $statement->fetch(self::fetchMode);

        if (!$result) {
            throw new EntityNotFound();
        }

        return $dto($result);
    }


    /**
     * @param Dto $dto
     * @param $identifier
     * @param array $args
     * @return Dto
     */
    public function add(Dto $dto, $identifier, $args = [])
    {
        $statement = $this->connection->prepare(sprintf('insert into %s (%s) values (%s)', $this->table, $this->prepareKeys($dto), $this->prepareValues($dto)));

        $statement->execute(
            $dto->export()
        );

        return $dto;
    }

    /**
     * @param Dto $dto
     * @return string
     */
    private function prepareValues(Dto $dto) : string
    {
        $prepared = array_map(function ($value) {
            return ':' . $value;
        }, $dto->properties);

        return implode(', ', $prepared);
    }


    /**
     * @param Dto $dto
     * @return string
     */
    private function prepareKeys(Dto $dto) : string
    {
        return implode(', ', $dto->properties);
    }
}

class EntityNotFound extends \Exception
{
}