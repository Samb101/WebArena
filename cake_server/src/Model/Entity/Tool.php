<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tool Entity
 *
 * @property int $id
 * @property string $type
 * @property int $bonus
 * @property int $coordinate_x
 * @property int $coordinate_y
 * @property int $fighter_id
 *
 * @property \App\Model\Entity\Fighter $fighter
 */
class Tool extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
