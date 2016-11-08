<?php

// src/Model/Table/PlayersTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlayersTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('email')
            ->requirePresence('email')
            ->notEmpty('password')
            ->requirePresence('password');

        return $validator;
    }
}

?>
