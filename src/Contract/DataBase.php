<?php

namespace Cac\SimpleBase\Contract;

interface DataBase
{
    public function all();
    public function find($id);
    public function where($name,$operator,$value);
    public function andWhere($name,$operator,$value);
    public function create(array $attributes);
    public function update(array $attributes);
    public function delete();
    public function fill(array $attributes);
    public function toArray();
    public function getAttributes();
    public function hasTimeStamps(array $attributes, $action = null);
    public function get();
    public function first();
    public function hasOne($class, $column = null);
    public function hasMany($class);
    public function belongsTo($class,$column = null,$id = null);
}
