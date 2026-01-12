<?php

declare(strict_types=1);

namespace App\Factory;

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Cake\ORM\TableRegistry;

/**
 * Abstract Factory Base Class
 *
 * Provides common functionality for all factories including:
 * - Faker instance management
 * - Table registry access
 * - Batch creation methods
 */
abstract class AbstractFactory
{
    /**
     * @var \Faker\Generator Faker instance
     */
    protected Generator $faker;

    /**
     * @var \Cake\ORM\Table Table instance
     */
    protected $table;

    /**
     * Constructor
     *
     * @param string $locale The locale for Faker (default: en_MY for Malaysia)
     */
    public function __construct(string $locale = 'en_MY')
    {
        $this->faker = FakerFactory::create($locale);
        $this->table = TableRegistry::getTableLocator()->get($this->getTableName());
    }

    /**
     * Get the table name this factory works with
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * Generate a single record definition (array of field values)
     *
     * @param array $overrides Field overrides
     * @return array
     */
    abstract public function define(array $overrides = []): array;

    /**
     * Create and save a single entity to the database
     *
     * @param array $overrides Field overrides
     * @return \Cake\ORM\Entity
     */
    public function create(array $overrides = [])
    {
        $data = $this->define($overrides);
        $entity = $this->table->newEntity($data, ['validate' => false]);
        $this->table->saveOrFail($entity);
        return $entity;
    }

    /**
     * Create multiple entities and save them to the database
     *
     * @param int $count Number of entities to create
     * @param array $overrides Field overrides applied to all entities
     * @return array Array of created entities
     */
    public function createMany(int $count, array $overrides = []): array
    {
        $entities = [];
        for ($i = 0; $i < $count; $i++) {
            $entities[] = $this->create($overrides);
        }
        return $entities;
    }

    /**
     * Generate a single record definition without saving
     *
     * @param array $overrides Field overrides
     * @return array
     */
    public function make(array $overrides = []): array
    {
        return $this->define($overrides);
    }

    /**
     * Generate multiple record definitions without saving
     *
     * @param int $count Number of definitions to generate
     * @param array $overrides Field overrides applied to all definitions
     * @return array Array of record definitions
     */
    public function makeMany(int $count, array $overrides = []): array
    {
        $definitions = [];
        for ($i = 0; $i < $count; $i++) {
            $definitions[] = $this->make($overrides);
        }
        return $definitions;
    }

    /**
     * Get the Faker instance
     *
     * @return \Faker\Generator
     */
    public function getFaker(): Generator
    {
        return $this->faker;
    }
}
