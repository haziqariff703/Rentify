<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CarCategories Model
 *
 * @method \App\Model\Entity\CarCategory newEmptyEntity()
 * @method \App\Model\Entity\CarCategory newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CarCategory> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CarCategory get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CarCategory findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CarCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CarCategory> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CarCategory|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CarCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CarCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CarCategory>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CarCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CarCategory> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CarCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CarCategory>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CarCategory>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CarCategory> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CarCategoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('car_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Cars relationship
        $this->hasMany('Cars', [
            'foreignKey' => 'category_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        // Policy Engine fields
        $validator
            ->decimal('security_deposit')
            ->greaterThanOrEqual('security_deposit', 0)
            ->allowEmptyString('security_deposit');

        $validator
            ->scalar('insurance_tier')
            ->inList('insurance_tier', ['basic', 'standard', 'premium'])
            ->allowEmptyString('insurance_tier');

        $validator
            ->decimal('insurance_daily_rate')
            ->greaterThanOrEqual('insurance_daily_rate', 0)
            ->allowEmptyString('insurance_daily_rate');

        $validator
            ->boolean('chauffeur_available')
            ->allowEmptyString('chauffeur_available');

        $validator
            ->decimal('chauffeur_daily_rate')
            ->greaterThanOrEqual('chauffeur_daily_rate', 0)
            ->allowEmptyString('chauffeur_daily_rate');

        $validator
            ->boolean('gps_available')
            ->allowEmptyString('gps_available');

        $validator
            ->decimal('gps_daily_rate')
            ->greaterThanOrEqual('gps_daily_rate', 0)
            ->allowEmptyString('gps_daily_rate');

        return $validator;
    }
}
