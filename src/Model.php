<?php

namespace Bdt\Example;

use Doctrine\DBAL\Connection;

class Model {
    /**
     * @var Connection
     */
    static protected $connection;
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param Connection $connection
     */
    public static function setDefaultConnection(Connection $connection)
    {
        self::$connection = $connection;
    }

    /**
     * @param $id
     * @return false|static
     */
    public static function findById($id)
    {
        $stmt = self::$connection->executeQuery(
            'SELECT * FROM '.static::getName().' WHERE id = ?',
            [$id],
            [\PDO::PARAM_INT]
        );
        $row = $stmt->fetch();
        if ($row) {
            return new static($row);
        }
        return false;
    }

    /**
     * @return array
     */
    public static function findAll()
    {
        $stmt = self::$connection->executeQuery('SELECT * FROM '.static::getName());
        $rows = $stmt->fetchAll();
        $objects = [];
        foreach ($rows as $row) {
            $objects[] = new static($row);
        }
        return $objects;
    }

    /**
     * Model constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function save()
    {
        if (isset($this->data['id'])) {
            self::$connection->update(static::getName(), $this->data, ['id' => $this->data['id']]);
        } else {
            self::$connection->insert(static::getName(), $this->data);
            $this->data['id'] = self::$connection->lastInsertId();
        }
    }

    public function delete()
    {
        self::$connection->delete(static::getName(), ['id' => $this->data['id']]);
    }

    /**
     * @param $k
     * @param $v
     */
    public function __set($k , $v)
    {
        $this->data[$k] = $v;
    }

    /**
     * @param $k
     * @return mixed|null
     */
    public function get($k)
    {
        return isset($this->data[$k]) ? $this->data[$k] : null;
    }

    /**
     * @param $k
     * @return mixed|null
     */
    public function __get($k)
    {
        return isset($this->data[$k]) ? $this->data[$k] : null;
    }

    /**
     * @param $k
     * @return bool
     */
    public function __isset($k)
    {
        return isset($this->data[$k]);
    }

    /**
     * @return string|string[]
     */
    protected static function getName()
    {
        return str_replace("app\models\\", "", strtolower(static::class).'s');
    }
}