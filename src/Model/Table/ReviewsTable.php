<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reviews Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CarsTable&\Cake\ORM\Association\BelongsTo $Cars
 *
 * @method \App\Model\Entity\Review newEmptyEntity()
 * @method \App\Model\Entity\Review newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Review> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Review get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Review findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Review patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Review> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Review|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Review saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Review>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Review> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
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

        $this->setTable('reviews');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Cars', [
            'foreignKey' => 'car_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
            'joinType' => 'LEFT',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('car_id')
            ->notEmptyString('car_id');

        $validator
            ->integer('rating')
            ->allowEmptyString('rating');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['car_id'], 'Cars'), ['errorField' => 'car_id']);

        return $rules;
    }
}
