<?php

namespace common\models;

use common\behaviors\BitMaskBehavior;
use Yii;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property int $id
 * @property int $departure_station_id
 * @property string $departure_time
 * @property int $arrival_station_id
 * @property string $arrival_time
 * @property string $ticket_price
 * @property int $carrier_id
 * @property int $schedule
 *
 * @property Station $arrivalStation
 * @property Carrier $carrier
 * @property Station $departureStation
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%schedule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departure_station_id', 'departure_time', 'arrival_station_id', 'arrival_time', 'ticket_price', 'carrier_id', 'schedule'], 'required'],
            [['departure_time', 'arrival_time', 'departure_station_id', 'arrival_station_id', 'carrier_id', 'schedule'], 'integer'],
            [['ticket_price'], 'number'],
            [['arrival_station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['arrival_station_id' => 'id']],
            [['carrier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrier::class, 'targetAttribute' => ['carrier_id' => 'id']],
            [['departure_station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::class, 'targetAttribute' => ['departure_station_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departure_station_id' => 'Departure Station ID',
            'departure_time' => 'Departure Time',
            'arrival_station_id' => 'Arrival Station ID',
            'arrival_time' => 'Arrival Time',
            'ticket_price' => 'Ticket Price',
            'carrier_id' => 'Carrier ID',
            'schedule' => 'Schedule',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrivalStation()
    {
        return $this->hasOne(Station::class, ['id' => 'arrival_station_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'carrier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartureStation()
    {
        return $this->hasOne(Station::class, ['id' => 'departure_station_id']);
    }

    public function extraFields()
    {
        return [
            'carrier',
            'departureStation',
            'arrivalStation'
        ];
    }

    public function behaviors()
    {
        return [
            'bitMask' => [
                'class' => BitMaskBehavior::class,
                'attribute' => 'schedule',
                'masks' => [
                    1 << 0 => 'mon',
                    1 << 1 => 'tue',
                    1 << 2 => 'wed',
                    1 << 3 => 'thu',
                    1 << 4 => 'fri',
                    1 << 5 => 'sat',
                    1 << 6 => 'sun',
                ],
            ],
        ];
    }
}
