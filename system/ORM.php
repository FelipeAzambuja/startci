<?php

namespace CodeIgniter;

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
 * @method ORM create(array $fields)
 * 
 * @mixin Database\BaseBuilder
 */
class ORM implements \JsonSerializable {

    /**
     * 
     * @var Database\BaseConnection
     */
    private $db;

    /**
     * 
     * @var Database\BaseBuilder
     */
    private $builder;
    private $class;
    public $table = '';
    public $autoload = [];

    public function __construct($db = null) {
        $this->db = db_connect($db);
        $this->class = get_class($this);
        $c_name = explode('\\', $this->class);
        $c_name = $c_name[count($c_name) - 1];
        if (!$this->table)
            $this->table = strtolower($c_name);
        $this->builder = $this->db->table($this->table);
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
        $r = collect($this->builder->rs($this->class))->map(function ($v, $k)use ($autoload) {
            foreach ($autoload as $key => $value)
                $v->{$value} = $v->{$value};
            return $v;
        });
        return $r;
    }

    /**
     * 
     * @return self|this|null|parent|static
     */
    function first() {
        $v = $this->builder->first($this->class);
        foreach ($this->autoload as $key => $value)
            $v->{$value} = $v->{$value};
        return $v;
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

    public function jsonSerialize() {
        $r = $this->builder->def();
        foreach ($r as $key => $v)
            $r->{$key} = $this->{$key};
        foreach ($this->autoload as $key => $value)
            $r->{$value} = $this->{$value};
        return $r;
    }

    function toJson() {
        return json_encode($this);
    }

}