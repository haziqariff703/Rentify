<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cars Model
 *
 * @property \App\Model\Table\CarCategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\MaintenancesTable&\Cake\ORM\Association\HasMany $Maintenances
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\Car newEmptyEntity()
 * @method \App\Model\Entity\Car newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Car> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Car get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Car findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Car patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Car> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Car|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Car saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CarsTable extends Table
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

        $this->setTable('cars');
        $this->setDisplayField('car_model');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'className' => 'CarCategories',
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'car_id',
        ]);
        $this->hasMany('Maintenances', [
            'foreignKey' => 'car_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'car_id',
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
            ->integer('category_id')
            ->allowEmptyString('category_id');

        $validator
            ->scalar('car_model')
            ->maxLength('car_model', 100)
            ->requirePresence('car_model', 'create')
            ->notEmptyString('car_model');

        $validator
            ->scalar('plate_number')
            ->maxLength('plate_number', 50)
            ->requirePresence('plate_number', 'create')
            ->notEmptyString('plate_number')
            ->add('plate_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('brand')
            ->maxLength('brand', 50)
            ->allowEmptyString('brand');

        $validator
            ->integer('year')
            ->allowEmptyString('year');

        $validator
            ->decimal('price_per_day')
            ->allowEmptyString('price_per_day');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        $validator
            ->scalar('transmission')
            ->requirePresence('transmission', 'create')
            ->notEmptyString('transmission');

        $validator
            ->integer('seats')
            ->requirePresence('seats', 'create')
            ->notEmptyString('seats');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['plate_number']), ['errorField' => 'plate_number']);
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);

        return $rules;
    }
}
