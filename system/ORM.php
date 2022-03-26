<?php

namespace CodeIgniter;

use phpDocumentor\Reflection\DocBlock\Tags\Property;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

/**
 * @method ORM where($key, $value = null, bool $escape = null) Description
 * @method ORM orWhere($key, $value = null, bool $escape = null) Description
 * @method ORM distinct(bool $val = true)
 * @method ORM ignore(bool $ignore = true)
 * @method ORM select($select = '*', bool $escape = null)
 * @method ORM selectMax(string $select = '', string $alias = '')
 * @method ORM selectMin(string $select = '', string $alias = '')
 * @method ORM selectAvg(string $select = '', string $alias = '')
 * @method ORM selectSum(string $select = '', string $alias = '')
 * @method ORM selectCount(string $select = '', string $alias = '')
 * @method ORM from($from, bool $overwrite = false)
 * @method ORM join(string $table, string $cond, string $type = '', bool $escape = null)
 * @method ORM whereIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM orWhereIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM whereNotIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM orWhereNotIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM havingIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM orHavingIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM havingNotIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM orHavingNotIn(string $key = null, $values = null, bool $escape = null)
 * @method ORM like($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM notLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM orLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM orNotLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM havingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM notHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM orHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM orNotHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method ORM groupStart()
 * @method ORM orGroupStart()
 * @method ORM notGroupStart()
 * @method ORM orNotGroupStart()
 * @method ORM groupEnd()
 * @method ORM havingGroupStart()
 * @method ORM orHavingGroupStart()
 * @method ORM notHavingGroupStart()
 * @method ORM orNotHavingGroupStart()
 * @method ORM havingGroupEnd()
 * @method ORM groupBy($by, bool $escape = null)
 * @method ORM having($key, $value = null, bool $escape = null)
 * @method ORM orHaving($key, $value = null, bool $escape = null)
 * @method ORM orderBy(string $orderBy, string $direction = '', bool $escape = null)
 * @method ORM limit(?int $value = null, ?int $offset = 0)
 * @method ORM offset(int $offset)
 * @method ORM resetQuery()
 * @method ORM def($values = [])
 * 
 * @mixin Database\BaseBuilder
 */
class ORM {

    /**
     * 
     * @var Database\BaseConnection
     */
    private $db;

    /**
     * 
     * @var Database\BaseBuilder
     */
    public $builder;
    public $class;
    public $table = '';
    public $autoload = [];
    public $fields = [];

    /**
     * @return static
     */
    static function init($db = null) {
        return new static($db);
    }

    public function __construct($db = null) {
        $this->db = db_connect($db);
        $this->class = get_class($this);
        $c_name = explode('\\', $this->class);
        $c_name = $c_name[count($c_name) - 1];
        if (!$this->table)
            $this->table = strtolower($c_name);
        $this->builder = $this->db->table($this->table);
        $rc = new ReflectionClass($this->class);
        $factory = DocBlockFactory::createInstance();
        $docblock = $factory->create($rc->getDocComment() ?? '');
        $tags = $docblock->getTagsByName('property');
        foreach ($tags as $key => $value) {
            $type = strval($value->getType());
            $name = $value->getVariableName();
            if (!class_exists($type) && !str_contains($type, 'Collection') && !str_contains($type, '[]'))
                $fields[] = [
                    'type' => $type,
                    'name' => $name
                ];
        }
        $this->fields = $fields;
    }

    function create($prefix = null) {
        $rc = new ReflectionClass($this->class);
        $myClass = new $this->class();
        if (!$prefix) {
            $prefix = implode('_', array_map('strtolower', array_slice(explode('\\', $myClass->class), 2, -1)));
            if ($prefix)
                $prefix .= '_';
        }
        if ($prefix)
            $this->builder->setTableName($prefix . $this->table);
        $factory = DocBlockFactory::createInstance();
        $docblock = $factory->create($rc->getDocComment() ?? '');
        $tags = $docblock->getTagsByName('property');
        $fields = [];

        foreach ($tags as $key => $t) {
            // $t = new Property();
            $name = $t->getVariableName();
            $type = strval($t->getType());
            $is_relation = class_exists($type);
            if ($is_relation && !in_array($type, ['date', 'datetime', 'timestamp'])) {
                $this->relation_fields[] = $name;
                $c = new $type();
                $c->create();
                $type = $c->table . '.id';
            }
            if ($type[0] == '\\')
                $type = substr($type, 1);
            switch ($type) { //melhorar
                case 'string':
                    $type = 'text';
                    break;
            }
            if (!$name)
                continue;
            if (str_contains($type, 'Collection') || str_contains($type, '[]')) {
                $this->relation_fields[] = $name;
                continue;
            }
            if (in_array($name, ['id', 'created_at', 'updated_at']))
                continue;
            $fields[$name] = $type;
        }

        try {
            $this->builder->create($fields);
        } catch (\Throwable $th) {
            
        }
        if ($rc->hasMethod('seed'))
            if (!$this->first())
                if ($seed = $myClass->seed())
                    $this->builder->insertBatch($seed);
    }

    /**
     * 
     * @param integer $id
     * @return self|parent|static
     */
    function byId($id) {
        $this->builder->where('id', $id);
        return $this->first();
    }

    function insert(array $set = null, bool $escape = null) {
        if ($this->builder->insert($set, $escape))
            return $this->byId($this->builder->selectMax('id')->first($this->class)->id);
        else
            return null;
    }

    function relation($class, $fk, $id = null, $mode = 'many') {
        $c = new $class($this->db);
        if (!$id)
            $id = $this->id;
        return $c->where($fk, $id)->get();
    }

    function relationOne($class, $fk, $id) {
        $c = new $class($this->db);
        return $c->where($fk, $id)->first();
    }

    /**
     * 
     * @return \Tightenco\Collect\Support\Collection|self|parent|static|array|array[static]
     */
    function get(): \Tightenco\Collect\Support\Collection {
        $autoload = $this->autoload;
        $r = collect($this->builder->rs($this->class))->map(function ($v, $k) use ($autoload) {
            $r = (object) [];
            foreach ($this->fields as $key => $value) {
                $name = $value['name'];
                $r->{$name} = $v->{$name};
            }
            foreach ($autoload as $key => $value)
                $r->{$value} = $v->{$value};
            return $r;
        });
        return $r;
    }

    /**
     * 
     * @return self|this|null|parent|static
     */
    function first() {
        $v = $this->builder->first($this->class);
        $r = (object) [];
        foreach ($this->fields as $key => $value) {
            $name = $value['name'];
            $r->{$name} = $v->{$name};
        }
        foreach ($this->autoload as $key => $value)
            $r->{$value} = $v->{$value};
        return $r;
    }

    /**
     * 
     * @param string $name
     * @param array $params
     * @return Database\BaseBuilder
     */
    public function __call(string $name, array $params) {
        $result = null;
        if (method_exists($this->builder, $name))
            $result = $this->builder->{$name}(...$params);
        if (is_object($result) && !$result instanceof ORM)
            $result = $this;
        return $result;
    }

    function toJson() {
        return json_encode($this);
    }

}
