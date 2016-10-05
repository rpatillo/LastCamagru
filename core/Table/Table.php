<?php
namespace  Core\Table;

use Core\Database\Database;

class Table
{
    protected $table;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name)) . 's';
        }
    }

    public function all()
    {
        return $this->query('SELECT * FROM '. $this->table);
    }

    public function find($id) {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function query($stmt, $attributes = NULL, $one = false)
    {
        if ($attributes) {
            return $this->db->prepare($stmt, $attributes, str_replace('Table', 'Entity', get_class($this)), $one);
        } else {
            return $this->db->query($stmt, str_replace('Table', 'Entity', get_class($this)), $one);
        }
    }
}