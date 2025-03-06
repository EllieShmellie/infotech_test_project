<?php 

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int     $book_id
 * @property string  $title
 * @property integer $year
 * @property string  $description
 * @property string  $isbn
 * @property string  $cover
 * @property string  $created_at
 * @property string  $updated_at
 * @property int[]   $authour_ids
 * 
 * @property AuthorBook[] $authorBooks
 * @property Author[] $authors
 */
class Book extends ActiveRecord
{

    /**
     * @var int[]
     */
    public $author_ids = [];

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function rules(): array
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['title','description'], 'string'],
            [['cover'], 'string', 'max'=> 255],
            [['isbn'], 'string', 'max' => 13],
            [['created_at', 'updated_at'], 'safe'],
            ['author_ids', 'each', 'rule' => [
                'exist', 
                'skipOnError' => true, 
                'targetClass' => Author::class, 
                'targetAttribute' => 'author_id'
            ]],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthorBooks(): ActiveQuery
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'book_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['author_id'=> 'author_id'])->via('authorBooks');
    }
}