<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Admins Model
 *
 * @method \App\Model\Entity\Admin newEmptyEntity()
 * @method \App\Model\Entity\Admin newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Admin> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Admin get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Admin findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Admin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Admin> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Admin|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Admin saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Admin>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Admin>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Admin>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Admin> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Admin>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Admin>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Admin>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Admin> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminsTable extends Table
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

        $this->setTable('admins');
        $this->setDisplayField('name');
        $this->setPrimaryKey('admin_id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('role')
            ->allowEmptyString('role');

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 255)
            ->allowEmptyString('avatar');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
